<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;

class ExpenditureController extends Controller
{
     public function index()
    {
        return view('expenditure.index');
    }

    public function data()
    {
        $expenditure = Expenditure::orderBy('expenditure_id', 'desc')->get();

        return datatables()
        ->of($expenditure)
        ->addIndexColumn()
        ->addColumn('created_at', function($expenditure){
            return tanggal_indonesia($expenditure->created_at, false);
        })
        ->addColumn('nominal', function($expenditure){
            return format_uang($expenditure->nominal);
        })
        ->addColumn('action', function($expenditure){
            return '
                <button type="button" onclick="editForm(`'. route('expenditures.update', $expenditure->expenditure_id) .'`)" class="badge badge-info border-0 p-2"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="deleteData(`'. route('expenditures.destroy', $expenditure->expenditure_id) .'`)" class="badge badge-danger border-0 p-2"><i class="fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
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
        $expenditure = Expenditure::create($request->all());

        return response()->json('Data berhasil di simpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenditure = Expenditure::find($id);
        return response()->json($expenditure);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expenditure = Expenditure::find($id)->update($request->all());

        return response()->json('Data berhasil di update', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expenditure = Expenditure::find($id)->delete();

        return response(null, 204);
    }
}
