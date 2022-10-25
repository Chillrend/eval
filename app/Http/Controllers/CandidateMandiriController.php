<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use App\Models\Criteria;
use App\Models\Mandiri;
use App\Models\Tempory_Mandiri;
use Exception;
use Illuminate\Support\Facades\Session;

class CandidateMandiriController extends Controller 
{
    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;


    public function import (Request $request) 
    {
        if ($request->file('excel') == null ||
            $request->input('periode') == '' ||
            $request->input('banyakCollumn') == 0) {
                Session::flash('error','Pastikan anda telah mengisi semua input');
                return redirect()->back();
        }

        try {
            $array = (new CandidatesImport())->toArray($request->file('excel')); 
            $namedkey = array();
            for ($i=0; $i < $request->input('banyakCollumn'); $i++) {
                $namedkey[$i]=strtolower($request->input('collumn-'.strval($i)));
            }

            $periode = $request->input('periode');

            $criteria = array(
                'tahun' => $periode,
                'criteria' => $namedkey,
                'table' => 'candidates',
                'kode_criteria' => strval($periode).'_candidates',
            );     

            for ($i=0; $i < count($array[0]); $i++) {
                for ($ab=0; $ab < count($namedkey); $ab++) { 
                    $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                };
                $fil['periode'] = $periode;
                $filtered[] = $fil;
            }

            if (Criteria::where('kode_criteria',strval($periode).'_candidates')->first()) {
                Criteria::where('kode_criteria',strval($periode).'_candidates')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            Mandiri::truncate();
            Mandiri::insert($filtered);

            Session::flash('success','Data Calon Mahasiswa Berhasil diimport');
            return redirect()->back();
        }catch (Exception $error) {
            Session::flash('error', $error);
            return redirect()->back();
        }
    }

    public function render(Request $request)
    {
        $search = $request->input('search');
        $collumn = $request->input('kolom');
        $candidates = Mandiri::query()
            ->when( $request->all(), function($query) use ($collumn,$search) {
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10)->onEachSide(1);

        $criteria = Criteria::where('table', 'candidates')->get();
        
        if($request->all() && empty($candidates->first())){
            Session::flash('error1','Data Calon Mahasiswa Tidak Tersedia');
        }

        return view('halaman.candidate-mandiri',[
            'type_menu' => 'mandiri',
            'candidates' => $candidates,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
        ]);
    }

    public function cancelmandiri(){
        Mandiri::truncate();
        Candidates::truncate();
        Criteria::truncate();
        Tempory_Mandiri::truncate();
        return redirect('/candidates-mandiri');
    }

    public function savemandiri(){
        Tempory_Mandiri::truncate();
        return redirect('/preview-mandiri');
    }


}
