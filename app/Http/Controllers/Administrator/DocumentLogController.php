<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DocumentLog;

class DocumentLogController extends Controller
{
    //


    public function index(){
        return view('administrator.document-log');
    }

    public function getDocumentLogs(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = DocumentLog::where('action', 'like', $req->action . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


}
