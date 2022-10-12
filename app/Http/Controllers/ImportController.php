<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use App\Models\Criteria;
use App\Models\Prestasi;
use Exception;
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

            Prestasi::truncate();
            Prestasi::insert($filtered);

            Session::flash('success','Data Calon Mahasiswa Berhasil diimport');
            return redirect()->back();
        }catch (Exception $error) {
            Session::flash('error', $error);
            return redirect()->back();
        }
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
