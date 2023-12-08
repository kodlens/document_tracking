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

}
