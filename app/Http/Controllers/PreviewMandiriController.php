<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Mandiri;
use App\Models\Prodi_Mandiri;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Session;
use Maatwebsite\Fascades\Excel;
use Jenssegers\Mongodb\Eloquent\Model;

class PreviewMandiriController extends Controller
{

    public $q;
    public $sortBy = 'no_daftar';
    public $sortAsc = true;
    
    public function render()
    {

        $prodi = Prodi_Mandiri::query()
        ->when( $this->q, function($query) {
            return $query->where(function( $query) {
                $query->where('name', 'like', '%'.$this->q . '%')
                    ->orWhere('ident', 'like', '%' . $this->q . '%');
            });
        })
        ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
        ->paginate(10)->onEachSide(1);

        $prestasi = Mandiri::query()
            ->when( $this->q, function($query) {
                return $query->where(function( $query) {
                    $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('ident', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC' )
            ->paginate(10)->onEachSide(1);

        $criteria = Mandiri::where('table', 'candidates')->get();
        $criteriaprodi = Prodi_Mandiri::where('table', 'prodi')->get();


        return view('halaman.preview-mandiri',[
            'type_menu' => 'mandiri',
            'prestasi' => $prestasi,
            'prodi' => $prodi,
            'criteria' => $criteria,
            'criteriaprodi' => $criteriaprodi
        ]);
    }

}