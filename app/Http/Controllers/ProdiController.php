<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;

    public function import (Request $request) 
    {
        $array = (new ProdiImport())->toArray($request->file('excel'));
        $namedkey = array(
            $request->input('col_id_prodi'), 
            $request->input('col_jurusan'), 
            $request->input('col_id_politeknik'), 
            $request->input('col_politeknik'), 
            $request->input('col_id_kelompok_bidang'), 
            $request->input('col_kelompok_bidang'), 
            $request->input('col_quota'), 
            $request->input('col_tertampung')
        );
        // dd($namedkey);

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
        // for ($i=0; $i < count($filtered) ; $i++) { 
        //     for ($a=0; $a < count($filtered[$i]); $a++) { 
        //         if ($filtered[$i][$a] === '') {
        //             $filtered[$i][$a] = null;
        //         }
        //     }
        // }



        // $filtered = (object) $filtered;
        // $savedd=$filtered->save();
        $savedd = Prodi::upsert($filtered,'id_prodi');
        
        // dd($filtered);
        // Candidates::insert([$filtered]);

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

        return view('halaman.import-prodi',[
            'type_menu' => 'import-prodi',
            'prodi' => $prodi,
        ]);
    }
}
