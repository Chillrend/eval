<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\Criteria;
use Illuminate\Http\Request;

class FilterMandiriController extends Controller
{
    public function render()
    {
        $search = request('search');
        $collumn = request('kolom');
        $candidates = CandidateMand::query()->where('status',1)
            ->when( $search && $collumn, function($query) use ($collumn,$search) {
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->paginate(10);

        $criteria = Criteria::query()->where('table', 'candidates_mand')->get();

        return view('halaman.candidate-mandiri',[
            'type_menu' => 'mandiri',
            'candidates' => $candidates,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
        ]);    
    }
}
