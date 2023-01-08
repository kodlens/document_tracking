<?php

namespace App\Http\Controllers\Liason;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Document;


class LiasonHomeController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('liason.liason-home');
    }

    public function searchTrackNo(Request $req){
        $trackNo = $req->trackno;

        $data = Document::where('tracking_no', $trackNo)
            ->with(['document_tracks'])
            ->first();


        return $data;
    }


}
