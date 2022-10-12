<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use App\Models\Criteria;
use App\Models\Prestasi;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Fascades\Excel;
use Jenssegers\Mongodb\Eloquent\Model;

class ImportController extends Controller 
{
    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;


    public function import (Request $request) 
    {
        // dd($request->all());
        $array = (new CandidatesImport())->toArray($request->file('excel')); 
        // dd($array);

        $namedkey = array();
        for ($i=0; $i < 9; $i++) {
            $namedkey[$i]=strtolower($request->input('collumn-'.strval($i)));
        }

        $periode = $request->input('periode');

        $criteria = array(
            'tahun' => $periode,
            'criteria' => $namedkey,
            'table' => 'candidates',
            'kode_criteria' => strval($periode).'_candidates',
        );
        if (Criteria::where('kode_criteria',strval($periode).'_candidates')->first()) {
            Criteria::where('kode_criteria',strval($periode).'_candidates')->update($criteria);
        } else {
            Criteria::insert($criteria);
        }
        

        for ($i=0; $i < count($array[0]); $i++) {
            // $fil = array();
            for ($ab=0; $ab < count($namedkey); $ab++) { 
                $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
            };
            $fil['periode'] = $periode;
            $filtered[] = $fil;
        }

        Prestasi::truncate();
        Prestasi::insert($filtered);


        Session::flash('sukses','Data Berhasil ditambahkan');
        return redirect('/import-candidates-prestasi');
    }

    public function render()
    {
        $candidates = Prestasi::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10);

        $criteria = Criteria::where('table', 'candidates')->get();
        

        return view('halaman.import-candidate-prestasi',[
            'type_menu' => 'import-candidates-prestasi',
            'candidates' => $candidates,
            'criteria' => $criteria
        ]);
    }

    public function cancelprestasi(){
        Prestasi::truncate();
        Candidates::truncate();
        Criteria::truncate();
        return redirect('/import-candidates-prestasi');
    }
}
