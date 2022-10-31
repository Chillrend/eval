<?php

namespace App\Http\Controllers;

use App\Models\CandidatePres;
use App\Models\Criteria;
use App\Models\ProdiPres;
// use Illuminate\Support\Facades\Session;
use Maatwebsite\Fascades\Excel;
use Jenssegers\Mongodb\Eloquent\Model;

class PreviewPresController extends Controller
{ 
    public function render()
    {

        $canpres = CandidatePres::query()->where('status',1)->paginate(10);
            
        $propres = ProdiPres::query()->where('status',1)->paginate(10);

        $criteriacan = Criteria::query()->where('table', 'candidates_pres')->first();
        $criteriaprodi = Criteria::query()->where('table', 'prodi_pres')->first();

        return view('halaman.preview-prestasi',[
            'type_menu' => 'prestasi',
            'candidates' => $canpres,
            'prodi' => $propres,
            'criteria_can' => $criteriacan,
            'criteria_pro' => $criteriaprodi
        ]);
    }

}