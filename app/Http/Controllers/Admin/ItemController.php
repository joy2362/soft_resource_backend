<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Enums\DeleteStatus;
use App\Enums\ItemStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\sub_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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
    public function index(){
        $items = Item::where('is_deleted',DeleteStatus::NO())->with('category','download','createdBy')->orderBy('id','desc')->get();
        $category = Category::where('is_deleted',DeleteStatus::NO())->where('status',CategoryStatus::ACTIVE())->get();
        return view('admin.pages.item.index',['category'=>$category,'items'=>$items]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('is_deleted',DeleteStatus::NO())->where('status',CategoryStatus::ACTIVE())->get();
        return view('admin.pages.item.add',['category'=>$category]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            'category' => 'required',
            'sub_category' => 'required',
            'style' => 'required',
            'release_date' => 'nullable|date',
            'description' => 'nullable|max:5000',
            'rating' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $item = new Item();
        $item->item_name = $request->name;
        $item->release_date = $request->release_date;
        $item->item_description = $request->description;
        $item->item_rating = $request->rating;
        $item->category_id = $request->category;
        $item->sub_category_id = $request->sub_category;
        $item->style = $request->style;

        $item->is_requested = (bool)$request->is_requested;

        $item->created_by = Auth::id();
        $item->save();

        if ($request->has('image')) {
            $item->addMedia($request->file('image'))->toMediaCollection('image');
        }

        if ($request->has('file')) {
            $item->addMedia($request->file('file'))->toMediaCollection('file');
        }

        if(count(array_filter($request->link)) > 0){

           for($i = 0;$i<count($request->link);$i++){
               $item->download()->create([
                       "type" => $request->type[$i],
                       "link" => $request->link[$i],
                       "label" => $request->link_label[$i],
                       "created_by" => Auth::id(),
                   ]
               );
           }
        }

        $notification = array(
            'messege' => 'Item added Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    public function edit(Item $item){
        $selectedItem = Item::where('is_deleted',DeleteStatus::NO())->where("id",$item->id)->with('category','download','createdBy')->first();
        $category = Category::where('is_deleted',DeleteStatus::NO())->where('status',CategoryStatus::ACTIVE())->get();
        $subcategory = sub_category::where('category_id',$item->category_id)->where('is_deleted',DeleteStatus::NO())->get();
        return view('admin.pages.item.edit',['category'=>$category,'item'=>$selectedItem,'subcategory'=>$subcategory]);
    }

    public function update(Request $request,Item $item)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'category' => 'required',
            'style' => 'required',
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
        $item->style = $request->style;

        $item->is_requested = (bool)$request->is_requested;
        $item->status = $request->status;

        $item->updated_by = Auth::id();
        $item->save();

        if ($request->has('image')) {
            $item->addMedia($request->file('image'))->toMediaCollection('image');
        }

        if ($request->has('file')) {
            $item->addMedia($request->file('file'))->toMediaCollection('file');
        }
        if(count($request->link) >0) {
            $item->download()->delete();
            for ($i = 0; $i < count($request->link); $i++) {
                $item->download()->create([
                    "type" => $request->type[$i],
                    "label" => $request->link_label[$i],
                    "updated_by" => Auth::id(),
                    "link" => $request->link[$i]
                ]);
            }
        }
        $notification = array(
            'messege' => 'Item Update Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);

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

        $notification = array(
            'messege' => 'Item delete Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->route('item.index')->with($notification);
    }


    public function multi_delete(Request $request){
        Item::whereIn('id',$request->selectedItem)->update([
            'deleted_by' => Auth::id(),
            'deleted_at' => date('Y-m-d H:i:s'),
            'is_deleted' => DeleteStatus::YES(),
            'status' => CategoryStatus::INACTIVE(),
        ]);
        $notification = array(
            'messege' => 'Selected Item delete Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->route('item.index')->with($notification);
    }
}
