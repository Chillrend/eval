<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\Criteria;
use App\Models\ProdiMand;
use Exception;

class FilterMandiriController extends Controller
{
    public function render()
    {
        return view('halaman.filter-mandiri', [
            'type_menu' => 'mandiri',
        ]);
    }

    public function getTahun()
    {
        try {
            $list_tahun = CandidateMand::select('periode')
                ->where('status', 'post-import')
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

            $criteria = Criteria::select('bobot', 'kolom')->where('table', 'candidates_mand')->where('tahun', intval($tahun))->first();

            // pisahin bobot
            $bobot = (array) $criteria->bobot;
            if ($bobot) {
                $tambahan = [];
                foreach ($bobot as $bobott) {
                    if ($bobott['tipe'] == 'tambahan') {
                        array_push($tambahan, $bobott);
                    }
                }
            } else {
                throw new Exception("Pastikan telah melakukan pembobotan");
            }

            $kolom_filter = [];
            foreach ($tambahan as $bobott) {
                array_push($kolom_filter, $bobott['kolom']);
            }

            $tahun_template = Criteria::select('tahun')
                ->where('table', 'filter_candidates_mand')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->get()->toArray();
            for ($x = 0; $x < count($tahun_template); $x++) {
                $tahun_template[$x] = $tahun_template[$x]['tahun'];
            }

            return response()->json([
                'kolom_filter'   => $kolom_filter,
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

            $response = FilterMandiriController::filtering($jurusan_kolom, $tahun, $pendidikan, $filter);
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
        if (CandidateMand::query()->where('status', 'post-import')->exists()) {

            $criteria = Criteria::select('bobot', 'kolom', 'binding')->where('table', 'candidates_mand')->where('tahun', intval($tahun))->first();
            $bind = $criteria->binding;

            $prodi = ProdiMand::all()->toArray();

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

            // pisahin bobot
            $bobot = (array) $criteria->bobot;
            if ($bobot) {
                $bobobot = [
                    'prioritas' => [],
                    'pembobotan' => [],
                    'tambahan' => [],
                ];
                foreach ($bobot as $bobott) {
                    switch ($bobott['tipe']) {
                        case 'prioritas':
                            array_push($bobobot['prioritas'], $bobott);
                            break;
                        case 'pembobotan':
                            array_push($bobobot['pembobotan'], $bobott);
                            break;
                        case 'tambahan':
                            array_push($bobobot['tambahan'], $bobott);
                            break;
                        default:
                            return response()->json([
                                'eror' => 'Terjadi Error'
                            ]);
                            break;
                    }
                }
            } else {
                throw new Exception("Pastikan telah melakukan pembobotan");
            }

            //ambil non prioritas
            $nonprio = CandidateMand::query()->where('status', 'post-import')->where('periode', intval($tahun))
                ->where(function ($query) use ($bobobot) {
                    foreach ($bobobot['prioritas'] as $bobott) {
                        $query->where($bobott['kolom'], '!=', $bobott['nilai']);
                    }
                })
                ->when($filter, function ($query) use ($filter) {
                    return $query->orWhere(function ($query) use ($filter) {
                        for ($a = 0; $a < count($filter); $a++) {
                            $query->where($filter[$a][0], $filter[$a][1], intval($filter[$a][2]));
                        }
                    });
                })
                ->get()->toArray();

            //total
            for ($i = 0; $i < count($nonprio); $i++) {
                $total = 0;
                if ($bobobot['pembobotan']) {
                    $val = 0;
                    foreach ($bobobot['pembobotan'] as $bobotan) {
                        if ($nonprio[$i][$bobotan['kolom']] == $bobotan['nilai']) {
                            $val = intval($bobotan['bobot']);
                        }
                    }
                    $total += $val;
                }
                if ($bobobot['tambahan']) {
                    $val = 0;
                    foreach ($bobobot['tambahan'] as $bobotan) {
                        $val += intval($nonprio[$i][$bobotan['kolom']]);
                    }
                    $total += $val;
                }
                $nonprio[$i]['total'] = $total;
            }

            //sorting
            $nonprio = collect($nonprio);

            $nonprio = $nonprio->sortBy([
                ['total', 'desc'],
            ]);

            $candidates = $nonprio->all();

            //ambil prioritas
            if (isset($bobobot['prioritas'])) {
                $prioritas = CandidateMand::query()->where('status', 'post-import')->where('periode', intval($tahun))
                    ->orWhere(function ($query) use ($bobobot) {
                        foreach ($bobobot['prioritas'] as $bobott) {
                            $query->orWhere($bobott['kolom'], $bobott['nilai']);
                        }
                    })->get()->toArray();
                if ($prioritas != null) {
                    $candidates  = array_merge($prioritas, $candidates);
                }
            }

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
            array_push($kolom, 'total');
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
                'table' => 'filter_candidates_mand',
                'kode_criteria' => strval($tahun) . '_filter_candidates_mand',
            );

            $response = FilterMandiriController::filtering($jurusan_kolom, $tahun, $pendidikan, $filteri);
            $response = $response->original;
            $candidates = $response['candidates'];

            for ($i = 0; $i < count($candidates); $i++) {
                $candidates[$i]['status'] = "filtered";
            }

            CandidateMand::query()->where('status', 'post-import')->where('periode', intval($tahun))->delete();
            CandidateMand::insert($candidates);

            if (Criteria::query()->where('kode_criteria', strval($tahun) . '_filter_candidates_mand')->exists()) {
                Criteria::query()->where('kode_criteria', strval($tahun) . '_filter_candidates_mand')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            return response()->json([
                'status' => 'Filter Calon Mahasiswa ' . $tahun . ' Berhasil',
                'redirect' => route('api_renderPreviewMand')
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
            $criteria = Criteria::select('kolom')->where('table', 'filter_candidates_mand')->where('tahun', intval(request('tahun')))->first();
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
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
