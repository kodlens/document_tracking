<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRoute;
use App\Models\DocumentRouteDetail;



class DocumentRouteController extends Controller
{
    //

    public function index(){
        return view('administrator.document-route');
    }

    public function getDocumentRoutes(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = DocumentRoute::with(['route_details'])
            ->where('route_name', 'like', $req->route . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function create(){
        return view('administrator.document-route-create-update');
    }

    public function store(Request $req){

        $req->validate([
            'route_name' => ['required', 'unique:routes']
        ]);

        $data = DocumentRoute::create([
            'route_name' => $req->route_name
        ]);

        foreach($req->route_details as $item){
            DocumentRouteDetail::create([
                'route_id' => $data->route_id,
                'order_no' => $item['order_no'],
                'office_id' => $item['office_id'],
                'is_origin' => $item['is_origin'],
                'is_last' => $item['is_last'],
            ]);
        }

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){

    }

    public function destroy($id){
        
        DocumentRoute::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
