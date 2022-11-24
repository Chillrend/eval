<?php

namespace App\Http\Controllers;

use App\Models\CandidateTes;
use App\Models\Criteria;
use App\Models\ProdiTes;

class PreviewTesController extends Controller
{

    public function render()
    {
        $periode = (request('tahun')) ? request('tahun') : strval(date("Y"));

        $candidates = CandidateTes::query()->where('periode', intval($periode))->where('periode', intval($periode))->paginate(10);
        $tahun = CandidateTes::select('periode')->groupBy('periode')->get();
        $criteria = Criteria::select('kolom')->where('table', 'candidates_tes')->where('tahun', intval($periode))->first()->toArray();
        $status = $candidates->first()->status;

        switch ($status) {
            case 'import':
                $statuss = 1/4*100;
                break;
            case 'post-import':
                $statuss = 2/4*100;
                break;
            case 'filtered':
                $statuss = 3/4*100;
                break;
            case 'done':
                $statuss = 4/4*100;
                break;
                
            default:
                $statuss = 0/4*100;
                break;
        }

        return view('halaman.preview-tes',[
            'type_menu' => 'tes',
            'candidates' => $candidates,
            'tahun' => $tahun,
            'criteria' =>$criteria['kolom'],
            'status' => [$statuss, $status, request('tahun')],
        ]);
    }
}