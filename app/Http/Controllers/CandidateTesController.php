<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use App\Models\Criteria;
use App\Models\Prestasi;
use App\Models\Tes;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Fascades\Excel;
use Jenssegers\Mongodb\Eloquent\Model;

class CandidateTesController extends Controller 
{
    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;


    public function import (Request $request) 
    {
        // dd($request->all());
        $array = (new CandidatesImport())->toArray($request->file('excel')); 
        // dd($array);

        $namedkey = array(
            strtolower($request->input('col_no_daftar')), 
            strtolower($request->input('col_nama')), 
            strtolower($request->input('col_id_pilihan_1')), 
            strtolower($request->input('col_id_pilihan_2')), 
            strtolower($request->input('col_id_pilihan_3')), 
            strtolower($request->input('col_kode_kelompok_bidang')), 
            strtolower($request->input('col_alamat')), 
            strtolower($request->input('col_sekolah')),
            strtolower($request->input('col_no_telp')),
        );
        $periode = $request->input('periode');

        $criteria = array(
            'tahun' => $periode,
            'criteria' => $namedkey,
            'table' => 'candidates',
            'kode_criteria' => strval($periode).'_candidates',
        );
        Criteria::insert($criteria,'kode_criteria');
        


        for ($i=0; $i < count($array[0]); $i++) { 
            $filtered[] = [
                'no_daftar'             => trim($array[0][$i][$namedkey[0]]), 
                'nama'                  => trim($array[0][$i][$namedkey[1]]) ,
                'id_pilihan1'           => trim($array[0][$i][$namedkey[2]]), 
                'id_pilihan2'           => trim($array[0][$i][$namedkey[3]]), 
                'id_pilihan3'           => trim($array[0][$i][$namedkey[4]]), 
                'kode_kelompok_bidang'  => trim($array[0][$i][$namedkey[5]]), 
                'alamat'                => trim($array[0][$i][$namedkey[6]]), 
                'sekolah'               => trim($array[0][$i][$namedkey[7]]), 
                'telp'                  => trim($array[0][$i][$namedkey[8]]),
                'tahun_periode'         => $periode,
            ] ;
        }

        Candidates::truncate();
        Candidates::insert($filtered,'no_daftar');
        Tes::insert($filtered,'no_daftar');


        Session::flash('sukses','Data Berhasil ditambahkan');
        return redirect('/candidates-tes');
    }

    public function render(Request $request)
    {
        $search = $request->input('search');
        $collumn = $request->input('kolom');
        $candidates = Tes::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10);

        $criteria = Criteria::where('table', 'candidates')->get();
        if($request->all() && empty($candidates->first())){
            Session::flash('error1','Data Calon Mahasiswa Tidak Tersedia');
        }

        return view('halaman.candidate-tes',[
            'type_menu' => 'tes',
            'candidates' => $candidates,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
        ]);
    }

    public function canceltes(){
        Tes::truncate();
        Candidates::truncate();
        Criteria::truncate();
        return redirect('/candidates-tes');
    }
}
