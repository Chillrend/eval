<?php

namespace App\Http\Controllers;

use App\Models\CandidateTes;
use App\Models\Criteria;
use App\Models\ProdiTes;

class PreviewTesController extends Controller
{

    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;
    public function render()
    {

        $cantes = CandidateTes::query()->where('status',1)->paginate(10);
            
        $protes = ProdiTes::query()->where('status',1)->paginate(10);

        $criteriacan = Criteria::query()->where('table', 'candidates_tes')->first();
        $criteriaprodi = Criteria::query()->where('table', 'prodi_tes')->first();

        return view('halaman.preview-tes',[
            'type_menu' => 'tes',
            'candidates' => $cantes,
            'prodi' => $protes,
            'criteria_can' => $criteriacan,
            'criteria_pro' => $criteriaprodi
        ]);
    }

}