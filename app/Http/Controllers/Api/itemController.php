<?php

namespace App\Http\Controllers\Api;

use App\Enums\DeleteStatus;
use App\Enums\ItemStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class itemController extends Controller
{
    /**
     * Display a listing of the resource.
     *

     */
    public function index(Request $request)
    {
        $items = Item::where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())->with('category','subCategory')->get();


        if ($request->type =='unzip'){
            return ItemResource::collection($items);
        }
        if ($request->type =='zip'){
            $response = [
                'success' => true,
                'date'=>date("Y-m-d"),
                'data' => $items,
                'message' => 'Schedule data for 3 days found',
                'response_code'=>200,
            ];

            $responsejson=json_encode($response);
            $data=gzencode($responsejson,9);

            return response($data)->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods'=> 'GET',
                'Content-type' => 'application/json; charset=utf-8',
                'Content-Length'=> strlen($data),
                'Content-Encoding' => 'gzip'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ItemResource
     */
    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function requestedItem(){
        $item = Item::where('is_deleted',DeleteStatus::NO())->where('is_requested',1)->where('status',ItemStatus::ACTIVE())->get();
        return ItemResource::collection($item);
    }

    public function sliderItem(){
        $item = Item::where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())->where('is_slider',1)->get();
        return ItemResource::collection($item);
    }
}
