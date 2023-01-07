<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\StockIn;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.stock-in'); //blade.php
    }

    public function getStockIns(Request $req){

        $sort = explode('.', $req->sort_by);

        $data = StockIn::with(['item'])->whereHas('item', function($q) use ($req){
            $q->where('item_name', 'like',  $req->itemname. '%')
                ->where('barcode', 'like',$req->barcode . '%')
                ->where('serial', 'like', $req->serial . '%');
        })
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }

    public function show($id){
        return Item::find($id);
    }

    public function create(){
        return view('administrator.stock-in-create')
            ->with('id', 0)
            ->with('data', '');
    }

    public function edit($id){
        $data = StockIn::with(['item'])->find($id);

        return view('administrator.stock-in-create')
            ->with('id', $id)
            ->with('data', $data);
    }

    public function store(Request $req){
        //this will create random unique QR code
        //$qr_code = substr(md5(time() . $req->lname . $req->fname), -8);
        $stockDate = date("Y-m-d", strtotime($req->stock_in_date)); //convert to date format UNIX

        $validate = $req->validate([
            'item_id' => ['required'],
            'qty_in' => ['required'],
            'price' => ['required'],
        ]);

        StockIn::create([
            'item_id' => $req->item_id,
            'qty_in' => $req->qty_in,
            'price' => $req->price,
            'stock_in_date' => $stockDate
        ]);


        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){

        $stockDate = date("Y-m-d", strtotime($req->stock_in_date)); //convert to date format UNIX

        $validate = $req->validate([
            'item_id' => ['required'],
            'qty_in' => ['required'],
            'price' => ['required'],
        ]);

        $data = StockIn::find($id);
        $data->item_id = $req->item_id;
        $data->qty_in = $req->qty_in;
        $data->price = $req->price;
        $data->stock_in_date = $stockDate;

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
