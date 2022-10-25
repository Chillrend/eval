<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use App\Models\CandidateTes;
use App\Models\Criteria;
use Exception;
use Illuminate\Support\Facades\Session;

class CandidateTesController extends Controller 
{
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
                $fil['status'] = 0;
                $filtered[] = $fil;
            }

            if (Criteria::query()->where('kode_criteria',strval($periode).'_candidates_tes')->exists()) {
                Criteria::query()->where('kode_criteria',strval($periode).'_candidates_tes')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            CandidateTes::query()->where('status',0)->delete();
            CandidateTes::insert($filtered);

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
        $candidates = CandidateTes::query()->where('status',0)
            ->when( $search && $collumn, function($query) use ($collumn,$search){
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->paginate(10);

        $criteria = Criteria::query()->where('table', 'candidates_tes')->get();

        return view('halaman.candidate-tes',[
            'type_menu' => 'tes',
            'candidates' => $candidates,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
        ]);
    }

    public function cancel(){
        CandidateTes::query()->where('status',0)->delete();
        return redirect('/candidates-tes');
    }

    public function save(){
        CandidateTes::query()->where('status',1)->delete();
        CandidateTes::query()->where('status',0)->update(['status' => 1]);
        return redirect('/preview-tes');
    }

    public function criteria()
    {
        $criteria = Criteria::select('criteria')->where('table', 'candidates_tes')->where('tahun', request('tahun'))->first();
        session()->put('list', $criteria);
        return response()->json([
            'criteria'=>$criteria->criteria,
        ]);
    }
}
