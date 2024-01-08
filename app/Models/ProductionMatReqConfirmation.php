<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMatReqConfirmation extends Model
{
  use HasFactory;

  protected $fillable = ['prod_mat_req_id', 'user_id', 'status', 'confirmed_at'];

  public $timestamps = false;

  public function request()
  {
    return $this->belongsTo(related: ProductionMaterialRequest::class, foreignKey: 'prod_mat_req_id');
  }

  public function user()
  {
    return $this->belongsTo(related: User::class, foreignKey: 'user_id');
  }
}
