<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:permission-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $permissions = Permission::get();
    return view('pages.permissions.index', compact('permissions'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    foreach ($request->name as $item) {
      Permission::create(['name' => trim($item)]);
    }

    flash()->addSuccess('Permissions Added');
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $permission = Permission::findOrFail($id);
    $permission->delete();

    flash()->addSuccess('Permission Deleted');
    return back();
  }
}
