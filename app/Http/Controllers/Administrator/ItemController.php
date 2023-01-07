<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Item;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ItemController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.item'); //blade.php
    }

    public function getItems(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Item::where('item_name', 'like', '%' . $req->itemname . '%')
            ->where('barcode', 'like', '%'. $req->barcode . '%')
            ->where('serial', 'like', '%'. $req->serial . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function show($id){
        return Item::find($id);
    }


    public function store(Request $req){
        //this will create random unique QR code
        //$qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        $validate = $req->validate([
            'item_name' => ['required', 'unique:items']
        ]);

        $item = Item::create([
            'barcode' => strtoupper($req->barcode),
            'serial' => strtoupper($req->serial),
            'brand' => strtoupper($req->brand),
            'model' => strtoupper($req->model),
            'item_name' => strtoupper($req->item_name),
            'item_description' => strtoupper($req->item_description)
        ]);

        Inventory::create([
            'item_id' => $item->item_id,
            'qty' => 0,
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){
        $validate = $req->validate([
            'item_name' => ['required', 'unique:items,item_name,'.$id.',item_id'],
        ]);

        $data = Item::find($id);
        $data->barcode = strtoupper($req->barcode);
        $data->serial = strtoupper($req->serial);
        $data->brand = strtoupper($req->brand);
        $data->model = strtoupper($req->model);
        $data->item_name = strtoupper($req->item_name);
        $data->item_description = strtoupper($req->item_description);

        $data->save();

        return response()->json([
            'status' => 'updated'
        ]);
    }


    public function destroy($id){
        Item::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ]);
    }

}
