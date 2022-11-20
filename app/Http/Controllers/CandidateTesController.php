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
        if ($request->input('tahunperiode') == '' ||
            $request->file('excel') == null ||
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
            $periode = $request->input('tahunperiode');

            $criteria = array(
                'tahun' => intval($periode),
                'kolom' => $namedkey,
                'table' => 'candidates_tes',
                'kode_criteria' => strval($periode).'_candidates_tes',
            );

            for ($i=0; $i < count($array[0]); $i++) {
                for ($ab=0; $ab < count($namedkey); $ab++) { 
                    if (ctype_digit(trim($array[0][$i][$namedkey[$ab]]))) {
                            $fil[$namedkey[$ab]] = intval($array[0][$i][$namedkey[$ab]]);
                    } else {
                            $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                    }
                };
                $fil['periode'] = intval($periode);
                $fil['status'] = 'import';
                $filtered[] = $fil;
            }

            if (Criteria::query()->where('kode_criteria',strval($periode).'_candidates_tes')->exists()) {
                Criteria::query()->where('kode_criteria',strval($periode).'_candidates_tes')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }

            CandidateTes::query()->where('periode',intval($periode))->delete();
            CandidateTes::insert($filtered);

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
        $candidates = CandidateTes::query()->where('status','import')
            ->when( $search && $collumn, function($query) use ($collumn,$search){
                return $query->where(function($query) use ($collumn,$search) {
                    if (is_numeric($search)) {
                        $query->where($collumn, intval($search));
                    } else {
                        $query->where($collumn, 'like', '%'.$search . '%');
                    }
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
        CandidateTes::query()->where('status','import')->delete();
        return redirect('/candidates-tes');
    }

    public function save(){
        CandidateTes::query()->where('status','post-import')->delete();
        CandidateTes::query()->where('status','import')->update(['status' => 'post-import']);
        return redirect('/preview-tes');
    }

    public function criteria()
    {
        $criteria = Criteria::select('kolom')->where('table', 'candidates_tes')->where('tahun', intval(request('tahun')))->first();
        return response()->json([
            'criteria'=>$criteria->kolom,
        ]);
    }
}
