<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingName;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $app_name = Setting::where('name',SettingName::APP_NAME())->first();
        $app_email = Setting::select('value')->where('name',SettingName::APP_EMAIL())->first();
        $app_mobile = Setting::select('value')->where('name',SettingName::APP_MOBILE())->first();
        $app_declaimer = Setting::select('value')->where('name',SettingName::APP_DECLAIMER())->first();
        $about_us = Setting::select('value')->where('name',SettingName::ABOUT_US())->first();
        $quote = Setting::select('value')->where('name',SettingName::QUOTE())->first();

        return view('admin.pages.setting.index',[
            "App_Name" => $app_name->value,
            "App_logo" => $app_name->AppLogo,
            "App_Mobile" => $app_mobile->value,
            "App_Email" => $app_email->value,
            "App_Declaimer" => $app_declaimer->value,
            "About_Us" => $about_us->value,
            "quote" => $quote->value,
            ]);
    }

    public function change_logo(Request $request){
        $request->validate([
            'image' => 'required',
        ]);

       $setting = Setting::where('name',SettingName::APP_NAME())->first();

        if ($request->has('image')) {
            $setting->addMedia($request->file('image'))->toMediaCollection('app_logo');
        }



        $notification = array(
            'messege' => 'Application Logo Changed Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);


    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'about_us' => 'required',
            'declaimer' => 'required',
            'quote' => 'required',
        ]);

        Setting::where('name',SettingName::APP_NAME())->update([
            'value' => $request->input('name')
        ]);

        Setting::where('name',SettingName::APP_EMAIL())->update([
            'value' => $request->input('email')
        ]);

        Setting::where('name',SettingName::APP_MOBILE())->update([
            'value' => $request->input('phone')
        ]);

        Setting::where('name',SettingName::ABOUT_US())->update([
            'value' => $request->input('about_us')
        ]);

        Setting::where('name',SettingName::APP_DECLAIMER())->update([
            'value' => $request->input('declaimer')
        ]);

        Setting::where('name',SettingName::QUOTE())->update([
            'value' => $request->input('quote')
        ]);

        $notification = array(
            'messege' => 'Application Setting Updated Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);

    }
}
