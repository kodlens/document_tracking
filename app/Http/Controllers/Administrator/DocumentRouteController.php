<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRoute;



class DocumentRouteController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        return view('administrator.document-route');
    }


    public function getDocumentRoutes(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = DocumentRoute::where('route_name', 'like', $req->route . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function create(){
        return view('administrator.document-route-create-update');
    }

    public function store(Request $req){

    }

    public function update(Request $req, $id){

    }
}
