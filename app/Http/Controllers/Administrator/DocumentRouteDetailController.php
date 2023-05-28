<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DocumentRouteDetail;


class DocumentRouteDetailController extends Controller
{
    //



    public function update(Request $req, $id){
        $req->validate([
            'order_no' => ['required', 'numeric'],
            'office_id' => ['required', 'numeric'],
        ]);
        $data = DocumentRouteDetail::find($id);

        $data->order_no = $req->order_no;
        $data->office_id = $req->office_id;

        $data->is_origin = $req->is_origin;
        $data->is_last = $req->is_last;

        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){
        $data = DocumentRouteDetail::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ], 200);
    }

}
