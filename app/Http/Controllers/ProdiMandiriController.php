<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use App\Models\Criteria;
use App\Models\ProdiMand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProdiMandiriController extends Controller
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
            $array = (new ProdiImport())->toArray($request->file('excel'));

            $namedkey = array();
            for ($i=0; $i < $request->input('banyakCollumn'); $i++) {
                $namedkey[$i]=strtolower($request->input('collumn-'.strval($i)));
            }
    
            $periode = $request->input('periode');
    
            $criteria = array(
                'tahun' => $periode,
                'criteria' => $namedkey,
                'table' => 'prodi_mand',
                'kode_criteria' => strval($periode).'_prodi_mand',
            );
    
            for ($i=0; $i < count($array[0]); $i++) {
                // $fil = array();
                for ($ab=0; $ab < count($namedkey); $ab++) { 
                    $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                };
                $fil['periode'] = $periode;
                $fil['status'] = 0;
                $filtered[] = $fil;
            }
    
            if (Criteria::where('kode_criteria',strval($periode).'_prodi_mand')->first()) {
                Criteria::where('kode_criteria',strval($periode).'_prodi_mand')->update($criteria);
            } else {
                Criteria::insert($criteria);
            }
    
            ProdiMand::query()->where('status',0)->delete();
            ProdiMand::insert($filtered);
            
            Session::flash('sukses','Data Calon Mahasiswa Berhasil diimport');
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
        $prodi = ProdiMand::query()->where('status',0)
            ->when( $search && $collumn, function($query) use ($collumn,$search) {
                return $query->where(function($query) use ($collumn,$search) {
                    $query->where($collumn, 'like', '%'.$search . '%');
                });
            })
            ->paginate(10);

        $criteria = Criteria::query()->where('table', 'prodi_mand')->get();
        
        return view('halaman.prodi-mandiri',[
            'type_menu' => 'mandiri',
            'prodi' => $prodi,
            'criteria' => $criteria,
            'searchbar' => [$collumn, $search],
        ]);
    }

    public function cancelprodimandiri(){
        ProdiMand::query()->where('status',0)->delete();
        return redirect('/prodi-mandiri');
    }

    public function saveprodimandiri(){
        ProdiMand::query()->where('status',1)->delete();
        ProdiMand::query()->where('status',0)->update(['status' => 1]);
        return redirect('/preview-mandiri');
    }

    public function criteria()
    {
        $criteria = Criteria::select('criteria')->where('table', 'prodi_mand')->where('tahun', request('tahun'))->first();
        session()->put('list', $criteria);
        return response()->json([
            'criteria'=>$criteria->criteria,
        ]);
    }
}
