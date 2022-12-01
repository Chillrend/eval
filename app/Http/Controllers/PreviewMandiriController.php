<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\Criteria;
use Exception;

class PreviewMandiriController extends Controller
{
    public function render()
    {
        return view('halaman.preview-mandiri', [
            'type_menu' => 'mandiri',
        ]);
    }

    public function api_render()
    {
        try {
            if (CandidateMand::query()->exists()) {
                if (request('tahun')) {
                    $periode = request('tahun');
                } else {
                    $periode = CandidateMand::select('periode')
                        ->groupBy('periode')
                        ->first()->toArray();
                    $periode = $periode['periode'];
                }

                $candidates = CandidateMand::query()->where('periode', intval($periode))->where('periode', intval($periode))->get();
                $tahun = CandidateMand::select('periode')->groupBy('periode')->get();
                for ($x = 0; $x < count($tahun); $x++) {
                    $tahun[$x] = $tahun[$x]['periode'];
                }

                $criteria = Criteria::select('kolom')->where('table', 'candidates_mand')->where('tahun', intval($periode))->first();
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

                //     return response()->json([
                //         'candidates' => $candidates,
                //         'tahun' => $tahun,
                //         'criteria' => $criteria['kolom'],
                //         'status' => [
                //             'progress' => $statuss,
                //             'status' => $status,
                //             'periode' => $periode
                //         ],
                //     ]);
                // } else {
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
