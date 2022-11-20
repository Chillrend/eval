<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\ProdiTes;
use Exception;
use Hamcrest\Type\IsNumeric;

class BindProdiTesController extends Controller
{
    public function render()
    {
        return view('halaman.binding-prodi-tes',[
            'type_menu' => 'tes',
            'prodi' => '',
            'searchbar' =>'',
        ]);
    }

    public function render_api()
    {
        $tahun = (request('tahun')) ? request('tahun') : strval(date("Y")) ;
        $prodis = ProdiTes::all();
        $criteria = Criteria::select('binding')->where('kode_criteria', $tahun.'_candidates_tes')->get()->toArray();
        $criteria = $criteria[0]['binding'];
        
        for ($i=0; $i < count($prodis); $i++) { 
            $key = array_search($prodis[$i]['id_prodi'], array_column($criteria, 'id_prodi'));
            if (is_numeric($key)) {
                $prodis[$i]['binding'] = $criteria[$key]['bind_prodi'];
            }            
        }
        $criteria = Criteria::select('tahun')->where('table', 'candidates_tes')->groupBy('tahun')
        ->orderBy('tahun', 'desc')
        ->get()->toArray(); 


        return response()->json([
            'prodi'=>$prodis,
            'tahun'=>$criteria,
        ]);
    }

    public function binding()
    {
        if (Criteria::query()->where('kode_criteria',request('periode').'_candidates_tes')->doesntExist()) {
            return redirect()->back()->withErrors('Silahkan lakukan import terlebih dahulu','default');
        }
        try {
            $data = Criteria::query()->where('kode_criteria',request('periode').'_candidates_tes')->first();
            $array = [
                'id_prodi'  => intval(request('id_prodi')),  
                'bind_prodi'=> request('bind_prodi'), 
            ];

            $binding = (isset($data->binding)) ? (array) $data->binding : array();

            $key = array_search(intval(request('id_prodi')), array_column($binding, 'id_prodi'));
            if (is_numeric($key)) {
                $binding[$key] = $array;
            } else {
                array_push($binding,$array);
            }
            $data->binding = $binding;
            $data->save();

            session()->flash('success','Data Binding Berhasil');
            return redirect()->back()->with('success','Data Binding Berhasil Ditambahkan')->send();
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error,'default');
        }
    }
}

