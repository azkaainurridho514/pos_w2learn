<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;

class ProductsController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Categories::all()->pluck('category_name', 'category_id');
        return view('product.index', compact('category'));
    }

    public function data()
    {
        // $data = Products::orderBy('product_id', 'desc')->get();
        $data = Products::leftJoin('categories', 'categories.category_id', 'products.category_id')
                ->select('products.*', 'category_name')
                ->orderBy('code', 'asc')
                ->get();

        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->addColumn('select_all', function($data){
            return ' <input type="checkbox" name="product_id[]" value="'. $data->product_id .'">';
        })
        ->addColumn('code', function($data){
            return '<span class="badge badge-success">'. $data->code .'</span>';
        })
        ->addColumn('purchase_price', function($data){
            return format_uang($data->purchase_price);
        })
        ->addColumn('selling_price', function($data){
            return format_uang($data->selling_price);
        })
        ->addColumn('stock', function($data){
            return format_uang($data->stock);
        })
        ->addColumn('action', function($data){
            return '
                <button onclick="editForm(`'. route('products.show', $data->product_id) .'`)" class="badge badge-info border-0 p-2"><i class="fa fa-edit"></i></button>
                <button onclick="deleteData(`'. route('products.destroy', $data->product_id) .'`)" class="badge badge-danger border-0 p-2"><i class="fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['action', 'code', 'select_all'])
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
        $product = Products::latest()->first();
        $request['code'] = "P" . add_zero((int)$product->product_id + 1, 6);
        $data = Products::create($request->all());

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
        $data = Products::find($id);
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
        $data = Products::find($id);
        $data->update($request->all());

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
        $data = Products::find($id);
        $data->delete();

        return response(null, 204);
    }

    function deleteSelected(Request $request)
    {
        foreach($request->product_id as $id){
            $product = Products::find($id);
            $product->delete();
        }
        return response(null, 204);
    }

}
