<?php

namespace App\Http\Controllers\Api;

use App\Enums\DeleteStatus;
use App\Enums\ItemStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Tracker;
use Illuminate\Http\Request;

class itemController extends Controller
{
    /**
     * Display a listing of the resource.
     *

     */
    public function index()
    {
        $items = Item::where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())
            ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->get();

        return ItemResource::collection($items);
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
        Tracker::hit();
        $selectedItem = Item::where('is_deleted',DeleteStatus::NO())->where("id",$item->id)->with('category','download','createdBy')->first();
        return new ItemResource($selectedItem);
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
        $item = Item::where('is_deleted',DeleteStatus::NO())->where('is_requested',1)->where('status',ItemStatus::ACTIVE())
            ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->get();
        return ItemResource::collection($item);
    }

    public function itemByCategory($id,Request $request){
        if (!empty($request->perPage)){
            return Item::where('category_id',$id)->where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())
                ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->orderBy('id', 'DESC')->paginate($request->perPage);
        }
        $item= Item::where('category_id',$id)->where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())
            ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->orderBy('id', 'DESC')->get();
        return ItemResource::collection($item);
    }

    public function itemBySubCategory($id,Request $request){
       // dd($request->perPage);
        if (!empty($request->perPage)){
            return Item::where('sub_category_id',$id)->where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())
                ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->orderBy('id', 'DESC')->paginate($request->perPage);
        }

        $item= Item::where('sub_category_id',$id)->where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())
            ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->orderBy('id', 'DESC')->get();
        return ItemResource::collection($item);
    }
}