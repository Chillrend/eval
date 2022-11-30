<?php

namespace App\Http\Controllers;

use App\Models\CandidatePres;
use App\Models\Criteria;
use Exception;

class PreviewPresController extends Controller
{
    public function render()
    {
        return view('halaman.preview-prestasi', [
            'type_menu' => 'prestasi',
        ]);
    }

    public function api_render()
    {
        try {
            if (CandidatePres::query()->exists()) {
                if (request('tahun')) {
                    $periode = request('tahun');
                } else {
                    $periode = CandidatePres::select('periode')
                        ->groupBy('periode')
                        ->first()->toArray();
                    $periode = $periode['periode'];
                }
                $candidates = CandidatePres::query()->where('periode', intval($periode))->where('periode', intval($periode))->get();
                $tahun = CandidatePres::select('periode')->groupBy('periode')->get();
                for ($x = 0; $x < count($tahun); $x++) {
                    $tahun[$x] = $tahun[$x]['periode'];
                }

                $criteria = Criteria::select('kolom')->where('table', 'candidates_pres')->where('tahun', intval($periode))->first()->toArray();
                $status = $candidates->first()->status;

                switch ($status) {
                    case 'import':
                        $statuss = 1 / 4 * 100;
                        break;
                    case 'post-import':
                        $statuss = 2 / 4 * 100;
                        break;
                    case 'filtered':
                        $statuss = 3 / 4 * 100;
                        break;
                    case 'done':
                        $statuss = 4 / 4 * 100;
                        break;

                    default:
                        $statuss = 0 / 4 * 100;
                        break;
                }

                return response()->json([
                    'candidates' => $candidates,
                    'tahun' => $tahun,
                    'criteria' => $criteria['kolom'],
                    'status' => [
                        'progress' => $statuss,
                        'status' => $status,
                        'periode' => $periode
                    ],
                ]);
            } else {
                return response()->json([
                    'error' => 'Data Calon Mahasiswa Kosong. Silahkan Lakukan Import',
                ]);
            }
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
