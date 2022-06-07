<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Products;
use App\Models\PurchaseDetail;

class PurchaseController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('name')->get();
        return view('purchase.index', compact('supplier'));
    }

    public function create($id)
    {
        $purchase = new Purchase();
        $purchase->supplier_id = $id;
        $purchase->total_item  = 0;
        $purchase->total_price = 0;
        $purchase->discount    = 0;
        $purchase->pay         = 0;
        $purchase->save();

        session(['purchase_id' => $purchase->purchase_id]); 
        session(['supplier_id' => $purchase->supplier_id]);
        return redirect()->route('purchases_detail.index');
    }

    public function store(Request $request)
    {
        $purchase = Purchase::findOrFail($request->purchase_id);
        $purchase->total_item = $request->total_item;
        $purchase->total_price = $request->total;
        $purchase->discount = $request->discount;
        $purchase->pay = $request->pay;
        $purchase->update();

        $detail = PurchaseDetail::where('purchase_id', $purchase->purchase_id)->get();
        foreach ($detail as $item) {
            $product = Products::find($item->product_id);
            $product->stock += $item->total;
            $product->update();
        }
        return redirect()->route('purchases.index');
    }

    public function data()
    {
        $data = Purchase::orderBy('purchase_id', 'desc')->get();
        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->addColumn('date', function($data){
            return tanggal_indonesia($data->created_at);
        })
        ->addColumn('supplier', function($data){
            return $data->supplier->name;
        })
        ->addColumn('total_price', function($data){
            return 'Rp. ' . format_uang($data->total_price);
        })
        ->addColumn('discount', function($data){
            return $data->discount . '%';
        })
        ->addColumn('total_item', function($data){
            return format_uang($data->total_item);
        })
        ->addColumn('pay', function($data){
            return 'Rp. ' . format_uang($data->pay);
        })
        ->addColumn('action', function($data){
            return '
                <button type="button" onclick="showProduct(`'. route('purchases.show', $data->purchase_id) .'`)" class="badge badge-info border-0 p-2"><i class="fa fa-eye"></i></button>
                <button type="button" onclick="deleteProduct(`'. route('purchases.destroy', $data->purchase_id) .'`)" class="badge badge-danger border-0 p-2"><i class="fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show($id)
    {
        $detail = PurchaseDetail::with('product')->where('purchase_id', $id)->get();

        return datatables()
        ->of($detail)
        ->addIndexColumn()
        ->addColumn('code', function($detail){
            return $detail->product->code;
        })
        ->addColumn('product_name', function($detail){
            return $detail->product->product_name;
        })
        ->addColumn('purchase_price', function($detail){
            return format_uang($detail->purchase_price);
        })
        ->addColumn('total', function($detail){
            return format_uang($detail->total);
        })
        ->addColumn('subtotal', function($detail){
            return format_uang($detail->subtotal);
        })
        ->make(true);
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        $detail = PurchaseDetail::where('purchase_id', $purchase->purchase_id)->get();
        foreach($detail as $item)
        {
            $item->delete();
        }
        $purchase->delete();

        return response(null, 204);
    }
}
