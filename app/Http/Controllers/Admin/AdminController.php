<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\sub_category;
use App\Models\Tracker;
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
        $lineChart = Tracker::select(\DB::raw("COUNT(*) as count"), \DB::raw("MONTHNAME(created_at) as month_name"),\DB::raw('max(created_at) as createdAt'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('createdAt')
            ->get();

        $hitCount = Tracker::select(\DB::raw("sum(hits) as count"), \DB::raw("MONTHNAME(created_at) as month_name"),\DB::raw('max(created_at) as createdAt'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('createdAt')
            ->get();
        $visitors = Tracker::totalVisitor();
        $totalHit = Tracker::totalHits();
        $recentVisit = Tracker::totalRecentVisit(10);
        $category= Category::all()->count();
        $subCategory= sub_category::all()->count();
        $item= Item::all()->count();
        $admin  = User::all()->count();
       return view('admin.pages.dashboard',[
           'totalHit'=>$totalHit,'category'=>$category,
           'subCategory'=>$subCategory,'item'=>$item,
           'admin'=>$admin,'visitors'=>$visitors,
           'recentVisit'=>$recentVisit,
           'lineChart'=>$lineChart,
           'hitCount'=>$hitCount
       ]);
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
