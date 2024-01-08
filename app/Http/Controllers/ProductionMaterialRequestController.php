<?php

namespace App\Http\Controllers;

use App\Models\ProductionMaterial;
use App\Models\ProductionMaterialRequest;
use App\Models\ProductionMatReqConfirmation;
use App\Models\RawMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductionMaterialRequestController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:production-req-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:production-req-create', ['only' => ['create', 'store', 'get_pac_sizes']]);
    $this->middleware('permission:production-req-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:production-req-delete', ['only' => ['destroy']]);
    $this->middleware('permission:production-req-confirm', ['only' => ['queue_list', 'confirmation']]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $status = ['pending', 'confirmed', 'cancelled'];
    $class_names = ['warning', 'success', 'danger'];
    $prod_mat_reqs = ProductionMaterialRequest::orderBy('created_at', 'desc')->get();

    return view('pages.production_material_requests.index', compact('prod_mat_reqs', 'status', 'class_names'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $production_materials = ProductionMaterial::select('material_name')->groupBy('material_name')->get();

    return view('pages.production_material_requests.create', compact('production_materials'));
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
      'material_name' => 'required',
      'pac_size' => 'required',
      'material_quantity' => 'required|numeric',
    ]);

    $prod_mat_id = ProductionMaterial::where('material_name', $request->material_name)->where('pac_size', $request->pac_size)->select('id')->first()->id;

    $raw_material = ProductionMaterial::findOrFail($prod_mat_id)->raw_material;

    // get raw materials with material_type and material_quantity
    $data = RawMaterial::where('material_type', $request->pac_size . 'ltr')->select('material_name', 'material_quantity')->get();

    $errors = array();
    $is_errors = false;
    // check bottle, cap and label availability
    $items = ['Bottle', 'Label', 'Cap'];
    $avl_items = $data->pluck('material_name')->toArray();
    $not_avl_items = array_diff($items, $avl_items);

    if (count($not_avl_items) > 0) {
      // return response()->json(['success' => false, 'type' => 'items', 'msg' => 'There is no ' . implode(', ', $not_avl_items) . ' available for this Pac Size!']);
      $errors['items'] = 'There is no ' . implode(', ', $not_avl_items) . ' available for this Pac Size!';
      $is_errors = true;
    }

    // get bottle, cap and label quantity
    $avl_items_with_qty = $data->pluck('material_quantity', 'material_name')->toArray();

    // check bottle, cap and label quantity
    $items_stock_error = array();
    foreach ($avl_items_with_qty as $key => $value) {
      if ($request->material_quantity > $value) {
        $items_stock_error[] = $key;
      }
    }

    // send error for items availability
    if (count($items_stock_error) > 0) {
      // return response()->json(['success' => false, 'type' => 'items', 'msg' => implode(', ', $items_stock_error) . ' not in stock for this Pac Size!']);
      $errors['items'] = implode(', ', $items_stock_error) . ' not in stock for this Pac Size!';
      $is_errors = true;
    }

    // get raw material quantity
    $stk_qty_in_kg = $raw_material->material_quantity;
    $stk_qty_in_ltr = (1 / .9) * $stk_qty_in_kg;
    $req_qty_in_ltr = trim($request->pac_size) * trim($request->material_quantity);

    // check quantity availability
    if ($req_qty_in_ltr > $stk_qty_in_ltr) {
      // return response()->json(['success' => false, 'type' => 'quantity', 'msg' => 'Requested quantity is more than stock!']);
      $errors['quantity'] = 'Requested quantity is more than stock!';
      $is_errors = true;
    }

    if ($is_errors) {
      return response()->json(['success' => false, $errors]);
    }

    $new_req = new ProductionMaterialRequest();

    $new_req->production_material_id = $prod_mat_id;
    $new_req->production_material_quantity = $request->material_quantity;
    $new_req->requested_by = Auth::user()->id;
    $new_req->cancelled_by = null;

    $new_req->save();

    // distribute confimation process
    $users = User::role($new_req->production_material->req_handler_role)->get();
    foreach ($users as $user) {
      $prod_mat_req_conf = new ProductionMatReqConfirmation();

      $prod_mat_req_conf->prod_mat_req_id = $new_req->id;
      $prod_mat_req_conf->user_id = $user->id;

      $prod_mat_req_conf->save();
    }

    flash()->addSuccess('Production request created');

    return response()->json(['success' => true]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ProductionMaterialRequest  $productionMaterialRequest
   * @return \Illuminate\Http\Response
   */
  public function show(ProductionMaterialRequest $productionMaterialRequest)
  {
    $status = ['pending', 'confirmed', 'cancelled'];
    $class_names = ['warning', 'success', 'danger'];

    $prod_mat_req = $productionMaterialRequest;

    return view('pages.production_material_requests.show', compact('prod_mat_req', 'status', 'class_names'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ProductionMaterialRequest  $productionMaterialRequest
   * @return \Illuminate\Http\Response
   */
  public function edit(ProductionMaterialRequest $productionMaterialRequest)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ProductionMaterialRequest  $productionMaterialRequest
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ProductionMaterialRequest $productionMaterialRequest)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ProductionMaterialRequest  $productionMaterialRequest
   * @return \Illuminate\Http\Response
   */
  public function destroy(ProductionMaterialRequest $productionMaterialRequest)
  {
    $productionMaterialRequest->delete();

    flash()->addSuccess('Production request deleted');
    return redirect(route('production-material-requests.index'));
  }

  // get pac sizes as per production material name
  public function get_pac_sizes(Request $request)
  {
    $material_name = $request->material_name;

    $pac_sizes = ProductionMaterial::where('material_name', $material_name)->select('pac_size')->get();

    return response()->json(['success' => true, 'pac_sizes' => $pac_sizes]);
  }

  // work for queue list
  public function queue_list()
  {
    $user_id = Auth::user()->id;
    $status = ['pending', 'confirmed', 'cancelled'];

    $prod_mat_reqs = ProductionMatReqConfirmation::where('user_id', $user_id)->where('status', 0)->get();

    return view('pages.production_material_requests.queue_list', compact('prod_mat_reqs', 'status'));
  }

  // request confirmation process
  public function confirmation(Request $request, $id)
  {
    $req_confirmation = ProductionMatReqConfirmation::findOrFail($id);
    $production_request = ProductionMaterialRequest::findOrFail($req_confirmation->prod_mat_req_id);

    $status = $request->status;

    if ($status != 2) {
      // check stock availability for product
      $raw_material = $production_request->production_material->raw_material;
      $stk_qty_in_kg = $raw_material->material_quantity;
      $stk_qty_in_ltr = (1 / .9) * $stk_qty_in_kg;
      $req_qty_in_ltr = $production_request->production_material->pac_size * $production_request->production_material_quantity;

      $prod_stock = true;
      if ($req_qty_in_ltr > $stk_qty_in_ltr) {
        flash()->addError('Product Not In Stock!');
        $prod_stock = false;
      }

      // check stock availability for items
      $items_stock = true;

      // get raw materials with material_type and material_quantity
      $data = RawMaterial::where('material_type', $production_request->production_material->pac_size . 'ltr')->get();

      // get bottle, cap and label quantity
      $avl_items_with_qty = $data->pluck('material_quantity', 'material_name')->toArray();

      // check bottle, cap and label quantity
      foreach ($avl_items_with_qty as $key => $value) {
        if ($production_request->production_material_quantity > $value) {
          flash()->addError($key . ' Not In Stock!');
          $items_stock = false;
        }
      }
    }

    // change status
    if ($status == 2) {
      DB::table('production_mat_req_confirmations')->where('prod_mat_req_id', $req_confirmation->prod_mat_req_id)->update(['status' => $status, 'confirmed_at' => null]);

      // update request fields
      $production_request->update([
        'cancelled_by' => Auth::user()->id,
        'updated_at' => now()
      ]);
      $production_request->save();
    } else {
      if ($items_stock && $prod_stock) {
        $req_confirmation->update([
          'status' => $status,
          'confirmed_at' => now()
        ]);
        $req_confirmation->save();

        // update request fields
        $production_request->update([
          'updated_at' => now()
        ]);
        $production_request->save();
      }
    }

    // check all request and update quantity
    $all_requests = ProductionMatReqConfirmation::where('prod_mat_req_id', $req_confirmation->prod_mat_req_id)->get();
    $confirmation = true;

    foreach ($all_requests as $req) {
      if ($req->status != 1) {
        $confirmation = false;
      }
    }

    if ($confirmation && $items_stock && $prod_stock) {
      // update production material
      $prod_mat_id = $production_request->production_material_id;

      $production_material = ProductionMaterial::findOrFail($prod_mat_id);
      $production_material->material_quantity += $production_request->production_material_quantity;
      $production_material->updated_at = now();
      $production_material->save();

      flash()->addSuccess('Production Quantity Updated');

      // update raw material
      $raw_material_id = $production_request->production_material->raw_material_id;
      $req_qty_in_kg = $req_qty_in_ltr * 0.9;

      $raw_material = RawMaterial::findOrFail($raw_material_id);
      $raw_material->material_quantity -= $req_qty_in_kg;
      $raw_material->updated_at = now();
      $raw_material->save();

      flash()->addSuccess('Raw Quantity Updated');

      // Update raw items
      foreach ($data as $item) {
        $raw_mat_item = RawMaterial::findOrFail($item->id);
        $raw_mat_item->material_quantity -= $production_request->production_material_quantity;
        $raw_mat_item->updated_at = now();

        $raw_mat_item->save();

        flash()->addSuccess($raw_mat_item->material_name . ' Stock Updated');
      }
    }

    if ($status == 2) {
      flash()->addWarning('Request Cancelled');
    } else if ($items_stock && $prod_stock) {
      flash()->addSuccess('Request Confirmed');
    }

    return back();
  }
}
