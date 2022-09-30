<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Fascades\Excel;

class ImportController extends Controller
{
    public function index ()
    {
        return view();
    }

    public function import (Request $request) 
    {
        $array = (new CandidatesImport())->toArray($request->file('excel'));
 
        $namedkey = array('nodaftar', 'nama', 'id_pilihan1', 'id_pilihan2', 'id_pilihan3', 'kode_kelompok_bidang', 'alamat', 'sekolah', 'telp');

        for ($i=0; $i < count($array[0]); $i++) { 
            $filtered[] = [
                'no_daftar'             => $array[0][$i][$namedkey[0]], 
                'nama'                  => $array[0][$i][$namedkey[1]] ,
                'id_pilihan1'           => $array[0][$i][$namedkey[2]], 
                'id_pilihan2'           => $array[0][$i][$namedkey[3]], 
                'id_pilihan3'           => $array[0][$i][$namedkey[4]], 
                'kode_kelompok_bidang'  => $array[0][$i][$namedkey[5]], 
                'alamat'                => $array[0][$i][$namedkey[6]], 
                'sekolah'               => $array[0][$i][$namedkey[7]], 
                'telp'                  => $array[0][$i][$namedkey[8]],
            ] ;

            if($array[0][$i][$namedkey[2]] === "" || $array[0][$i][$namedkey[2]] === " "){
                $filtered[$i]['id_pilihan1'] = null;
            }else{
                $filtered[$i]['id_pilihan1'] = $array[0][$i][$namedkey[2]];
            };
            if($array[0][$i][$namedkey[3]] === "" || $array[0][$i][$namedkey[3]] === " "){
                $filtered[$i]['id_pilihan2'] = null;
            }else{
                $filtered[$i]['id_pilihan2'] = $array[0][$i][$namedkey[3]];
            };
            if($array[0][$i][$namedkey[4]] === "" || $array[0][$i][$namedkey[4]] === " "){
                $filtered[$i]['id_pilihan3'] = null;
            }else{
                $filtered[$i]['id_pilihan3'] = $array[0][$i][$namedkey[4]];
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
        $savedd = Candidates::insert($filtered);
        
        // dd($filtered);
        // Candidates::insert([$filtered]);

        
    }
}
