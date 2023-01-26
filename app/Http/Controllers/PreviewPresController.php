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
            $check = CandidatePres::all()->toArray();
            if ($check != null) {
                if (request('tahun')) {
                    $periode = request('tahun');
                } else {
                    $periode = CandidatePres::select('periode')
                        ->groupBy('periode')
                        ->first()->toArray();
                    $periode = $periode['periode'];
                }

                if (CandidatePres::query()->where('periode', intval($periode))->doesntExist()) {
                    throw new Exception("Data Tahun " . strval($periode) . " Seleksi Periode Tidak Ditemukan ", 1);
                }
                $tahun = CandidatePres::select('periode')->groupBy('periode')->get();
                for ($x = 0; $x < count($tahun); $x++) {
                    $tahun[$x] = $tahun[$x]['periode'];
                }
                $respones = [
                    'tahun' => $tahun,
                    'periode' => $periode,
                ];

                // Import - PostImport
                $import = CandidatePres::query()
                    ->where('periode', intval($periode))
                    ->where(function ($query) {
                        $query->where('status', 'import')
                            ->orWhere('status', 'post-import');
                    })->get();
                $criteria = Criteria::select('kolom')->where('table', 'candidates_pres')->where('tahun', intval($periode))->first()->toArray();
                $status = $import->first()->status;

                $respones += [
                    'import' => [
                        'candidates' => $import,
                        'kolom' => $criteria['kolom'],
                        'status' => $status,
                    ],
                ];

                //filter
                if (CandidatePres::query()->where('periode', intval($periode))->where('status', 'filtered')->exists()) {
                    $filter = CandidatePres::query()->where('periode', intval($periode))->where('status', 'filtered')->get();

                    $respones += [
                        'filter' => [
                            'candidates' => $filter,
                            'kolom' => $criteria['kolom'],
                        ],
                    ];
                }

                //done
                if (CandidatePres::query()->where('periode', intval($periode))->where('status', 'done')->exists()) {
                    $done = CandidatePres::query()->where('periode', intval($periode))->where('status', 'done')->get();

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
