<?php

namespace App\Http\Controllers;

use App\Models\ProductionMaterial;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ProductionMaterialController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:production-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:production-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:production-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:production-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $production_materials = ProductionMaterial::orderBy('created_at', 'desc')->get();

    return view('pages.production_materials.index', compact('production_materials'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $roles = Role::pluck('name', 'name')->all();
    $raw_materials = RawMaterial::where('material_quantity', '>', 0)->get();

    return view('pages.production_materials.create', compact('raw_materials', 'roles'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'raw_material_id' => 'required',
      'pac_size' => 'required',
      'req_handler_role' => 'required'
    ]);

    $raw_material = RawMaterial::findOrFail($request->raw_material_id);

    $production_material = new ProductionMaterial();

    $production_material->material_name = ucwords($raw_material->material_type) . ' ' . ucwords($raw_material->material_name);
    $production_material->raw_material_id = $request->raw_material_id;
    $production_material->pac_size = $request->pac_size;
    $production_material->material_quantity = 0;
    $production_material->req_handler_role = $request->req_handler_role;

    // Check duplicate item and send error if exists
    $if_exists = ProductionMaterial::where('material_name', $production_material->material_name)->where('pac_size', $production_material->pac_size)->get();

    if (count($if_exists) > 0) {
      flash()->addError('Duplicate item. Try with another product!!');

      return back()->withInput();
    } else {
      $production_material->save();
      flash()->addSuccess('Production Material Added');

      return redirect(route('production-materials.index'));
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ProductionMaterial  $productionMaterial
   * @return \Illuminate\Http\Response
   */
  public function show(ProductionMaterial $productionMaterial)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ProductionMaterial  $productionMaterial
   * @return \Illuminate\Http\Response
   */
  public function edit(ProductionMaterial $productionMaterial)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ProductionMaterial  $productionMaterial
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ProductionMaterial $productionMaterial)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ProductionMaterial  $productionMaterial
   * @return \Illuminate\Http\Response
   */
  public function destroy(ProductionMaterial $productionMaterial)
  {
    $productionMaterial->delete();

    flash()->addSuccess('Production Material Deleted');

    return redirect(route('production-materials.index'));
  }
}
