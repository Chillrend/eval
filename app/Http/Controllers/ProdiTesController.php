<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use App\Models\Criteria;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProdiTesController extends Controller
{
    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;

    public function import (Request $request) 
    {
        $array = (new ProdiImport())->toArray($request->file('excel'));

        $namedkey = array();
        for ($i=0; $i < $request->input('banyakCollumn'); $i++) {
            $namedkey[$i]=strtolower($request->input('collumn-'.strval($i)));
        }

        // $namedkey = array(
        //     strtolower($request->input('col_id_prodi')), 
        //     strtolower($request->input('col_jurusan')), 
        //     strtolower($request->input('col_id_politeknik')), 
        //     strtolower($request->input('col_politeknik')), 
        //     strtolower($request->input('col_id_kelompok_bidang')), 
        //     strtolower($request->input('col_kelompok_bidang')), 
        //     strtolower($request->input('col_Quota')), 
        //     strtolower($request->input('col_tertampung'))
        // );

        $periode = $request->input('periode');

        $criteria = array(
            'tahun' => $periode,
            'criteria' => $namedkey,
            'table' => 'prodi',
            'kode_criteria' => strval($periode).'_prodi',
        );
        if (Criteria::where('kode_criteria',strval($periode).'_prodi')->first()) {
            Criteria::where('kode_criteria',strval($periode).'_prodi')->update($criteria);
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

        Prodi::truncate();
        Prodi::insert($filtered);
        
        Session::flash('sukses','Data Berhasil ditambahkan');
        return redirect()->back();
    }

    public function render()
    {
        $prodi = Prodi::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->paginate(10);

        $criteria = Criteria::where('table', 'prodi')->get();
        
        return view('halaman.import-prodi-tes',[
            'type_menu' => 'import-prodi',
            'prodi' => $prodi,
            'criteria' => $criteria,
        ]);
    }
}
