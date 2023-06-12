<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;

class ReceiveDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function receiveDocument($id){

        DocumentTrack::where('document_track_id', $id)
            ->update([
                'is_received' => 1,
                'datetime_received' => date('Y-m-d H:i:s')
            ]);
        
        return response()->json([
            'status' => 'done'
        ], 200);
    }

}
