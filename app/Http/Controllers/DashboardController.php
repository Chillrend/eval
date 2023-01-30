<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\CandidatePres;
use App\Models\CandidateTes;
use App\Models\Criteria;
use App\Models\ProdiMand;
use App\Models\ProdiPres;
use App\Models\ProdiTes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function api_render()
    {
        try {
            if (request('tahun')) {
                $periode = request('tahun');
            } else {
                $periode = Carbon::now()->year;
            }
            $list_tahun = Criteria::select('tahun')
                ->groupBy('tahun')
                ->orderBy('tahun', 'desc')
                ->get()->toArray();

            for ($x = 0; $x < count($list_tahun); $x++) {
                $list_tahun[$x] = $list_tahun[$x]['tahun'];
            }

            if (is_numeric(array_search($periode, $list_tahun)) === false) {
                array_unshift($list_tahun, intval($periode));
            }

            //prodi
            $prodipres = ProdiPres::all()->count();
            $prodites = ProdiTes::all()->count();
            $prodimand = ProdiMand::all()->count();

            //tahap import
            $totalimport = 0;
            $import = [];
            $import[0] = CandidatePres::query()
                ->where('periode', intval($periode))
                ->where(function ($query) {
                    $query->where('status', 'import')
                        ->orWhere('status', 'post-import');
                })->count();
            $totalimport += ($import[0] !== null) ? intval($import[0]) : 0;

            $import[1] = CandidateTes::query()
                ->where('periode', intval($periode))
                ->where(function ($query) {
                    $query->where('status', 'post-import')
                        ->orWhere('status', 'import');
                })->count();
            $totalimport += ($import[1] !== null) ? intval($import[1]) : 0;

            $import[2] = CandidateMand::query()
                ->where('periode', intval($periode))
                ->where(function ($query) {
                    $query->where('status', 'post-import')
                        ->orWhere('status', 'import');
                })->count();
            $totalimport += ($import[2] !== null) ? intval($import[2]) : 0;



            //filter
            $filter = [];
            $filter[0] = CandidatePres::query()
                ->where('periode', intval($periode))
                ->where(function ($query) {
                    $query->where('status', 'done')
                        ->orWhere('status', 'filtered');
                })->count();
            $filter[1] = CandidateTes::query()
                ->where('periode', intval($periode))
                ->where(function ($query) {
                    $query->where('status', 'done')
                        ->orWhere('status', 'filtered');
                })->count();
            $filter[2] = CandidateMand::query()
                ->where('periode', intval($periode))
                ->where(function ($query) {
                    $query->where('status', 'done')
                        ->orWhere('status', 'filtered');
                })->count();

            $status = [];
            $status[0] =
                CandidatePres::query()
                ->select('status')
                ->where('periode', intval($periode))
                ->get()->last();

            $status[1] =
                CandidateTes::query()
                ->select('status')
                ->where('periode', intval($periode))
                ->get()->last();


            $status[2] =
                CandidateMand::query()
                ->select('status')
                ->where('periode', intval($periode))
                ->get()->last();


            $total = 0;

            // dd($status);
            for ($i = 0; $i < count($status); $i++) {
                if ($status[$i] !==  null) {
                    switch ($status[$i]['status']) {
                        case 'done':
                            $status[$i]['status'] = 100;
                            $total += $status[$i]['status'];
                            break;
                        case 'filtered':
                            $status[$i]['status'] = 75;
                            $total += $status[$i]['status'];
                            break;
                        case 'post-import':
                            $status[$i]['status'] = 50;
                            $total += $status[$i]['status'];
                            break;
                        case 'import':
                            $status[$i]['status'] = 25;
                            $total += $status[$i]['status'];
                            break;
                    }
                } else {
                    $status[$i]['status'] = 0;
                }
            }

            $total = $total / 3;

            return response()->json([
                'tahun' => [
                    'list' => $list_tahun,
                    'status' => $periode,
                ],
                'total' => $totalimport,
                'pres' => [
                    'prodi' => $prodipres,
                    'import' => $import[0],
                    'filter' => $filter[0],
                ],
                'tes' => [
                    'prodi' => $prodites,
                    'import' => $import[1],
                    'filter' => $filter[1],
                ],
                'mandiri' => [
                    'prodi' => $prodimand,
                    'import' => $import[2],
                    'filter' => $filter[2],
                ],
                'status' => [
                    'total' => $total,
                    'pres' => $status[0]['status'],
                    'tes'  => $status[1]['status'],
                    'mandiri' => $status[2]['status'],
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
