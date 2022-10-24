<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CandidatePresController extends Controller
{
 
    public $list;

    public function criteria(Request $request)
    {
        $query = $request->query();
        $criteria = Criteria::select('criteria')->where('table', 'candidates_pres')->where('tahun', $query['tahun'])->first();
        // $list = $criteria->criteria;
        session()->put('list', $criteria->criteria);
        return response()->json([
            'data'=>session()->get('list'),
        ]);
    }

    public function delete(Request $request)
    {
        // $ayam = $list;
        $query = $request->query();
        return response()->json([
            'data'=>session()->get('list'),
            'id'=>$query['id'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
