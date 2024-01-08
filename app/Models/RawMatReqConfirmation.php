<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMatReqConfirmation extends Model
{
    use HasFactory;

    protected $fillable = ['raw_material_request_id', 'user_id', 'status', 'confirmed_at'];

    public $timestamps = false;

    public function request()
    {
        return $this->belongsTo(related: RawMaterialRequest::class, foreignKey: 'raw_material_request_id');
    }


    public function user()
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }
}
