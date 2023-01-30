<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\CandidateMand;
use App\Models\Criteria;
use Exception;
use Illuminate\Support\Facades\Session;

class CandidateMandiriController extends Controller
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

            if (CandidateMand::query()->where('periode', intval($periode))->where('status', 'done')->exists()) {
                throw new Exception("Data telah dikunci dan tidak bisa diiput lagi", 1);
            }

            $criteria = array(
                'tahun'         => intval($periode),
                'kolom'         => $namedkey,
                'binding'       => null,
                'bobot'         => null,
                'table'         => 'candidates_mand',
                'kode_criteria' => strval($periode) . '_candidates_mand',
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
            if (Criteria::query()->where('kode_criteria', strval($periode) . '_candidates_mand')->exists()) {
                Criteria::query()->where('kode_criteria', strval($periode) . '_candidates_mand')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            CandidateMand::query()->where('periode', intval($periode))->delete();
            CandidateMand::insert($filtered);

            return response()->json([
                'status' => 'Data Calon Mahasiswa Tahun ' . request('tahunperiode') . ' Berhasil Diupload',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function render(Request $request)
    {
        return view('halaman.candidate-mandiri', [
            'type_menu' => 'mandiri',
        ]);
    }

    public function api_render()
    {
        try {
            $tahun_template = Criteria::select('tahun')->where('table', 'candidates_mand')->get();
            for ($x = 0; $x < count($tahun_template); $x++) {
                $tahun_template[$x] = $tahun_template[$x]['tahun'];
            }

            if (CandidateMand::query()->where('status', 'import')->exists()) {
                if (request('tahun')) {
                    $tahun = request('tahun');
                } else {
                    $tahun = CandidateMand::select('periode')
                        ->where('status', 'import')
                        ->first()->toArray();
                    $tahun = $tahun['periode'];
                }

                $candidates = CandidateMand::query()->where('status', 'import')->where('periode', intval($tahun))->get();

                $tahun_import = CandidateMand::select('periode')
                    ->where('status', 'import')
                    ->groupBy('periode')
                    ->orderBy('periode', 'desc')
                    ->get()->toArray();
                for ($x = 0; $x < count($tahun_import); $x++) {
                    $tahun_import[$x] = $tahun_import[$x]['periode'];
                }

                $kolom = Criteria::select('kolom')->where('table', 'candidates_mand')->where('tahun', intval($tahun))->get();
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
            CandidateMand::query()->where('status', 'import')->where('periode', intval(request('tahun')))->delete();
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
            CandidateMand::query()->where('status', 'import')->where('periode', intval(request('tahun')))->update(['status' => 'post-import']);
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
            $criteria = Criteria::select('kolom')->where('table', 'candidates_mand')->where('tahun', intval(request('tahun')))->first();

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
