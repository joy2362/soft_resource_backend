<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Enums\DeleteStatus;
use App\Enums\SubCategoryStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\sub_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request){
        if ($request->ajax()){
            $subCategory = sub_category::where('is_deleted',DeleteStatus::NO())->with('category','createdBy')->get();
            $data = DataTables::of($subCategory)
                ->addIndexColumn()
                ->addColumn('actions',function($row){
                    if(auth()->user()->hasPermissionTo('edit sub-category') || auth()->user()->hasRole('Super Admin')){
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" value="'.$row->id.'">Edit</button>';
                    }else{
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" disabled value="'.$row->id.'">Edit</button>';
                    }
                    if(auth()->user()->hasPermissionTo('delete sub-category') || auth()->user()->hasRole('Super Admin')){
                        $btn.=  '<button class="m-2 btn btn-sm btn-danger delete_button"  value="'.$row->id.'">Delete</button>';
                    }else{
                        $btn.=  '<button class="m-2 btn btn-sm btn-danger delete_button" disabled value="'.$row->id.'">Delete</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
            return $data;
        }
        $category = Category::where('is_deleted',DeleteStatus::NO())->where('status',CategoryStatus::ACTIVE())->get();

        return view('admin.pages.subcategory.index',['category'=>$category]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191| unique:sub_categories,sub_category_name',
            'category' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $slug = Str::slug($request->name.'-'.carbon::now()->timestamp);

        $sub_category = new sub_category();

        $sub_category->sub_category_name = $request->name;
        $sub_category->category_id = $request->category;
        $sub_category->slug = $slug;
        $sub_category->created_by = Auth::id();
        $sub_category->save();

        return response()->json([
            'status' => 200,
            'message' => "Sub-Category Added Successfully"
        ]);

    }

    public function edit($id){
        $sub_Category =  sub_category::find($id);
        return response()->json([
            'status' => 200,
            'sub_Category' => $sub_Category
        ]);
    }

    public function update(Request $request, $id){
        $sub_Category =  sub_category::find($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'status' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $sub_Category->sub_category_name = $request->name;
        $sub_Category->category_id = $request->category;
        $sub_Category->updated_by = Auth::id();
        $sub_Category->save();

        return response()->json([
            'status' => 200,
            'message' => "Sub Category Updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        $sub_Category = sub_category::find($id);

        $sub_Category->deleted_by = Auth::id();;
        $sub_Category->deleted_at = date('Y-m-d H:i:s');
        $sub_Category->is_deleted = DeleteStatus::YES();
        $sub_Category->status = SubCategoryStatus::INACTIVE();
        $sub_Category->saveQuietly();

        return response()->json([
            'status' => 200,
            'message' => "Sub Category Deleted successfully"
        ]);
    }

    public function fetch_sub_category(Category $category){
        $sub_category = sub_category::where('category_id',$category->id)->get();

        return response()->json([
            'status' => 200,
            'sub_category' => $sub_category
        ]);
    }
}
