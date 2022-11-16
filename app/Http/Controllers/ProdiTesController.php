<?php

namespace App\Http\Controllers;

use App\Imports\ProdiImport;
use App\Models\Criteria;
use App\Models\ProdiTes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class ProdiTesController extends Controller
{
    public function insert()
    {
        $this->validate(request(),
        [
            'id_prodi' => 'required|numeric|unique:prodites,id_prodi',
            'prodi' => 'required',
            'kelompok_bidang' => 'required',
            'kuota' => 'required|numeric',
        ],[

        ]);
        if (ProdiTes::query()->where('id_prodi', intval(request('id_prodi')))->exists()) {
            return redirect()->back()->withInput()->withErrors('The Id Prodi already exist','default');
        };
        try {
            $prodites = array(
                'id_prodi'          => intval(request('id_prodi')),
                'prodi'             => request('prodi'),
                'kelompok_bidang'   => request('kelompok_bidang'),
                'kuota'             => intval(request('kuota')),
            );
            
            ProdiTes::insert($prodites);
            return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors($error,'default');
        }
        // dd(request());
    }

    public function delete($id)
    {
        try {
            ProdiTes::find($id)->delete();        
            return redirect()->back()->with('success', 'Data Berhasil Dihapuskan');
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors($error,'default');
        }
    }

    public function edit($id)
    {
        try {
            $data = ProdiTes::find($id);        

            if (ProdiTes::query()->where('id_prodi',intval(request('id_prodi')))->count() > 1 || 
                ProdiTes::query()->where('id_prodi',intval(request('id_prodi')))->count() == 1 &&
                $data->isnot(ProdiTes::query()->where('id_prodi',intval(request('id_prodi')))->first())
                ) {
                return redirect()->back()->withInput()->withErrors('id_prodi sudah terdaftar','default');
            }

            $data                   = ProdiTes::find($id);        
            $data->id_prodi         = intval(request('id_prodi'));
            $data->prodi            = request('prodi');
            $data->kelompok_bidang  = request('kelompok_bidang');
            $data->kuota            = intval(request('kuota'));
            $data->save();
            
            return redirect()->back()->with('success', 'Data Berhasil Diedit');
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors($error,'default');
        }
    }

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
                'table' => 'prodi_tes',
                'kode_criteria' => strval($periode).'_prodi_tes',
            );
    
            for ($i=0; $i < count($array[0]); $i++) {
                // $fil = array();
                for ($i=0; $i < count($array[0]); $i++) {
                    // $fil = array();
                    for ($ab=0; $ab < count($namedkey); $ab++) { 
                        $fil[$namedkey[$ab]] = trim($array[0][$i][$namedkey[$ab]]);
                    };
                    $fil['periode'] = $periode;
                    $fil['status'] = 0;
                    $filtered[] = $fil;
                }
        
                
                if (Criteria::query()->where('kode_criteria',strval($periode).'_prodi_tes')->exists()) {
                    Criteria::query()->where('kode_criteria',strval($periode).'_prodi_tes')->update($criteria);
                } else {
                    Criteria::insert($criteria);
                }

                ProdiTes::query()->where('status',0)->delete();
                ProdiTes::insert($filtered);
                
                Session::flash('sukses','Data Berhasil ditambahkan');
                return redirect()->back();
            }
            
        }catch (Exception $error) {
            Session::flash('error', $error);
            return redirect()->back();
        }
    }

    public function render(Request $request)
    {
        $search = $request->input('search');
        $collumn = $request->input('kolom');
        // dd(
        //     ProdiTes::query()->where('prodi','like','%'.'Teknik Informatika'.'%')->get(),
        // );
        $prodi = ProdiTes::query()
            ->when( $search && $collumn, function($query) use ($collumn,$search) {
                return $query->where(function($query) use ($collumn,$search) {
                    if (is_numeric($search)) {
                        $query->where($collumn, intval($search));
                    } else {
                        $query->where($collumn, 'like', '%'.$search . '%');
                    }
                });
            })
            ->paginate(10);

        return view('halaman.prodi-tes',[
            'type_menu' => 'tes',
            'prodi' => $prodi,
            'searchbar' => [$collumn, $search],
        ]);
    }

    public function cancelProMan(){
        ProdiTes::query()->where('status',0)->delete();
        return redirect('/prodi-tes');
    }

    public function saveProMan(){
        ProdiTes::query()->where('status',1)->delete();
        ProdiTes::query()->where('status',0)->update(['status' => 1]);
        return redirect('/preview-tes');
    }

    public function criteria()
    {
        $criteria = Criteria::select('criteria')->where('table', 'prodi_tes')->where('tahun', request('tahun'))->first();
        session()->put('list', $criteria);
        return response()->json([
            'criteria'=>$criteria->criteria,
        ]);
    }
}
