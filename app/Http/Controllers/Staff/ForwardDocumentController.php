<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentTrack;
use App\Models\DocumentLog;
use Auth;

class ForwardDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function forwardDocument(Request $req, $id, $docId){
        $user = Auth::user();

        $docTrack = DocumentTrack::find($id);
        $docTrack->is_forwarded = 1;
        $docTrack->datetime_forwarded = date('Y-m-d H:i:s');
        $docTrack->back_remarks = null;
        $docTrack->forward_remarks = $req->forward_remarks;

        $docTrack->save();

        // DocumentTrack::where('document_track_id', $id)
        //     ->update([
        //         'is_forwarded' => 1,
        //         'datetime_forwarded' => date('Y-m-d H:i:s'),
        //         'back_remarks' => null
        //     ]);
        
        //get the next track/office
        $nextData = DocumentTrack::with(['office', 'document'])
            ->where('document_id', $docId)
            ->where('is_forwarded', 0)
            ->orderBy('order_no', 'asc')
            ->limit(1)
            ->first();
        
        
        if($nextData){
            //if has next office, execute this update
            $docTrack = DocumentTrack::with(['office', 'document'])
                ->find($nextData->document_track_id);
            $docTrack->is_forward_from = 1;
            $docTrack->save();

            // DocumentTrack::where('document_track_id', $nextData->document_track_id)
            //     ->update([
            //         'is_forward_from' => 1
            //     ]);  

            //if has next office, insert forward
            DocumentLog::create([
                'tracking_no' => $docTrack->document->tracking_no,
                'action' => 'FORWARDED',
                'action_datetime' => date('Y-m-d H:i'),
                'sys_user' => $user->lname . ', ' . $user->fname,
                'office' => $nextData->office->office,
                'remarks' => $req->forward_remarks
            ]);
            
        }else{
            //if no office, consider the transaction is done.
            $docTrack = DocumentTrack::with(['office', 'document'])
                ->find($id);
            $docTrack->is_done = 1;
            $docTrack->datetime_done = date('Y-m-d H:i:s');
            $docTrack->save();

            // DocumentTrack::where('document_track_id', $id)
            //     ->update([
            //         'is_done' => 1,
            //         'datetime_done' => date('Y-m-d H:i:s')
            //     ]);
            //if no office, route is done, record done log
            DocumentLog::create([
                'tracking_no' => $docTrack->document->tracking_no,
                'action' => 'DONE/COMPLETED',
                'action_datetime' => date('Y-m-d H:i'),
                'sys_user' => $user->lname . ', ' . $user->fname,
                'office' => 'DONE/COMPLETED',
                'remarks' => $req->forward_remarks
            ]);
        }

        //for logs
        
        return response()->json([
            'status' => 'forwarded'
        ], 200);

    }
}
