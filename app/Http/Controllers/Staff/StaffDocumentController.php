<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\DocumentTrack;

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

        $officeId = Auth::user()->office_id;
        
        $data = DocumentTrack::where('document_id', $req->document_id)
            ->where('office_id', $officeId)
            ->first();

        //get current order/sequence no
        $orderNo = $data->order_no;
        
        //check if there is another exist office next to the order/sequence no
        $next = DocumentTrack::where('document_id', $req->document_id)
            ->where('order_no', $orderNo + 1); // increment 1;
        
        $existOffice = $next->exists();
        $nextOffice = $next->first();
        
        //TODO if exist
        if($existOffice){
            //check if there is approve receive/process/forward
            if($nextOffice->is_received == 1 || $nextOffice->is_process == 1){
                return response()->json([
                    'errors' => [
                        'back_remarks' => ['Cannot undo, already process by the next office.']
                    ]
                ], 422);
            }
        }


        //$data->is_forward_from = 1;
        $data->is_forwarded = 0;
        $data->is_process = 0;
        $data->datetime_process = null;


        $data->is_received = 0;
        $data->datetime_received = null;

        $data->back_remarks = $req->back_remarks;
        $data->back_datetime = date('Y-m-d H:i');

        $data->save();

        return response()->json([
            'status' => 'back'
        ], 200);
    }

}
