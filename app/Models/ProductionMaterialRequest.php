<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterialRequest extends Model
{
  use HasFactory;

  protected $fillable = ['production_material_id', 'production_material_quantity', 'requested_by', 'cancelled_by'];

  public function production_material()
  {
    return $this->belongsTo(related: ProductionMaterial::class, foreignKey: 'production_material_id');
  }

  public function requested_user()
  {
    return $this->belongsTo(related: User::class, foreignKey: 'requested_by');
  }

  public function cancelled_user()
  {
    return $this->belongsTo(related: User::class, foreignKey: 'cancelled_by');
  }

  public function req_confirmations()
  {
    return $this->hasMany(related: ProductionMatReqConfirmation::class, foreignKey: 'prod_mat_req_id');
  }
}
