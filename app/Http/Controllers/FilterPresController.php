<?php

namespace App\Http\Controllers;

use App\Models\CandidatePres;
use App\Models\Criteria;
use App\Models\ProdiPres;
use Exception;

class FilterPresController extends Controller
{
    public function render()
    {
        return view('halaman.filter-prestasi', [
            'type_menu' => 'prestasi',
        ]);
    }

    public function getTahun()
    {
        try {
            $filter = CandidatePres::select('periode')
                ->where(function ($query) {
                    $query->where('status', 'filtered')
                        ->orWhere('status', 'done');
                })
                ->groupBy('periode')
                ->orderBy('periode', 'desc')
                ->get()->toArray();
            $list_tahun = CandidatePres::select('periode')
                ->where('status', 'post-import')
                ->where(function ($query) use ($filter) {
                    foreach ($filter as $wherenot) {
                        $query->where('periode', '!=', $wherenot['periode']);
                    }
                })
                ->groupBy('periode')
                ->orderBy('periode', 'desc')
                ->get()->toArray();
            for ($x = 0; $x < count($list_tahun); $x++) {
                $list_tahun[$x] = $list_tahun[$x]['periode'];
            }

            return response()->json([
                'list_tahun' => $list_tahun,
            ]);
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getPend()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            $tahun = request('tahun');
            return response()->json([
                'pendidikan' => [
                    'D2', 'D3', 'S1', 'S2'
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getKolom()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
            ]);

            $tahun = request('tahun');
            $pendidikan = request('pendidikan');

            $criteria = Criteria::select('kolom')->where('table', 'candidates_pres')->where('tahun', intval($tahun))->first();

            $tahun_template = Criteria::select('tahun')
                ->where('table', 'filter_candidates_pres')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->get()->toArray();
            for ($x = 0; $x < count($tahun_template); $x++) {
                $tahun_template[$x] = $tahun_template[$x]['tahun'];
            }

            return response()->json([
                'kolom_filter'   => $criteria->kolom,
                'kolom'          => $criteria->kolom,
                'tahun_template' => $tahun_template,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function api_render()
    {
        try {
            $this->validate(request(), [
                'jurusan_kolom' => 'required',
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
            ]);

            $jurusan_kolom = request('jurusan_kolom');
            $tahun = request('tahun');
            $pendidikan = request('pendidikan');
            $filter = request('filter') ? request('filter') : null;

            $response = FilterPresController::filtering($jurusan_kolom, $tahun, $pendidikan, $filter);
            $response = $response->original;

            return response()->json([
                'candidates'     => $response['candidates'],
                'kolom'          => $response['kolom'],
            ]);
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function filtering($jurusan_kolom, $tahun, $pendidikan, $filter)
    {
        if (CandidatePres::query()->where('status', 'post-import')->exists()) {

            $criteria = Criteria::select('kolom', 'binding')->where('table', 'candidates_pres')->where('tahun', intval($tahun))->first();
            $bind = $criteria->binding;

            $prodi = ProdiPres::all()->toArray();

            //binding - kuota
            if ($bind) {
                for ($index = 0; $index < count($bind); $index++) {
                    $i = array_search($bind[$index]['id_obj'], array_column($prodi, 'id'));
                    $bind[$index]['kuota'] = $prodi[$i]['kuota'];
                    $bind[$index]['nama'] = $prodi[$i]['prodi'];
                }
            } else {
                throw new Exception("Pastikan telah melakukan binding prodi");
            }

            //ambil candidates
            $candidates = CandidatePres::query()->where('periode', intval($tahun))
                ->when($filter, function ($query) use ($filter) {
                    return $query->where(function ($query) use ($filter) {
                        for ($a = 0; $a < count($filter); $a++) {
                            $query->where($filter[$a][0], $filter[$a][1], intval($filter[$a][2]));
                        }
                    });
                })
                ->get()->toArray();

            //kuota
            try {
                $final = [];
                foreach ($bind as $binds) {
                    for ($i = 0; $i < $binds['kuota']; $i++) {
                        $a = array_search($binds['bind_prodi'], array_column($candidates, $jurusan_kolom));
                        if (is_numeric($a)) {
                            array_push($final, $candidates[$a]);
                            unset($candidates[$a]);
                            $candidates = array_values($candidates);
                        }
                    }
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'error' => 'Silahkan pilih kolom yang lain untuk jurusan'
                ]);
            }

            $kolom = $criteria->kolom;
            return response()->json([
                'candidates' => $final,
                'kolom' => $kolom,
            ]);
        } else {
            return response()->json([
                'eror' => 'Silahkan untuk menyimpan hasil import calon mahasiswa'
            ]);
        }
    }

    public function api_save()
    {
        try {
            $this->validate(request(), [
                'jurusan_kolom' => 'required',
                'tahun' => 'required|numeric',
                'pendidikan' => 'required',
            ]);
            $jurusan_kolom = request('jurusan_kolom');
            $tahun = request('tahun');
            $pendidikan = request('pendidikan');
            $filteri = request('filter') ? request('filter') : null;

            $operator = [];
            $filter = [];

            if ($filteri != null) {
                for ($i = 0; $i < count($filteri); $i++) {
                    $filter[$i]['kolom'] = $filteri[$i][0];
                    $filter[$i]['nilai'] = $filteri[$i][2];
                    match ($filteri[$i][1]) {
                        '=' => $filter[$i]['operator'] = 'et',
                        '>' => $filter[$i]['operator'] = 'gt',
                        '<' => $filter[$i]['operator'] = 'lt',
                        '>=' => $filter[$i]['operator'] = 'gtet',
                        '<=' => $filter[$i]['operator'] = 'ltet',
                        '<>' => $filter[$i]['operator'] = 'net',
                    };
                    $operator[$i] = strtolower($filteri[$i][1]);
                }
            } else {
                $filter = null;
            }

            $criteria = array(
                'tahun' => intval($tahun),
                'kolom' => $filter,
                'table' => 'filter_candidates_pres',
                'kode_criteria' => strval($tahun) . '_filter_candidates_pres',
            );

            $response = FilterPresController::filtering($jurusan_kolom, $tahun, $pendidikan, $filteri);
            $response = $response->original;
            $candidates = $response['candidates'];

            for ($i = 0; $i < count($candidates); $i++) {
                $candidates[$i]['status'] = "filtered";
            }

            CandidatePres::insert($candidates);

            if (Criteria::query()->where('kode_criteria', strval($tahun) . '_filter_candidates_pres')->exists()) {
                Criteria::query()->where('kode_criteria', strval($tahun) . '_filter_candidates_pres')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            return response()->json([
                'status' => 'Filter Calon Mahasiswa ' . $tahun . ' Berhasil',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getFilter()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            $criteria = Criteria::select('kolom')->where('table', 'filter_candidates_pres')->where('tahun', intval(request('tahun')))->first();
            $kolom = [];
            if ($criteria->kolom) {
                foreach ($criteria->kolom as $ckolom) {
                    match ($ckolom['operator']) {
                        'et' => $ckolom['operator'] = '=',
                        'gt' => $ckolom['operator'] = '>',
                        'lt' => $ckolom['operator'] = '<',
                        'gtet' => $ckolom['operator'] = '>=',
                        'ltet' => $ckolom['operator'] = '<=',
                        'net' => $ckolom['operator'] = '<>',
                    };
                    array_push($kolom, $ckolom);
                }
            }
            return response()->json([
                'kolom' => $kolom,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
