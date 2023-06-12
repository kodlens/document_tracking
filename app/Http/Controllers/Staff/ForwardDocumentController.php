<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;


class ForwardDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function forwardDocument($id, $docId){

        DocumentTrack::where('document_track_id', $id)
            ->update([
                'is_forwarded' => 1,
                'datetime_forwarded' => date('Y-m-d H:i:s')
            ]);
        
            //get the next track/office
        $nextData = DocumentTrack::where('document_id', $docId)
            ->where('is_forwarded', 0)
            ->orderBy('order_no', 'asc')
            ->limit(1)
            ->first();
        
        if($nextData){
            DocumentTrack::where('document_track_id', $nextData->document_track_id)
                ->update([
                    'is_forward_from' => 1, 
                ]);  
        }else{
            DocumentTrack::where('document_track_id', $id)
                ->update([
                    'is_done' => 1,
                    'datetime_done' => date('Y-m-d H:i:s')
                ]);
        }
        
        return response()->json([
            'status' => 'forwarded'
        ], 200);

    }
}
