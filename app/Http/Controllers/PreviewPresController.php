<?php

namespace App\Http\Controllers;

use App\Models\CandidatePres;
use App\Models\CandidateTes;
use App\Models\Criteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Prestasi;
use App\Models\Prodi;
use App\Models\ProdiPres;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Session;
use Maatwebsite\Fascades\Excel;
use Jenssegers\Mongodb\Eloquent\Model;

class PreviewPresController extends Controller
{ 
    public function render()
    {

        $periode = strval(now()->year);

        $candidates = CandidatePres::query()->where('periode', intval($periode))->paginate(10);
        $tahun = CandidatePres::select('periode')->groupBy('periode')->get()->toArray();
        $criteria = Criteria::select('kolom')->where('table', 'candidates_pres')->where('tahun', $periode)->first();
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
        return view('halaman.preview-prestasi',[
            'type_menu' => 'prestasi',
            'candidates' => $candidates,
            'tahun' => $tahun,
            'criteria' =>$criteria->kolom,
            'status' => [$statuss, $status],
        ]);
    }

}