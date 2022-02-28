<?php

namespace App\Http\Controllers\Api;

use App\Enums\DeleteStatus;
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
       return response()->json([
           "App_Name" => $app_name->value,
           "App_logo" => $app_name->Applogo,
           "App_Mobile" => $app_mobile->value,
           "App_Email" => $app_email->value,
           "App_Declaimer" => $app_declaimer->value,
           "About_Us" => $about_us->value,
       ]);
    }

    public function searchItem(Request $request){
        $validator = Validator::make($request->all(),[
            'search' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        return  Item::where('item_name', "LIKE", "%$request->search%")->paginate(10);
    }

}
