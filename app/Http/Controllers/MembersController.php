<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use PDF;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $data = Member::orderBy('member_code')->get();
        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->addColumn('select', function($data){
            return '<input type="checkbox" name="member_id[]" value="'. $data->member_id .'">';
        })
        ->addColumn('code', function($data){
                return '<span class="badge badge-secondary">'. $data->code .'</span>';
        })
        ->addColumn('action', function($data){
            return '
                <button type="button" onclick="editForm(`'. route('members.update', $data->member_id) .'`)" class="badge badge-info border-0 p-2"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="deleteData(`'. route('members.destroy', $data->member_id) .'`)" class="badge badge-danger border-0 p-2"><i class="fa fa-trash"></i></button>
            ';
        })
        ->rawColumns(['action', 'code', 'select'])
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
        $m = Member::latest()->first() ?? new Member();
        $code = (int)substr($m->member_code, 2) + 1;

        $member = new Member();
        $member->member_code = "M-" . add_zero($code, 6);
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->address = $request->address;
        $member->save();

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
        $data = Member::find($id);
        return response()->json($data);
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
        $data = Member::find($id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->update();

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
        $data = Member::find($id);
        $data->delete();

        return response(null, 204);
    }

    function cetak(Request $request)
    {
        $barcode = array();
        foreach ($request->member_id as $id) {
            $member = Member::find($id);
            $barcode[] = $member;
        }

        $no = 1;
        $pdf = PDF::loadView('member.barcode', compact('barcode', 'no'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('member.pdf');
    }
}
