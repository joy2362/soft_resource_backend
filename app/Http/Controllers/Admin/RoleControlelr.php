<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleControlelr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $role = Role::all();
            $data = DataTables::of($role)
                ->addIndexColumn()

                ->addColumn('actions',function($row){
                    $btn =  '<button class="m-2 btn btn-sm btn-primary edit_button" value="'.$row->id.'">Edit</button>';
                    $btn.=  '<button class="m-2 btn btn-sm btn-danger delete_button" value="'.$row->id.'">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
            return $data;
        }
        $permissions = Permission::all();
        return view('admin.pages.role.index',['permissions'=>$permissions]);
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
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $role = Role::create([
            'name'=>$request->name,
        ]);

        $role->syncPermissions($request->permissions);

        return response()->json([
            'status' => 200,
            'message' => "Role Added Successfully"
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Role $role)
    {
        return response()->json([
            'status' => 200,
            'role' => $role,
            'permissions' => $role->permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        return response()->json([
            'status' => 200,
            'message' => "Role Update Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->revokePermissionTo(Permission::all());

        $role->delete();
        return response()->json([
            'status' => 200,
            'message' => "Role Delete Successfully"
        ]);

    }
}
