<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        return view('staff.staff-documents');
    }

}
