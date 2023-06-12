<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.user'); //blade.php
    }

    public function getUsers(Request $req){
        $sort = explode('.', $req->sort_by);

        $users = User::with(['office'])
            ->where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $users;
    }

    public function show($id){
        return User::find($id);
    }

    public function store(Request $req){
        //this will create random unique QR code
        $qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed'],
            'role' => ['required', 'string'],
            'office_id' => ['required_if:role,STAFF',],
            
        ],[
            'office_id.required_if' => 'The office field is required when role is STAFF.'
        ]);

        User::create([

            'username' => $req->username,
            'password' => Hash::make($req->password),
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'sex' => $req->sex,
            'suffix' => strtoupper($req->suffix),
            'contact_no' => $req->contact_no,
            'office_id' => $req->office_id ? $req->office_id : 0,
            'role' => $req->role,

        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){
        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users,username,'.$id.',user_id'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string'],
            'office_id' => ['required_if:role,STAFF',]
        ],[
            'office_id.required_if' => 'The office field is required when role is STAFF.'
        ]);

        $data = User::find($id);
        $data->username = $req->username;
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->suffix = strtoupper($req->suffix);
        $data->office_id = $req->office_id;
        $data->sex = $req->sex;
        $data->role = $req->role;

        $data->save();

        return response()->json([
            'status' => 'updated'
        ]);
    }


    public function destroy($id){
        User::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}
