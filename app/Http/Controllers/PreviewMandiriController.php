<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\Criteria;
use App\Models\ProdiMand;

class PreviewMandiriController extends Controller
{ 
    public function render()
    {

        $canpres = CandidateMand::query()->where('status',1)->paginate(10);
            
        $propres = ProdiMand::query()->where('status',1)->paginate(10);

        $criteriacan = Criteria::query()->where('table', 'candidates_mand')->first();
        $criteriaprodi = Criteria::query()->where('table', 'prodi_mand')->first();

        return view('halaman.preview-mandiri',[
            'type_menu' => 'mandiri',
            'candidates' => $canpres,
            'prodi' => $propres,
            'criteria_can' => $criteriacan,
            'criteria_pro' => $criteriaprodi
        ]);
    }

}