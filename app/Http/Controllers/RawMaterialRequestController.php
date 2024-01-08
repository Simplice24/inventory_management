<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\RawMaterialRequest;
use App\Models\RawMatReqConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RawMaterialRequestController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function __construct()
  {
    $this->middleware('permission:raw-req-list', ['only' => ['index', 'show']]);
    $this->middleware('permission:raw-req-create', ['only' => ['create', 'store', 'get_item_types']]);
    $this->middleware('permission:raw-req-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:raw-req-delete', ['only' => ['destroy']]);
    $this->middleware('permission:raw-req-confirm', ['only' => ['queue_list', 'confirmation']]);
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
    $raw_mat_reqs = RawMaterialRequest::orderBy('created_at', 'desc')->get();

    return view('pages.raw_material_requests.index', compact('raw_mat_reqs', 'status', 'class_names'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $item_list = RawMaterial::select('material_name')->groupBy('material_name')->get();

    return view('pages.raw_material_requests.create', compact('item_list'));
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
      'material_type' => 'required',
      'material_quantity' => 'required|numeric',
    ]);

    $mat_id = RawMaterial::where('material_name', $request->material_name)->where('material_type', $request->material_type)->select('id')->first();

    $new_req = new RawMaterialRequest();

    $new_req->raw_material_id = $mat_id->id;
    $new_req->raw_material_quantity = $request->material_quantity;
    $new_req->requested_by = Auth::user()->id;

    $new_req->save();

    // distribute confimation process
    $users = User::role($new_req->raw_material->req_handler_role)->get();
    foreach ($users as $user) {
      $raw_mat_req_conf = new RawMatReqConfirmation();

      $raw_mat_req_conf->raw_material_request_id = $new_req->id;
      $raw_mat_req_conf->user_id = $user->id;

      $raw_mat_req_conf->save();
    }

    flash()->addSuccess('Request Created');

    return back();
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\RawMaterialRequest  $rawMaterialRequest
   * @return \Illuminate\Http\Response
   */
  public function show(RawMaterialRequest $rawMaterialRequest)
  {
    $status = ['pending', 'confirmed', 'cancelled'];
    $class_names = ['warning', 'success', 'danger'];

    $raw_mat_req = $rawMaterialRequest;

    return view('pages.raw_material_requests.show', compact('raw_mat_req', 'status', 'class_names'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\RawMaterialRequest  $rawMaterialRequest
   * @return \Illuminate\Http\Response
   */
  public function destroy(RawMaterialRequest $rawMaterialRequest)
  {
    $rawMaterialRequest->delete();

    flash()->addSuccess('Request Deleted');

    return redirect(route('raw-material-requests.index'));
  }

  // get material item based on name
  public function get_item_types(Request $request)
  {
    $item_types = RawMaterial::where('material_name', $request->material_name)->select('material_type')->get();
    $unit = RawMaterial::where('material_name', $request->material_name)->select('quantity_unit')->first();
    return response()->json(['success' => true, 'types' => $item_types, 'unit' => $unit->quantity_unit]);
  }

  // work for queue list
  public function queue_list()
  {
    $user_id = Auth::user()->id;
    $status = ['pending', 'confirmed', 'cancelled'];

    $raw_mat_reqs = RawMatReqConfirmation::where('user_id', $user_id)->where('status', 0)->get();

    return view('pages.raw_material_requests.queue_list', compact('raw_mat_reqs', 'status'));
  }

  // request confirmation process
  public function confirmation(Request $request, $id)
  {
    $req_confirmation = RawMatReqConfirmation::findOrFail($id);
    $raw_request = RawMaterialRequest::findOrFail($req_confirmation->raw_material_request_id);

    $status = $request->status;

    // change status
    if ($status == 2) {
      DB::table('raw_mat_req_confirmations')->where('raw_material_request_id', $req_confirmation->raw_material_request_id)->update(['status' => $status, 'confirmed_at' => null]);

      // update request fields
      $raw_request->update([
        'cancelled_by' => Auth::user()->id,
        'updated_at' => now()
      ]);
      $raw_request->save();
    } else {
      $req_confirmation->update([
        'status' => $status,
        'confirmed_at' => now()
      ]);
      $req_confirmation->save();

      // update request fields
      $raw_request->update([
        'updated_at' => now()
      ]);
      $raw_request->save();
    }

    // check all request and update quantity
    $all_requests = RawMatReqConfirmation::where('raw_material_request_id', $req_confirmation->raw_material_request_id)->get();
    $confirmation = true;
    foreach ($all_requests as $req) {
      if ($req->status != 1) {
        $confirmation = false;
      }
    }
    if ($confirmation) {
      $material_id = $req_confirmation->request->raw_material_id;
      $material_quantity = $req_confirmation->request->raw_material_quantity;

      $raw_material = RawMaterial::findOrFail($material_id);
      $raw_material->material_quantity += $material_quantity;
      $raw_material->updated_at = now();
      $raw_material->save();

      flash()->addSuccess('Quantity Updated');
    }

    if ($status == 2) {
      flash()->addWarning('Request Cancelled');
    } else {
      flash()->addSuccess('Request Confirmed');
    }

    return back();
  }
}
