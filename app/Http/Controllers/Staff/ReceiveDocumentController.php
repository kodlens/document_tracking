<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use Auth;


class ReceiveDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function receiveDocument($id){
        $user = Auth::user();

        DocumentTrack::where('document_track_id', $id)
            ->update([
                'is_received' => 1,
                'datetime_received' => date('Y-m-d H:i:s')
            ]);
        
        DocumentLog::create([
            'action' => 'Document is forwarded.',
            'action_datetime' => date('Y-m-d H:i'),
            'sys_user' => $user->lname . ', ' . $user->fname
        ]);
        
        return response()->json([
            'status' => 'done'
        ], 200);
    }

}
