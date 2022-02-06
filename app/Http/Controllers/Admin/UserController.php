<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()){
            $user = User::where('id','!=',Auth::id())->get();
            $data = DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('logo',function($row){
                    return  '<img src="'.$row->avatar.'" width="60px" height="60px" alt="image">';

                })
                ->addColumn('actions',function($row){
                    if(auth()->user()->hasPermissionTo('edit admin') || auth()->user()->hasRole('Super Admin')){
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" value="'.$row->id.'">Edit</button>';
                    }else{
                        $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" disabled value="'.$row->id.'">Edit</button>';
                    }
                    if(auth()->user()->hasPermissionTo('delete admin') || auth()->user()->hasRole('Super Admin')){
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
        $role = Role::all();
        return view("admin.pages.admin.index",['roles'=>$role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'avatar' => 'required|image|mimes:jpg,jpeg,png',
            'role' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $admin = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('avatar')) {
            $admin->addMedia($request->file('avatar'))->toMediaCollection('avatar');
        }

        $role = Role::find($request->role);

        if ($role->name == 'Super Admin'){
            $admin->assignRole($role->name);
        }else{
            $admin->assignRole($role->name);
            $admin->syncPermissions([ $role->permissions]);
        }

        return response()->json([
            'status' => 200,
            'message' => "Admin Added Successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(User $user)
    {
      // return  $user->roles;
        return response()->json([
            'status' => 200,
            'user' => $user,
            'role' => $user->roles[0],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'role' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }
        $user->name = $request->name;
        $user->save();

        $role = Role::find($request->role);

        if ($role->name == 'Super Admin'){
            $user->assignRole($role->name);
        }else{
            $user->assignRole($role->name);
            $user->syncPermissions([ $role->permissions]);
        }

        return response()->json([
            'status' => 200,
            'message' => "Admin Update Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => "Admin Removed Successfully"
        ]);
    }
}
