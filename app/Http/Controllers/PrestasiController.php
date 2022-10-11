<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Prestasi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Session;
use Maatwebsite\Fascades\Excel;
use Jenssegers\Mongodb\Eloquent\Model;

class PrestasiController extends Controller
{

    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;
    public function render()
    {
        $prestasi = Prestasi::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10);

        $criteria = Prestasi::where('table', 'candidates')->get();


        return view('halaman.prestasi',[
            'type_menu' => 'import-candidate',
            'prestasi' => $prestasi,
            'criteria' => $criteria
        ]);
    }

}