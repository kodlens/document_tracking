<?php

namespace App\Http\Controllers\Liaison;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Document;


class LiaisonHomeController extends Controller
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

        if($trackNo != ''){
            $data = Document::where('tracking_no', $trackNo)
                ->with(['document_tracks'])
                ->orWhere('document_name', 'like', $trackNo . '%')
                ->first();
        }else{
            return [];
        }
        


        return $data;
    }


}
