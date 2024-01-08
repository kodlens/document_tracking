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

    public function receiveDocument(Request $req, $id){
        $user = Auth::user();

        //return $req;

        $doc = DocumentTrack::with(['document', 'office'])
            ->find($id);
        
        $doc->is_received = 1;
        $doc->datetime_received = date('Y-m-d H:i:s');
        $doc->receive_remarks = $req->receive_remarks;
        $doc->save();

        DocumentLog::create([
            'tracking_no' => $doc->document->tracking_no,
            'action' => 'RECEIVED',
            'action_datetime' => date('Y-m-d H:i'),
            'sys_user' => $user->lname . ', ' . $user->fname,
            'office' => $doc->office->office,
            'remarks' => $req->receive_remarks
        ]);
        
        return response()->json([
            'status' => 'done'
        ], 200);
    }

}
