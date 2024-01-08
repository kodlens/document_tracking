<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\DocumentTrack;
use App\Models\DocumentLog;
class StaffDocumentController extends Controller
{
    //

    public function index(){
        return view('staff.staff-documents');
    }



    public function countForwardedDoc(){
        $user = Auth::user();

        $officeId = $user->office_id;
        return DocumentTrack::where('is_forward_from', 1)
            ->where('office_id', $officeId)
            ->where('is_forwarded', 0)
            ->count();
    }


    public function undoForwardReceive(Request $req){

        $user = Auth::user();
        
        $data = DocumentTrack::with(['document', 'office'])
            ->where('document_id', $req->document_id)
            ->where('office_id', $user->office_id)
            ->first();

        //get current order/sequence no
        $orderNo = $data->order_no;
        
        //check if there is another exist office next to the order/sequence no
        $next = DocumentTrack::with(['office', 'document'])
            ->where('document_id', $req->document_id)
            ->where('order_no', $orderNo + 1); // increment 1;
        
        $existOffice = $next->exists();
        $nextOffice = $next->first();
        
        //TODO if exist
        if($existOffice){
            //check if there is approve receive/process/forward
            if($nextOffice->is_received == 1 || $nextOffice->is_process == 1){
                //throw error
                return response()->json([
                    'errors' => [
                        'back_remarks' => ['Cannot undo, already process by the next office.']
                    ]
                ], 422);
            }
        }


        //$data->is_forward_from = 1;
        $data->is_forwarded = 0;
        $data->forward_remarks = null;
        $data->is_process = 0;
        $data->datetime_process = null;


        $data->is_received = 0;
        $data->receive_remarks = null;
        $data->datetime_received = null;

        $data->back_remarks = $req->back_remarks;
        $data->back_datetime = date('Y-m-d H:i');

        $data->save();

        DocumentLog::create([
            'tracking_no' => $data->document->tracking_no,
            'action' => 'RETURN',
            'action_datetime' => date('Y-m-d H:i'),
            'sys_user' => $user->lname . ', ' . $user->fname,
            'office' => $data->office->office,
            'remarks' => $req->back_remarks
        ]);
        

        return response()->json([
            'status' => 'back'
        ], 200);
    }

}
