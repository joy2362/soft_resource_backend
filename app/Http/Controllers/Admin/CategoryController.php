<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Enums\DeleteStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request){
        if ($request->ajax()){
            $category = Category::where('is_deleted',DeleteStatus::NO())->get();
            $data = DataTables::of($category)
                ->addIndexColumn()
                ->addColumn('logo',function($row){
                    return  '<img src="'.$row->logo.'" width="60px" height="60px" alt="image">';
                })
                ->addColumn('actions',function($row){

                    if(auth()->user()->hasPermissionTo('edit category') || auth()->user()->hasRole('Super Admin')){
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" value="'.$row->id.'">Edit</button>';
                    }else{
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button " disabled value="'.$row->id.'">Edit</button>';
                    }
                    if(auth()->user()->hasPermissionTo('delete category') || auth()->user()->hasRole('Super Admin')){
                        $btn.=  '<button class="m-2 btn btn-sm btn-danger delete_button" value="'.$row->id.'">Delete</button>';
                    }else{
                        $btn.=  '<button class="m-2 btn btn-sm btn-danger delete_button" disabled value="'.$row->id.'">Delete</button>';

                    }

                        return $btn;
                })
                ->rawColumns(['logo','actions'])
                ->make(true);
            return $data;
        }
       // return Category::all();
        return view('admin.pages.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191| unique:categories,category_name',
            'logo' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $slug = Str::slug($request->name.'-'.carbon::now()->timestamp);

        $category = new Category();
        $category->category_name = $request->name;
        $category->slug = $slug;
        $category->created_by = Auth::id();
        $category->save();

        if ($request->has('logo')) {
            $category->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        return response()->json([
            'status' => 200,
            'message' => "Category Added Successfully"
        ]);
    }

    public function edit(Category $category){
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Category $category)
    {
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

        $category->category_name = $request->name;
        $category->status = $request->status;

        $category->save();

        if ($request->hasFile('logo')){
            $category->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        return response()->json([
            'status' => 200,
            'message' => "Category Updated Successfully"
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy(Category $category)
    {
        $category->deleted_by = Auth::id();
        $category->deleted_at = date('Y-m-d H:i:s');
        $category->is_deleted = DeleteStatus::YES();
        $category->status = CategoryStatus::INACTIVE();
        $category->saveQuietly();

        return response()->json([
            'status' => 200,
            'message' => "Category Deleted successfully"
        ]);
    }

}
