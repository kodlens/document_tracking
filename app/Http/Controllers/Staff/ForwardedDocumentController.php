<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\DocumentTrack;

class ForwardedDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function getForwardedDocument(Request $req){
        $sort = explode('.', $req->sort_by);

        $user = Auth::user();

        $data = DocumentTrack::where('office_id', $user->office_id)
            ->with(['document'])
            ->whereHas('document', function($q) use ($req){
                $q->where('tracking_no', 'like',  $req->trackno . '%');
            })
            ->where('is_forward_from', 1)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;

    }
}
