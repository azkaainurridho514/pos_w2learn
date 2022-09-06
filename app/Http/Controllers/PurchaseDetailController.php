<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Products;
use App\Models\PurchaseDetail;
use App\Models\Purchase;

class PurchaseDetailController extends Controller
{
    public function index()
    {
        $purchase_id = session('purchase_id');
        $product = Products::orderBy('product_name')->get();
        $supplier = Supplier::find(session('supplier_id'));
        $discount = Purchase::find($purchase_id)->discount ?? 0;

        if(! $supplier){
            abort(404);
        }

        return view('purchase_detail.index', compact('purchase_id', 'product', 'supplier', 'discount'));
    }

    public function data($id)
    {
        $data = PurchaseDetail::with('product')->where('purchase_id', $id)->get();

        $hide = array();
        $total = 0;
        $total_item = 0;

        foreach($data as $item){
            $row = array();
            $row['code'] = '<span class="badge badge-success">' . $item->product['code'] . '</span>';
            $row['product_name'] = $item->product['product_name'];
            $row['purchase_price'] = 'Rp. ' . format_uang($item->product['purchase_price']);
            $row['total'] = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->purchase_detail_id .'"  name="total_'. $item->purchase_detail_id .'" value="'. $item->total .'">';
            $row['subtotal'] = 'Rp. ' . format_uang($item->subtotal);
            $row['action'] = '
                <button type="button" onclick="deleteData(`'. route('purchases_detail.destroy', $item->purchase_id) .'`)" class="badge badge-danger border-0 p-2"><i class="fa fa-trash"></i></button>
            ';

            $hide[] = $row;

            $total += $item->purchase_price * $item->total;
            $total_item += $item->total;
        }

        $hide[] = [
            'code' => '<div class="total d-none">'. $total .'</div> <div class="total_item d-none">'. $total_item .'</div>',
            'product_name' => '',
            'purchase_price' => '',
            'total' => '',
            'subtotal' => '',
            'action' => ''
        ];

        return datatables()
        ->of($hide)
        ->addIndexColumn()
        ->rawColumns(['action', 'code', 'total'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $product = Products::where('product_id', $request->product_id)->first();

        if(!$product)
        {
            return response()->json('Data gagal di simpan', 400);
        } 

        $detail = new PurchaseDetail();
        $detail->purchase_id = $request->purchase_id;
        $detail->product_id = $product->product_id;
        $detail->purchase_price = $product->purchase_price;
        $detail->total = 1;
        $detail->subtotal = $product->purchase_price;
        $detail->save();

        return response()->json('Data berhasil di simpan', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = PurchaseDetail::find($id);
        if($request->total == 0){
            $detail->total = 0;
            $detail->subtotal = $detail->purchase_price * 0; 
        }else{
            $detail->total = $request->total;
            $detail->subtotal = $detail->purchase_price * $request->total; 
        }
        
        $detail->update();
    }

    public function destroy($id)
    {
        $data = PurchaseDetail::find($id);
        $data->delete();

        return response(null, 204);
    }

    public function loadform($discount, $total)
    {
        $pay = $total - ($discount / 100 * $total);
        $data = [
            'totalrp' => format_uang($total),
            'pay' => $pay,
            'payrp' => format_uang($pay),
            'terbilang' => ucwords(terbilang($pay) . ' Rupiah')
        ];

        return response()->json($data);
    }
}
