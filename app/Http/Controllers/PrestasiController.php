<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PrestasiController extends Controller
{
    public function render()
    {
        return redirect('prestasi');
    }

}