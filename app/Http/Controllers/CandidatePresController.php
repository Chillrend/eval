<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\CandidatePres;
use App\Models\Criteria;
use Exception;
use Illuminate\Support\Facades\Session;

class CandidatePresController extends Controller 
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
                'table' => 'candidates_pres',
                'kode_criteria' => strval($periode).'_candidates_pres',
            );     

            for ($i=0; $i < count($array[0]); $i++) {
                for ($ab=0; $ab < count($namedkey); $ab++) { 
                    $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                };
                $fil['periode'] = $periode;
                $fil['status'] = 0;
                $filtered[] = $fil;
            }

            if (Criteria::query()->where('kode_criteria',strval($periode).'_candidates_pres')->exists()) {
                Criteria::query()->where('kode_criteria',strval($periode).'_candidates_pres')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            CandidatePres::query()->where('status',0)->delete();
            CandidatePres::insert($filtered);

            Session::flash('success','Data Calon Mahasiswa Berhasil diimport');
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
        $candidates = CandidatePres::query()->where('status',0)
            ->when( $search && $collumn, function($query) use ($collumn,$search) {
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->paginate(10);

        $criteria = Criteria::query()->where('table', 'candidates_pres')->get();

        return view('halaman.candidate-prestasi',[
            'type_menu' => 'prestasi',
            'candidates' => $candidates,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
        ]);
    }

    public function cancelprestasi(){
        CandidatePres::query()->where('status',0)->delete();
        return redirect('/candidates-prestasi');
    }

    public function saveprestasi(){
        CandidatePres::query()->where('status',1)->delete();
        CandidatePres::query()->where('status',0)->update(['status' => 1]);
        return redirect('/preview-prestasi');
    }

    public function criteria()
    {
        $criteria = Criteria::select('criteria')->where('table', 'candidates_pres')->where('tahun', request('tahun'))->first();
        session()->put('list', $criteria);
        return response()->json([
            'criteria'=>$criteria->criteria,
        ]);
    }

    public function delcriteria()
    {
        $criteria = session('list');
        return response()->json([
            'criteria'=>$criteria,
        ]);    
    }
}
