<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use Auth;
use App\Models\DocumentLog;


class ReceiveDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function receiveDocument($id){
        $user = Auth::user();

        $doc = DocumentTrack::with(['document'])
            ->find($id);
        
        $doc->is_received = 1;
        $doc->datetime_received = date('Y-m-d H:i:s');
        $doc->save();

        DocumentLog::create([
            'tracking_no' => $doc->document->tracking_no,
            'action' => 'RECEIVED',
            'action_datetime' => date('Y-m-d H:i'),
            'sys_user' => $user->lname . ', ' . $user->fname
        ]);
        
        return response()->json([
            'status' => 'done'
        ], 200);
    }

}
