<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidates;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function criteria(Request $request)
    {
        $query = $request->query();
        $criteria = Criteria::select('criteria')->where('table', 'candidates')->where('tahun', $query['tahun'])->first();

        return response()->json([
            'criteria'=>$criteria,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidates  $candidates
     * @return \Illuminate\Http\Response
     */
    public function show(Candidates $candidates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidates  $candidates
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidates $candidates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidates  $candidates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidates $candidates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidates  $candidates
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidates $candidates)
    {
        //
    }
}
