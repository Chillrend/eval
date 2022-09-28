<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CandidatesImport;
use Maatwebsite\Fascades\Excel;

class ImportController extends Controller
{
    public function index ()
    {
        return view();
    }

    public function import (Request $request) 
    {
        $test = (new CandidatesImport())->toArray($request->file('excel'));

        dd($test);
    }
}
