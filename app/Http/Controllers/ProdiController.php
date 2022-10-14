<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use App\Models\Criteria;
use App\Models\Prodi;
use App\Models\Tempory_Prodi_Prestasi;
use App\Models\Prodi_Prestasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProdiController extends Controller
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
    
            Prodi::truncate();
            Prodi::insert($filtered);
            
            Session::flash('sukses','Data Calon Mahasiswa Berhasil diimport');
            return redirect()->back();
        }catch (Exception $error) {
            Session::flash('error', $error);
            return redirect()->back();
        }
    }

    public function render()
    {
        $prodi = Tempory_Prodi_Prestasi::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->paginate(10);

        $criteria = Criteria::where('table', 'prodi')->get();
        
        return view('halaman.import-prodi-prestasi',[
            'type_menu' => 'import-prodi',
            'prodi' => $prodi,
            'criteria' => $criteria,
        ]);
    }

    public function cancelprodi(){
        Tempory_Prodi_Prestasi::truncate();
        Prodi::truncate();
        Criteria::truncate();
        Prodi_Prestasi::truncate();
        return redirect('/import-candidates-prestasi');
    }

    public function saveprodi(){
        Tempory_Prodi_Prestasi::truncate();
        return redirect('/preview-prestasi');
    }
}
