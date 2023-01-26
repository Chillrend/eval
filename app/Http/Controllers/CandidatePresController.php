<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\CandidatePres;
use App\Models\Criteria;
use Exception;
use Illuminate\Support\Facades\Session;

class CandidatePresController extends Controller
{
    public function api_import()
    {
        try {
            $this->validate(request(), [
                'tahunperiode' => 'required|numeric',
                'excel' => 'required|file|mimes:csv,xlsx,xls',
                'collumn' => 'required',
            ]);

            $array = (new CandidatesImport())->toArray(request('excel'));
            $namedkey = request('collumn');

            $periode = request('tahunperiode');

            $criteria = array(
                'tahun'         => intval($periode),
                'kolom'         => $namedkey,
                'binding'       => null,
                'bobot'         => null,
                'table'         => 'candidates_pres',
                'kode_criteria' => strval($periode) . '_candidates_pres',
            );

            for ($i = 0; $i < count($array[0]); $i++) {
                for ($ab = 0; $ab < count($namedkey); $ab++) {
                    if (array_key_exists($namedkey[$ab], $array[0][$i]) == false) {
                        throw new Exception('Kolom ' . strval($namedkey[$ab]) . ' tidak ditemukan', 1);
                    }
                    if (ctype_digit(trim($array[0][$i][$namedkey[$ab]]))) {
                        $fil[$namedkey[$ab]] = intval($array[0][$i][$namedkey[$ab]]);
                    } else {
                        $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                    }
                };
                $fil['periode'] = intval($periode);
                $fil['status'] = 'import';
                $filtered[] = $fil;
            }
            if (Criteria::query()->where('kode_criteria', strval($periode) . '_candidates_pres')->exists()) {
                Criteria::query()->where('kode_criteria', strval($periode) . '_candidates_pres')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            CandidatePres::query()->where('periode', intval($periode))->delete();
            CandidatePres::insert($filtered);

            return response()->json([
                'status' => 'Data Calon Mahasiswa Tahun ' . request('tahun') . ' Berhasil Diupload',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function render(Request $request)
    {
        return view('halaman.candidate-prestasi', [
            'type_menu' => 'prestasi'
        ]);
    }

    public function api_render()
    {
        try {
            $tahun_template = Criteria::select('tahun')->where('table', 'candidates_pres')->get();
            for ($x = 0; $x < count($tahun_template); $x++) {
                $tahun_template[$x] = $tahun_template[$x]['tahun'];
            }

            if (CandidatePres::query()->where('status', 'import')->exists()) {
                if (request('tahun')) {
                    $tahun = request('tahun');
                } else {
                    $tahun = CandidatePres::select('periode')
                        ->where('status', 'import')
                        ->first()->toArray();
                    $tahun = $tahun['periode'];
                }

                $candidates = CandidatePres::query()->where('status', 'import')->where('periode', intval($tahun))->get();

                $tahun_import = CandidatePres::select('periode')
                    ->where('status', 'import')
                    ->groupBy('periode')
                    ->orderBy('periode', 'desc')
                    ->get()->toArray();
                for ($x = 0; $x < count($tahun_import); $x++) {
                    $tahun_import[$x] = $tahun_import[$x]['periode'];
                }

                $kolom = Criteria::select('kolom')->where('table', 'candidates_pres')->where('tahun', intval($tahun))->get();
                $kolom[0] = $kolom[0]['kolom'];

                return response()->json([
                    'tahun_template' => $tahun_template,
                    'tahun_import' => $tahun_import,
                    'candidates' => $candidates,
                    'kolom' => $kolom,
                    'status' => [
                        'tahun' => $tahun,
                    ]
                ]);
            } else {
                return response()->json([
                    'tahun_template' => $tahun_template,
                    'tahun_import' =>  null,
                    'candidates' => null,
                    'kolom' => null,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function api_cancel()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            CandidatePres::query()->where('status', 'import')->where('periode', intval(request('tahun')))->delete();
            return response()->json([
                'status' => 'Data Calon Mahasiswa Tahun ' . request('tahun') . ' Berhasil Dibatalkan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function api_save()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            CandidatePres::query()->where('status', 'import')->where('periode', intval(request('tahun')))->update(['status' => 'post-import']);
            return response()->json([
                'status' => 'Data Calon Mahasiswa Tahun ' . request('tahun') . ' Berhasil Disimpan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }


    public function criteria()
    {
        try {
            $this->validate(request(), [
                'tahun' => 'required|numeric',
            ]);
            $criteria = Criteria::select('kolom')->where('table', 'candidates_pres')->where('tahun', intval(request('tahun')))->first();

            return response()->json([
                'criteria' => $criteria->kolom,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
