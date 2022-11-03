<?php

namespace App\Http\Controllers;

use App\Models\CandidateMand;
use App\Models\Criteria;
use Illuminate\Http\Request;

class FilterMandiriController extends Controller
{
    public function render()
    {
        // dd(request()->all());
        
        $search = request('search');
        $collumn = request('kolom');

        $ncollumn = request('banyakCollumn');

        $filter = [];
        for ($i=0; $i < request('banyakCollumn'); $i++) {
            $filter[$i][0]=strtolower(request('kolom-'.strval($i)));
            $filter[$i][1]=strtolower(request('operator-'.strval($i)));
            $filter[$i][2]=strtolower(request('nilai-'.strval($i)));
        }

        $candidates = CandidateMand::query()->where('status',1)
            ->when( $ncollumn, function($query) use ($filter, $ncollumn) {
                // dd($ncollumn);
                
                // for ($a=0; $a < count($filter); $a++) { 
                //     return $query->where(function($query) use ($filter,$a) {
                //         $query->where($filter[$a][0], $filter[$a][1] , intval($filter[$a][2]));
                //     });
                // }
                // dd($query);

                return $query->where(function($query) use ($filter) {
                    for ($a=0; $a < count($filter); $a++) { 
                        $query->where($filter[$a][0], $filter[$a][1] , intval($filter[$a][2]));
                    }
                });
                dd($query);
            })
            ->when( $search && $collumn, function($query) use ($collumn,$search) {
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->paginate(10);
        
        // dd($candidates);
        
        $criteria = Criteria::query()->where('table', 'candidates_mand')->get();

        return view('halaman.filter-mandiri',[
            'type_menu' => 'mandiri',
            'candidates' => $candidates,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
            'filter' => $filter,
        ]);    
    }
}
