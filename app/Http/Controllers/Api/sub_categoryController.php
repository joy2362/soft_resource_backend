<?php

namespace App\Http\Controllers\Api;

use App\Enums\DeleteStatus;
use App\Enums\SubCategoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\sub_categoryResource;
use App\Models\sub_category;
use Illuminate\Http\Request;

class sub_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $sub_category = sub_category::where('status',SubCategoryStatus::ACTIVE())->where('is_deleted',DeleteStatus::NO())->get();
        return sub_categoryResource::collection($sub_category);
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
     * @return sub_categoryResource
     */
    public function show(sub_category $sub_category)
    {
        return new sub_categoryResource($sub_category);
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
}
