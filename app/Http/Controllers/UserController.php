<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:user-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:user-delete', ['only' => ['destroy']]);
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::orderBy('created_at', 'desc')->get();
    return view('pages.users.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $roles = Role::pluck('name', 'name')->all();
    return view('pages.users.create', compact('roles'));
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
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|same:confirm-password',
      'roles' => 'required'
    ]);

    $input = $request->all();
    $input['password'] = Hash::make($input['password']);

    $user = User::create($input);
    $user->assignRole($request->input('roles'));

    flash()->addSuccess('User Created');
    return redirect()->route('users.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::find($id);
    return view('pages.users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    $roles = Role::pluck('name', 'name')->all();
    $userRoles = $user->roles->pluck('name')->all();

    return view('pages.users.edit', compact('user', 'roles', 'userRoles'));
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
    $request->validate([
      'name' => 'required',
      'email' => 'required|email|unique:users,email,' . $id,
      'password' => 'same:confirm-password',
      'roles' => 'required'
    ]);

    $input = $request->all();
    if (!empty($input['password'])) {
      $input['password'] = Hash::make($input['password']);
    } else {
      $input = Arr::except($input, array('password'));
    }

    $user = User::find($id);

    $user->update($input);
    DB::table('model_has_roles')->where('model_id', $id)->delete();

    $user->assignRole($request->input('roles'));
    return redirect()->route('users.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);

    $user->delete();

    flash()->addSuccess('User Deleted');
    return redirect(route('users.index'));
  }
}
