<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Repo\RoleRepository;
use App\Models\User;
use App\Models\Permission;
use Cache;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = Cache::remember('roles', 600, function(){
            return \DB::table('roles')->get();
        });
        
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->roleRepository->create($request->all());

        return redirect(route('roles.index'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $this->authorize('update', Role::class);
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->seve();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Role::class);
    }

    public function setRole(Request $request, User $user)
    {
        $role = $request->role_id;
        $user->role()->sync($role);

        return redirect(route('users.index'))-> with('noti', 'success');
    }

    public function getIndex()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('permissions.index', compact('permissions', 'roles'));
    }

    public function createPermission()
    {
        return view('permissions.create');
    }

    public function storePermission(Request $request)
    {
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();

        return redirect(route('permission.create'));
    }

    public function setPermission(Request $request)
    {
        // dd($request->all());
        $role =Role::findOrFail($request->role_id);
        $permission = $request->permission_id;
        $role->permissions()->sync($permission);

        return redirect(route('permission.index'));
    }
}
