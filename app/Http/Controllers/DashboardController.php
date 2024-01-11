<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionMaterial;
use App\Models\RawMaterial;
use App\Models\User;

class DashboardController extends Controller
{
  public function index()
  {
    // Calculate the sum of 'material_quantity'
    $totalMaterialQuantity = ProductionMaterial::sum('material_quantity');
    $totalRawMaterialQuantity = RawMaterial::sum('material_quantity');
    $totalUsers = User::count();

    // Pass the total to the 'dashboard' view
    return view('dashboard', ['totalMaterialQuantity' => $totalMaterialQuantity,'totalRawMaterialQuantity' => $totalRawMaterialQuantity, 'totalUsers' => $totalUsers]);
  }
}