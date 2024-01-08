<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RawMaterialController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:material-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:material-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:material-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:material-delete', ['only' => ['destroy']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $raw_materials = RawMaterial::orderBy('created_at', 'desc')->get();
    $roles = Role::pluck('name', 'name')->all();

    return view('pages.raw_materials.index', compact('raw_materials', 'roles'));
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $field_length = count($request->material_name);

    // check existing data and set errors
    $errors = [];
    for ($i = 0; $i < $field_length; $i++) {
      $item_exists = RawMaterial::where('material_name', $request->material_name[$i])->where('material_type', $request->material_type[$i])->get();

      if (count($item_exists) == 1) {
        $errors[] = "Duplicate Entry for {$request->material_name[$i]}({$request->material_type[$i]})";
      }
    }

    if (count($errors) == 0) {
      for ($i = 0; $i < $field_length; $i++) {
        $rawMaterial = new RawMaterial();

        $rawMaterial->material_name = ucwords(trim($request->material_name[$i]));
        $rawMaterial->material_type = strtolower(trim($request->material_type[$i]));
        $rawMaterial->material_quantity = 0;
        $rawMaterial->quantity_unit = strtolower(trim($request->quantity_unit[$i]));
        $rawMaterial->req_handler_role = trim($request->req_handler_role[$i]);

        $rawMaterial->save();
      }
    } else {
      return response()->json(['success' => false, 'errors' => $errors]);
    }

    if ($field_length == 1) {
      flash()->addSuccess('Item Added');
    } else {
      flash()->addSuccess('Items Added');
    }

    // return back();

    return response()->json(['success' => true]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\RawMaterial  $rawMaterial
   * @return \Illuminate\Http\Response
   */
  public function show(RawMaterial $rawMaterial)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\RawMaterial  $rawMaterial
   * @return \Illuminate\Http\Response
   */
  public function edit(RawMaterial $rawMaterial)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\RawMaterial  $rawMaterial
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, RawMaterial $rawMaterial)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\RawMaterial  $rawMaterial
   * @return \Illuminate\Http\Response
   */
  public function destroy(RawMaterial $rawMaterial)
  {
    $rawMaterial->delete();

    flash()->addSuccess('Item Deleted');

    return redirect(route('raw-materials.index'));
  }
}
