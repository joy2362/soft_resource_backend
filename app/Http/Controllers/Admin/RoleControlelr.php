<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleControlelr extends Controller
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
    public function index(Request $request)
    {
        $role = Role::all();
        $permissions = Permission::all();
        return view('admin.pages.role.index',['permissions'=>$permissions,'roles'=>$role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        $permissions = Permission::all();
        return view('admin.pages.role.add',['permissions' => $permissions,'roles'=> $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles',
        ]);

        $role = Role::create([
            'name'=>$request->name,
        ]);

        $role->syncPermissions($request->permissions);

        $notification = array(
            'messege' => 'Role added Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.pages.role.edit',['permissions' => $permissions,'role'=> $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,'.$role->id,
        ]);

        $users = User::role($role->name)->get();

        foreach ($users as $user){
            $user->syncPermissions( $role->permissions );
        }

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        $notification = array(
            'messege' => 'Role Update Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $role->revokePermissionTo(Permission::all());

        $role->delete();

        $notification = array(
            'messege' => 'Role Delete Successfully!',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);

    }
}
