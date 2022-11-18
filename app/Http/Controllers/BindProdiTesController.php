<?php

namespace App\Http\Controllers;

use App\Models\ProdiTes;
use Illuminate\Http\Request;

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
        $prodis = ProdiTes::all();
        // foreach ($prodis as $prodis) {
        //     $prodis->link_edit = route('api_bindBindProdiTes');
        // }
        return response()->json([
            'prodi'=>$prodis,
        ]);
    }

    public function binding()
    {
        dd(request());
    }
}
