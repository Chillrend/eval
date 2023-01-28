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
            $check = CandidateMand::all()->toArray();
            if ($check != null) {
                if (request('tahun')) {
                    $periode = request('tahun');
                } else {
                    $periode = CandidateMand::select('periode')
                        ->groupBy('periode')
                        ->first()->toArray();
                    $periode = $periode['periode'];
                }

                if (CandidateMand::query()->where('periode', intval($periode))->doesntExist()) {
                    throw new Exception("Data Tahun " . strval($periode) . " Seleksi Periode Tidak Ditemukan ", 1);
                }
                $tahun = CandidateMand::select('periode')->groupBy('periode')->get();
                for ($x = 0; $x < count($tahun); $x++) {
                    $tahun[$x] = $tahun[$x]['periode'];
                }
                $respones = [
                    'tahun' => $tahun,
                    'periode' => $periode,
                ];

                // Import - PostImport
                $import = CandidateMand::query()
                    ->where('periode', intval($periode))
                    ->where(function ($query) {
                        $query->where('status', 'import')
                            ->orWhere('status', 'post-import');
                    })->get();
                $criteria = Criteria::select('kolom')->where('table', 'candidates_mand')->where('tahun', intval($periode))->first()->toArray();
                $status = $import->first()->status;

                $respones += [
                    'import' => [
                        'candidates' => $import,
                        'kolom' => $criteria['kolom'],
                        'status' => $status,
                    ],
                ];

                //filter
                if (CandidateMand::query()->where('periode', intval($periode))->where('status', 'filtered')->exists()) {
                    $filter = CandidateMand::query()->where('periode', intval($periode))->where('status', 'filtered')->get();

                    $respones += [
                        'filter' => [
                            'candidates' => $filter,
                            'kolom' => $criteria['kolom'],
                        ],
                    ];
                }

                //done
                if (CandidateMand::query()->where('periode', intval($periode))->where('status', 'done')->exists()) {
                    $done = CandidateMand::query()->where('periode', intval($periode))->where('status', 'done')->get();

                    $respones += [
                        'done' => [
                            'candidates' => $done,
                            'kolom' => $criteria['kolom'],
                        ],
                    ];
                }

                return response()->json($respones);
            } else {
                throw new Exception('Data Calon Mahasiswa Kosong. Silahkan Lakukan Import', 1);
            }
        } catch (Exception $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
