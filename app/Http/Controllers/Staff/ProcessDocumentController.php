<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use App\Models\DocumentLog;
use Auth;

class ProcessDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function processDocument($id){
        $user = Auth::user();

        $docTrack = DocumentTrack::with(['document', 'office'])
            ->find($id);

        $docTrack->is_process = 1;
        $docTrack->datetime_process = date('Y-m-d H:i:s');
        $docTrack->save();
        // DocumentTrack::with(['document', 'office'])
        //     ->where('document_track_id', $id)
        //     ->update([
        //         'is_process' => 1,
        //         'datetime_process' => date('Y-m-d H:i:s')
        //     ]);

        DocumentLog::create([
            'tracking_no' => $docTrack->document->tracking_no,
            'action' => 'PROCESS',
            'action_datetime' => date('Y-m-d H:i'),
            'sys_user' => $user->lname . ', ' . $user->fname,
            'office' => $docTrack->office->office
        ]);

        return response()->json([
            'status' => 'processed'
        ], 200);
    }
}
