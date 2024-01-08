<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:role-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:role-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $roles = Role::orderBy('id', 'desc')->get();
    $permissions = Permission::get();

    return view('pages.roles.index', compact('roles', 'permissions'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|unique:roles,name',
      'permission' => 'required',
    ]);

    $role = Role::create(['name' => $request->input('name')]);
    $role->syncPermissions($request->input('permission'));

    flash()->addSuccess('Role Added');

    return response()->json(['success' => true]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function show(Role $role)
  {
    return view('pages.roles.show', compact('role'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function edit(Role $role)
  {
    $permissions = Permission::get();
    $data = $role->permissions->pluck('id');
    $rolePermissions = [];
    foreach ($data as $p) {
      $rolePermissions[] = $p;
    }
    return view('pages.roles.edit', compact('role', 'permissions', 'rolePermissions'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Role $role)
  {
    $this->validate($request, [
      'name' => 'required|unique:roles,name,' . $role->id
    ]);

    $role->name = $request->input('name');
    $role->save();
    $role->syncPermissions($request->input('permission'));

    flash()->addSuccess('Role Updated');
    return redirect()->route('roles.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function destroy(Role $role)
  {
    if ($role->name != 'Super Admin') {
      $role->delete();
      flash()->addSuccess('Role Deleted');
    }
    return redirect(route('roles.index'));
  }
}
