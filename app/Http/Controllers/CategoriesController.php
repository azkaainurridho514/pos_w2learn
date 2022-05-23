<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        $data = Categories::orderBy('category_id', 'desc')->get();
        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            return '
                <button onclick="editForm(`'. route('categories.update', $data->category_id) .'`)" class="badge badge-info border-0 p-2"><i class="fa fa-edit"></i></button>
                <button onclick="deleteData(`'. route('categories.destroy', $data->category_id) .'`)" class="badge badge-danger border-0 p-2"><i class="fa fa-trash"></i></button>
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
        $data = new Categories();
        $data->category_name = $request->nama;
        $data->save();

        return response()->json('Data berhasil di simpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Categories::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Categories::find($id);
        $data->category_name = $request->nama;
        $data->update();

        return response()->json('Data berhasil di simpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Categories::find($id);
        $data->delete();

        return response(null, 204);
    }
}
