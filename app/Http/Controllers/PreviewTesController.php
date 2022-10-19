<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Tes;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Session;
use Maatwebsite\Fascades\Excel;
use Jenssegers\Mongodb\Eloquent\Model;

class PreviewTesController extends Controller
{

    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;
    public function render()
    {

        $prodi = Prodi::query()
        ->when( $this->q, function($query) {
            return $query->where(function( $query) {
                $query->where('name', 'like', '%'.$this->q . '%')
                    ->orWhere('ident', 'like', '%' . $this->q . '%');
            });
        })
        ->paginate(10);

        $prestasi = Tes::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10);

        $criteria = Tes::where('table', 'candidates')->get();
        $criteriaprodi = Prodi::where('table', 'prodi')->get();


        return view('halaman.preview-tes',[
            'type_menu' => 'tes',
            'prestasi' => $prestasi,
            'prodi' => $prodi,
            'criteria' => $criteria,
            'criteriaprodi' => $criteriaprodi
        ]);
    }

}