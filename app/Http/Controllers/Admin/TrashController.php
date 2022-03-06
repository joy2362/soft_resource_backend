<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Enums\DeleteStatus;
use App\Enums\ItemStatus;
use App\Enums\SubCategoryStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DownloadLink;
use App\Models\Item;
use App\Models\sub_category;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::where('is_deleted',DeleteStatus::YES())->with('deletedBy')->get();
        $subCategory = sub_category::where('is_deleted',DeleteStatus::YES())->with('deletedBy')->get();
        $item = Item::where('is_deleted',DeleteStatus::YES())->with('deletedBy')->get();
        return view('admin.pages.recycle.index',['category'=>$category,'subCategory'=>$subCategory,'item'=>$item]);
    }

    public function categoryRecover(Category $category){
        $category->deleted_at = null;
        $category->deleted_by = null;
        $category->is_deleted = DeleteStatus::NO();
        $category->status = CategoryStatus::ACTIVE();
        $category->save();

        $notification = array(
            'messege' => 'Category Restore Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function subCategoryRecover($id){
        $subCategory = sub_category::find($id);
        $subCategory->deleted_at = null;
        $subCategory->deleted_by = null;
        $subCategory->is_deleted = DeleteStatus::NO();
        $subCategory->status = SubCategoryStatus::ACTIVE();
        $subCategory->save();

        $notification = array(
            'messege' => 'Sub Category Restore Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function itemRecover(Item $item){
        $item->deleted_at = null;
        $item->deleted_by = null;
        $item->is_deleted = DeleteStatus::NO();
        $item->status = ItemStatus::ACTIVE();
        $item->save();

        $notification = array(
            'messege' => 'Item Restore Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function categoryForceDelete(Category $category){

        $items = Item::where('category_id',$category->id)->get();
        foreach ($items as $item){
            $item->download()->delete();
        }
        $category->items()->delete();
        $category->sub_category()->delete();

        $category->delete();
        $notification = array(
            'messege' => 'Category Delete Permanently!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function subCategoryForceDelete($id){
        $subCategory = sub_category::find($id);
        $items = Item::where('sub_category_id',$id)->get();
        foreach ($items as $item){
            $item->download()->delete();
            $item->delete();
        }
        $subCategory->delete();
        $notification = array(
            'messege' => 'Sub Category Delete Permanently!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);

    }

    public function itemForceDelete(Item $item){
        $item->download()->delete();
        $item->delete();

        $notification = array(
            'messege' => 'Item Delete Permanently!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

}
