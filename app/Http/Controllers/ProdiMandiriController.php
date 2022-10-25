<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use App\Models\Criteria;
use App\Models\Tempory_Prodi_Mandiri;
use App\Models\Prodi_Mandiri;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProdiMandiriController extends Controller
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
            $array = (new ProdiImport())->toArray($request->file('excel'));

            $namedkey = array();
            for ($i=0; $i < $request->input('banyakCollumn'); $i++) {
                $namedkey[$i]=strtolower($request->input('collumn-'.strval($i)));
            }
    
            $periode = $request->input('periode');
    
            $criteria = array(
                'tahun' => $periode,
                'criteria' => $namedkey,
                'table' => 'prodi',
                'kode_criteria' => strval($periode).'_prodi',
            );
    
            for ($i=0; $i < count($array[0]); $i++) {
                // $fil = array();
                for ($ab=0; $ab < count($namedkey); $ab++) { 
                    $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                };
                $fil['periode'] = $periode;
                $filtered[] = $fil;
            }
    
            if (Criteria::where('kode_criteria',strval($periode).'_prodi')->first()) {
                Criteria::where('kode_criteria',strval($periode).'_prodi')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }
    
            Prodi_Mandiri::truncate();
            Prodi_Mandiri::insert($filtered);
            
            Session::flash('sukses','Data Calon Mahasiswa Berhasil diimport');
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
        $prodi = Prodi_Mandiri::query()
            ->when( $request->all(), function($query) use ($collumn,$search) {
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10)->onEachSide(1);

        $criteria = Criteria::where('table', 'prodi')->get();
        
        if($request->all() && empty($prodi->first())){
            Session::flash('error1','Data Prodi Tidak Tersedia');
        }

        return view('halaman.prodi-mandiri',[
            'type_menu' => 'mandiri',
            'prodi' => $prodi,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
        ]);
    }

    public function cancelprodimandiri(){
        Tempory_Prodi_Mandiri::truncate();
        Prodi_Mandiri::truncate();
        Criteria::truncate();
        return redirect('/candidates-mandiri');
    }

    public function saveprodimandiri(){
        Tempory_Prodi_Mandiri::truncate();
        return redirect('/preview-mandiri');
    }

}
