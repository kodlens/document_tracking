<?php

namespace App\Http\Controllers\Liason;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class LiasonDocumentTrackController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function getDocuments(){

    }

    public function store(Request $req){
        
    }
}
