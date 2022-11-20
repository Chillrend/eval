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

    public function insert()
    {
        $this->validate(request(),
        [
            'id_prodi' => 'required|numeric|unique:ProdiMand,id_prodi',
            'prodi' => 'required',
            'kelompok_bidang' => 'required',
            'kuota' => 'required|numeric',
        ],[

        ]);
        if (ProdiMand::query()->where('id_prodi', intval(request('id_prodi')))->exists()) {
            return redirect()->back()->withInput()->withErrors('The Id Prodi already exist','default');
        };
        try {
            $ProdiMand = array(
                'id_prodi'          => intval(request('id_prodi')),
                'prodi'             => request('prodi'),
                'kelompok_bidang'   => request('kelompok_bidang'),
                'kuota'             => intval(request('kuota')),
            );
            
            ProdiMand::insert($ProdiMand);
            return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors($error,'default');
        }
        // dd(request());
    }

    public function delete($id)
    {
        try {
            ProdiMand::find($id)->delete();        
            return redirect()->back()->with('success', 'Data Berhasil Dihapuskan');
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors($error,'default');
        }
    }

    public function edit($id)
    {
        try {
            $data = ProdiMand::find($id);        

            if (ProdiMand::query()->where('id_prodi',intval(request('id_prodi')))->count() > 1 || 
                ProdiMand::query()->where('id_prodi',intval(request('id_prodi')))->count() == 1 &&
                $data->isnot(ProdiMand::query()->where('id_prodi',intval(request('id_prodi')))->first())
                ) {
                return redirect()->back()->withInput()->withErrors('id_prodi sudah terdaftar','default');
            }

            $data                   = ProdiMand::find($id);        
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

    public function render(Request $request)
    {
        $search = $request->input('search');
        $collumn = $request->input('kolom');
        $prodi = ProdiMand::query()
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

        return view('halaman.prodi-mandiri',[
            'type_menu' => 'mandiri',
            'prodi' => $prodi,
            'searchbar' => [$collumn, $search],
        ]);
    }
}
