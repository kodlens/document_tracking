<?php

namespace App\Http\Controllers\Liason;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Document;
use App\Models\DocumentRoute;
use App\Models\DocumentRouteDetail;
use App\Models\DocumentTrack;



class LiasonDocumentController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        return view('liason.liason-documents');
    }

    public function getDocumentRoutes(){
        return DocumentRoute::with('route_details')
            ->get();
    }

    public function getDocuments(Request $req){
        $sort = explode('.', $req->sort_by);

        $user = Auth::user();

        $data = Document::with(['route', 'document_tracks'])
            ->where('user_id', $user->user_id)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function store(Request $req){
        //return $req;

        $req->validate([
            'document_name' => ['required', 'unique:documents'],
            'route_id' => ['required']
        ], $message = [
            'route_id.required' => 'Select document route.'
        ]);

        $trakcing_no = strtoupper(substr(md5(time() . $req->document_name), -15));
        $user = Auth::user();

        $routeDetails = DocumentRouteDetail::where('route_id', $req->route_id)
            ->orderBy('order_no', 'asc')
            ->get();

        $data = Document::create([
            'user_id' => $user->user_id,
            'tracking_no' => $trakcing_no,
            'document_name' => $req->document_name,
            'route_id' => $req->route_id
        ]);


        foreach($routeDetails as $detail){
            DocumentTrack::create([
                'document_id' => $data->document_id,
                'route_id' => $req->route_id,
                'route_detail_id' => $detail['route_detail_id'],
                'office_id' => $detail['office_id'],
                'order_no' => $detail['order_no'],
                'is_origin' => $detail['is_origin'],
                'is_last' => $detail['is_last']
            ]);
        }

        return response()->json([
            'status' => 'saved'
        ], 200);;

    }

    public function forwardDoc($id){

        //get the next step
        $nextData = DocumentTrack::where('document_id', $id)
            ->where('is_forwarded', 0)
            ->orderBy('order_no', 'asc')
            ->limit(1)
            ->first();

        DocumentTrack::where('document_id', $id)
            ->where('is_origin', 1)
            ->update([
                'is_forwarded' => 1, 
                'datetime_forwarded' => date('Y-m-d H:i:s')
            ]);

        DocumentTrack::where('document_track_id', $nextData->document_track_id)
            ->update([
                'is_forward_from' => 1, 
            ]);   
 
        return response()->json([
            'status' => 'forwarded'
        ], 200);
    }


    public function destroy($id){
        Document::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
