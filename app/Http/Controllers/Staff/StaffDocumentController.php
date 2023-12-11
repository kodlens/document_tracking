<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\DocumentTrack;

class StaffDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


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
