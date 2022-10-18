<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\Candidates;
use App\Models\Criteria;
use App\Models\Prestasi;
use App\Models\Tes;
use App\Models\Periode;
use Exception;
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
                'table' => 'candidates_tes',
                'kode_criteria' => strval($periode).'_candidates_tes',
            );

            for ($i=0; $i < count($array[0]); $i++) {
                for ($ab=0; $ab < count($namedkey); $ab++) { 
                    $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                };
                $fil['periode'] = $periode;
                $filtered[] = $fil;
            }

            if (Criteria::where('kode_criteria',strval($periode).'_candidates_tes')->first()) {
                Criteria::where('kode_criteria',strval($periode).'_candidates_tes')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            Tes::truncate();
            Tes::insert($filtered);

            Session::flash('sukses','Data Berhasil ditambahkan');
            return redirect('/candidates-tes');
        } catch (Exception $error) {
            Session::flash('error', $error);
            return redirect()->back();        }
    }

    public function render(Request $request)
    {

        $search = $request->input('search');
        $collumn = $request->input('kolom');
        $candidates = Tes::query()
            ->when( $search && $collumn, function($query) use ($collumn,$search){
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->paginate(10);

        $criteria = Criteria::where('table', 'candidates_tes')->get();

        // dd($candidates);

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
