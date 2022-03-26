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
use Illuminate\Support\Facades\Auth;

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


    public function multi_recover(Request $request){

        if($request->itemAction == 'restore'){
            Item::whereIn('id',$request->selectedItem)->update([
                'deleted_by' => null,
                'deleted_at' => null,
                'is_deleted' => DeleteStatus::NO(),
                'status' => CategoryStatus::ACTIVE(),
            ]);
            $notification = array(
                'messege' => 'Selected Item Restore Successfully!',
                'alert-type' => 'success'
            );
        }

        if($request->itemAction == 'delete'){
            $items = Item::whereIn('id',$request->selectedItem)->get();
            foreach ($items  as $item){
                $item->download()->delete();
            }
            Item::whereIn('id',$request->selectedItem)->delete();

            $notification = array(
                'messege' => 'Selected Item delete Successfully!',
                'alert-type' => 'success'
            );
        }


        return Redirect()->back()->with($notification);
    }

    public function recover_all(){
        Item::where('is_deleted',DeleteStatus::YES())->update([
            'deleted_by' => null,
            'deleted_at' => null,
            'is_deleted' => DeleteStatus::NO(),
            'status' => ItemStatus::ACTIVE(),
        ]);

         sub_category::where('is_deleted',DeleteStatus::YES())->update([
            'deleted_by' => null,
            'deleted_at' => null,
            'is_deleted' => DeleteStatus::NO(),
            'status' => SubCategoryStatus::ACTIVE(),
        ]);

        Category::where('is_deleted',DeleteStatus::YES())->update([
            'deleted_by' => null,
            'deleted_at' => null,
            'is_deleted' => DeleteStatus::NO(),
            'status' => CategoryStatus::ACTIVE(),
        ]);

        $notification = array(
            'messege' => 'Restore Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function delete_all(){
        $items = Item::where('is_deleted',DeleteStatus::YES())->get();
        foreach ($items  as $item){
            $item->download()->delete();
        }
        Item::where('is_deleted',DeleteStatus::YES())->delete();

        $subCategories = sub_category::where('is_deleted',DeleteStatus::YES())->get();
        foreach ($subCategories as $subCategory){
            $items = Item::where('sub_category_id',$subCategory->id)->get();
            foreach ($items as $item){
                $item->download()->delete();
                $item->delete();
            }
            $subCategory->delete();
        }

        $categories=Category::where('is_deleted',DeleteStatus::YES())->get();
        foreach ($categories as $category){
            $items = Item::where('category_id',$category->id)->get();
            foreach ($items as $item){
                $item->download()->delete();
            }
            $category->items()->delete();
            $category->sub_category()->delete();

            $category->delete();
        }

        $notification = array(
            'messege' => 'Delete Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);

    }

}
