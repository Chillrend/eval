<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Exception;
use App\Models\ProdiMand;
use Illuminate\Http\Request;

class BindProdiMandController extends Controller
{
    public function render()
    {
        $tahun = (request('tahun')) ? request('tahun') : strval(date("Y"));
        $prodis = ProdiMand::all();
        $criteria = Criteria::select('binding')->where('kode_criteria', $tahun . '_candidates_tes')->get()->toArray();
        $criteria = $criteria[0]['binding'];

        for ($i = 0; $i < count($prodis); $i++) {
            if (isset($criteria)) {
                $key = array_search($prodis[$i]['id_prodi'], array_column($criteria, 'id_prodi'));
                if (is_numeric($key)) {
                    $prodis[$i]['binding'] = $criteria[$key]['bind_prodi'];
                }
            }
        }
        $criteria = Criteria::select('tahun')->where('table', 'candidates_tes')->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->toArray();
        return view('halaman.binding-prodi-pres', [
            'type_menu' => 'prestasi',
            'prodi' => '',
            'searchbar' => '',
        ]);
    }

    public function render_api()
    {
        $tahun = (request('tahun')) ? request('tahun') : strval(date("Y"));
        $prodis = ProdiMand::all();
        $criteria = Criteria::select('binding')->where('kode_criteria', $tahun . '_candidates_tes')->get()->toArray();
        $criteria = $criteria[0]['binding'];

        for ($i = 0; $i < count($prodis); $i++) {
            if (isset($criteria)) {
                $key = array_search($prodis[$i]['id_prodi'], array_column($criteria, 'id_prodi'));
                if (is_numeric($key)) {
                    $prodis[$i]['binding'] = $criteria[$key]['bind_prodi'];
                }
            }
        }
        $criteria = Criteria::select('tahun')->where('table', 'candidates_tes')->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->toArray();


        return response()->json([
            'prodi' => $prodis,
            'tahun' => $criteria,
        ]);
    }

    public function binding()
    {
        if (Criteria::query()->where('kode_criteria', request('periode') . '_candidates_tes')->doesntExist()) {
            return redirect()->back()->withErrors('Silahkan lakukan import terlebih dahulu', 'default');
        }
        try {
            $data = Criteria::query()->where('kode_criteria', request('periode') . '_candidates_tes')->first();
            $array = [
                'id_obj'    => request('id_obj'),
                'id_prodi'  => intval(request('id_prodi')),
                'bind_prodi' => request('bind_prodi'),
            ];

            $binding = (isset($data->binding)) ? (array) $data->binding : array();

            $key = array_search(intval(request('id_prodi')), array_column($binding, 'id_prodi'));
            if (is_numeric($key)) {
                $binding[$key] = $array;
            } else {
                array_push($binding, $array);
            }
            $data->binding = $binding;
            $data->save();

            session()->flash('success', 'Data Binding Berhasil');
            return redirect()->back()->with('success', 'Data Binding Berhasil Ditambahkan')->send();
        } catch (Exception $error) {
            return redirect()->back()->withErrors($error, 'default');
        }
    }

    public function detail()
    {
        try {
            $prodi = ProdiMand::find(request('id'))->toArray();
            $criteria = Criteria::select('binding', 'tahun')->where('binding.id_obj', request('id'))->get()->toArray();
            for ($i = 0; $i < count($criteria); $i++) {
                if (isset($criteria)) {
                    $key = array_search(request('id'), array_column($criteria[$i]['binding'], 'id_obj'));
                    if (is_numeric($key)) {
                        $prodi['binding'][$i] = [
                            'tahun' => $criteria[$i]['tahun'],
                            'bind' => $criteria[$i]['binding'][$key]['bind_prodi']
                        ];
                    }
                }
            }
            return response()->json([
                'prodi' => $prodi,
            ]);
        } catch (Exception $th) {
            return response()->json([
                'error' => $th,
            ]);
        }
    }
}
