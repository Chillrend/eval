<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use App\Models\Criteria;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;

    public function import (Request $request) 
    {
        $periode = $request->input('periode');
        $array = (new ProdiImport())->toArray($request->file('excel'));
        $namedkey = array(
            strtolower($request->input('col_id_prodi')), 
            strtolower($request->input('col_jurusan')), 
            strtolower($request->input('col_id_politeknik')), 
            strtolower($request->input('col_politeknik')), 
            strtolower($request->input('col_id_kelompok_bidang')), 
            strtolower($request->input('col_kelompok_bidang')), 
            strtolower($request->input('col_Quota')), 
            strtolower($request->input('col_tertampung'))
        );

        $criteria = array(
            'tahun' => $periode,
            'criteria' => implode('---',$namedkey),
            'table' => 'prodi',
            'kode_criteria' => strval($periode).'_prodi',
        );
        Criteria::upsert($criteria,'kode_criteria');
        


        for ($i=0; $i < count($array[0]); $i++) { 
            $filtered[] = [
                'id_prodi'              => trim($array[0][$i][$namedkey[0]]), 
                'jurusan'               => trim($array[0][$i][$namedkey[1]]) ,
                'id_politeknik'         => trim($array[0][$i][$namedkey[2]]), 
                'politeknik'            => trim($array[0][$i][$namedkey[3]]), 
                'id_kelompok_bidang'    => trim($array[0][$i][$namedkey[4]]), 
                'kelompok_bidang'       => trim($array[0][$i][$namedkey[5]]), 
                'quota'                 => trim($array[0][$i][$namedkey[6]]), 
                'tertampung'            => trim($array[0][$i][$namedkey[7]]), 
            ] ;

            if($array[0][$i][$namedkey[6]] === "" || $array[0][$i][$namedkey[6]] === " "){
                $filtered[$i]['quota'] = null;
            }else{
                $filtered[$i]['quota'] = $array[0][$i][$namedkey[6]];
            };
            if($array[0][$i][$namedkey[7]] === "" || $array[0][$i][$namedkey[7]] === " "){
                $filtered[$i]['tertampung'] = null;
            }else{
                $filtered[$i]['tertampung'] = $array[0][$i][$namedkey[7]];
            };
        }

        Prodi::insert($filtered);
        
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
        for ($i=0; $i < count($criteria); $i++) { 
            $criteria[$i]['criteria'] = explode('---',$criteria[$i]['criteria']);
        }

        return view('halaman.import-prodi',[
            'type_menu' => 'import-prodi',
            'prodi' => $prodi,
            'criteria' => $criteria,
        ]);
    }
}
