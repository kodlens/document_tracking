<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;


class ProcessDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function processDocument($id){

        DocumentTrack::where('document_track_id', $id)
            ->update([
                'is_process' => 1,
                'datetime_process' => date('Y-m-d H:i:s')
            ]);

        
        return response()->json([
            'status' => 'processed'
        ], 200);
    }
}
