<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web')->except(['two_factor_recover']);
    }

    public function dashboard(){
       return view('admin.pages.dashboard');
    }

    public function image_update(Request $request){
        $request->validate([
            'image' => 'required',
        ]);

        $user = User::find(Auth::id());

        if ($request->has('image')) {
            $user->addMedia($request->file('image'))->toMediaCollection('avatar');
        }

        $notification = array(
            'messege' => 'Profile Image Changed Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function two_factor_recover(){
        return view("auth.two-factor-recovery");
    }

    public function profile_edit(){
        return view('admin.pages.profile_setting.profile');
    }

    public function profile_setting(){
        return view('admin.pages.profile_setting.index');
    }

    public function recoveryCodeShow(){
        return view('admin.pages.profile_setting.recovery');
    }
}
