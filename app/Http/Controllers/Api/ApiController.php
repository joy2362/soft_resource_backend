<?php

namespace App\Http\Controllers\Api;

use App\Enums\DeleteStatus;
use App\Enums\ItemStatus;
use App\Enums\SettingName;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function settings(){
        $app_name = Setting::where('name',SettingName::APP_NAME())->first();
        $app_email = Setting::select('value')->where('name',SettingName::APP_EMAIL())->first();
        $app_mobile = Setting::select('value')->where('name',SettingName::APP_MOBILE())->first();
        $app_declaimer = Setting::select('value')->where('name',SettingName::APP_DECLAIMER())->first();
        $about_us = Setting::select('value')->where('name',SettingName::ABOUT_US())->first();
        $acknowledge = Setting::select('value')->where('name',SettingName::ACKNOWLEDGE())->first();
        $quote = Setting::select('value')->where('name',SettingName::QUOTE())->first();

        return response()->json([
            "App_Name" => $app_name->value,
            "App_logo" => $app_name->Applogo,
            "App_Mobile" => $app_mobile->value,
            "App_Email" => $app_email->value,
            "App_Declaimer" => $app_declaimer->value,
            "About_Us" => $about_us->value,
            "Acknowledge" => $acknowledge->value,
            "Quote" => $quote->value,
        ]);
    }

    public function searchItem(Request $request){
        $validator = Validator::make($request->all(),[
            'search' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        if (!empty($request->perPage)){
            return Item::where('item_name', "LIKE", "%$request->search%")->where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())
                ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->orderBy('id', 'DESC')->paginate($request->perPage);
        }

        $item= Item::where('item_name', "LIKE", "%$request->search%")->where('is_deleted',DeleteStatus::NO())->where('status',ItemStatus::ACTIVE())
            ->with(['category:id,category_name' ,'subCategory:id,sub_category_name','download'])->orderBy('id', 'DESC')->get();
        return ItemResource::collection($item);


    }

}