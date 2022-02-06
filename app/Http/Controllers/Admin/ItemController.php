<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Enums\DeleteStatus;
use App\Enums\ItemStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DownloadLink;
use App\Models\Item;
use App\Models\sub_category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
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
            $items = Item::where('is_deleted',DeleteStatus::NO())->with('category','created_by')->get();
            $data = DataTables::of($items)
                ->addIndexColumn()
                ->addColumn('actions',function($row){
                    if(auth()->user()->hasPermissionTo('edit item') || auth()->user()->hasRole('Super Admin')){
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" value="'.$row->id.'">Edit</button>';
                    }else{
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" disabled value="'.$row->id.'">Edit</button>';
                    }
                    if(auth()->user()->hasPermissionTo('delete item') || auth()->user()->hasRole('Super Admin')){
                        $btn.=  '<button class="m-2 btn btn-sm btn-danger delete_button" value="'.$row->id.'">Delete</button>';
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

        return view('admin.pages.item.index',['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'category' => 'required',
            'sub_category' => 'nullable',
            'release_date' => 'nullable|date',
            'description' => 'nullable|max:5000',
            'rating' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }


        $item = new Item();
        $item->item_name = $request->name;
        $item->release_date = $request->release_date;
        $item->item_description = $request->description;
        $item->item_rating = $request->rating;
        $item->category_id = $request->category;
        $item->sub_category_id = $request->sub_category;

        $item->is_requested = (bool)$request->is_requested;
        $item->is_slider = (bool)$request->is_slider;

        $item->created_by = Auth::id();
        $item->save();

        if ($request->has('image')) {
            $item->addMedia($request->file('image'))->toMediaCollection('image');
        }

        for($i = 0;$i<count($request->type);$i++){
            $item->download()->create([
                    "type" => $request->type[$i],
                    "link" => $request->link[$i],
                    "label" => $request->link_label[$i],
                    "created_by" => Auth::id(),
                ]
            );
        }

        return response()->json([
            'status' => 200,
            'message' => "Item Added Successfully"
        ]);

    }

    public function edit(Item $item){
        $subcategory = sub_category::where('category_id',$item->category_id)->get();
        return response()->json([
            'status' => 200,
            'item' => $item,
            'subcategory'=>$subcategory
        ]);
    }

    public function update(Request $request,Item $item)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'category' => 'required',
            'sub_category' => 'nullable',
            'release_date' => 'nullable|date',
            'description' => 'nullable|max:5000',
            'rating' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $item->item_name = $request->name;
        $item->release_date = $request->release_date;
        $item->item_description = $request->description;
        $item->item_rating = $request->rating;
        $item->category_id = $request->category;
        $item->sub_category_id = $request->sub_category;

        $item->is_requested = (bool)$request->is_requested;
        $item->is_slider = (bool)$request->is_slider;
        $item->status = $request->status;

        $item->updated_by = Auth::id();
        $item->save();

        if ($request->has('image')) {
            $item->addMedia($request->file('image'))->toMediaCollection('image');
        }

        $item->download()->delete();

        for($i = 0;$i<count($request->type);$i++){
            $item->download()->updateOrCreate([
                    "type" => $request->type[$i],
                    "label" => $request->link_label[$i],
                    "updated_by" => Auth::id(),
                ],["link" => $request->link[$i]]
            );
        }

        return response()->json([
            'status' => 200,
            'message' => "Item Update Successfully"
        ]);

    }

    public function destroy(Item $item)
    {
        $item->deleted_by = Auth::id();
        $item->deleted_at = date('Y-m-d H:i:s');
        $item->is_deleted = DeleteStatus::YES();
        $item->status = CategoryStatus::INACTIVE();
        $item->saveQuietly();

        $item->download()->update([
            'deleted_by' => Auth::id(),
            'deleted_at' => date('Y-m-d H:i:s'),
            'is_deleted' => DeleteStatus::YES(),
            'status' => ItemStatus::INACTIVE(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => "Item Deleted successfully"
        ]);
    }


}
