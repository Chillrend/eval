<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use App\Models\Criteria;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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
            'criteria' => implode('---',$namedkey),
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
            ] ;
            $periodes[] = [
                'tahun_periode'       => $periode,
                'no_daftar'     => trim($array[0][$i][$namedkey[0]])
            ];
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

        $saved = Periode::insert($periodes);
        $savedd = Candidates::insert($filtered,'no_daftar');


        Session::flash('sukses','Data Berhasil ditambahkan');
        return redirect('/import-candidates');
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

        $criteria = Criteria::where('table', 'candidates')->get();
        for ($i=0; $i < count($criteria); $i++) { 
            $criteria[$i]['criteria'] = explode('---',$criteria[$i]['criteria']);
        }
    

        // $data = Candidates::join('periode_candidates','periode_candidates.no_daftar','=','candidates.no_daftar')
        //                         ->get(['periode_candidates.tahun_periode','candidates.no_daftar','candidates.nama',
        //                         'candidates.id_pilihan1','candidates.id_pilihan2','candidates.id_pilihan3','candidates.kode_kelompok_bidang',
        //                         'candidates.alamat','candidates.sekolah','candidates.telp'])
        //                          ;

        // $data = DB::table('candidates')
        //     ->join('periode_candidates', 'periode_candidates.no_daftar', '=', 'candidates.no_daftar')
        //     ->select('candidates.*', 'periode_candidates.tahun_periode')
        //     ->get()
        //     ;

        // $data = $data->orderBy('created_at', 'desc')->paginate(10);
        // $collection = (new Collection($data))->paginate(10);
                                 
        // $candidates = Candidates::query()
        //     ->join('periode_candidates', 'periode_candidates.no_daftar', '=', 'candidates.no_daftar')
        //                 ->select('candidates.*', 'periode_candidates.tahun_periode')
        //                 ->get()
        //     ->when( $this->q, function($query) {
        //         return $query->where(function( $query) {
        //             $query->where('name', 'like', '%'.$this->q . '%')
        //                 ->orWhere('ident', 'like', '%' . $this->q . '%');
        //         });
        //     })
        //     ->paginate(10);
            
        //     ;
            
        // dd($data);
        

        return view('halaman.import-candidate',[
            'type_menu' => 'import-candidate',
            'candidates' => $candidates,
            'criteria' => $criteria
        ]);
    }
}
