<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\Criteria;
use App\Models\ProdiMand;

class PreviewMandiriController extends Controller
{ 
    public function render()
    {

        $periode = strval(now()->year);

        $candidates = CandidateMand::query()->where('periode', intval($periode))->paginate(10);
        $tahun = CandidateMand::select('periode')->groupBy('periode')->get()->toArray();
        $criteria = Criteria::select('kolom')->where('table', 'candidates_mand')->where('tahun', $periode)->first();
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

        return view('halaman.preview-mandiri',[
            'type_menu' => 'mandiri',
            'candidates' => $candidates,
            'tahun' => $tahun,
            'criteria' =>$criteria->kolom,
            'status' => [$statuss, $status],
        ]);
    }

}