<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Fascades\Excel;

class ImportController extends Controller
{
    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;


    public function import (Request $request) 
    {
        dd($request);
        $array = (new CandidatesImport())->toArray($request->file('excel'));
 
        $namedkey = array('nodaftar', 'nama', 'id_pilihan1', 'id_pilihan2', 'id_pilihan3', 'kode_kelompok_bidang', 'alamat', 'sekolah', 'telp');

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
        $savedd = Candidates::upsert($filtered);
        
        // dd($filtered);
        // Candidates::insert([$filtered]);

        redirect()->back();
    }

    public function render()
    {
        $candidates = Candidates::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10);

        return view('halaman.import-candidate',[
            'type_menu' => 'import-candidate',
            'candidates' => $candidates,
        ]);
    }
}
