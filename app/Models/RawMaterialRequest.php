<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialRequest extends Model
{
    use HasFactory;

    protected $fillable = ['raw_material_id', 'raw_material_quantity', 'requested_by', 'cancelled_by'];

    public function raw_material()
    {
        return $this->belongsTo(related: RawMaterial::class, foreignKey: 'raw_material_id');
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
        return $this->hasMany(related: RawMatReqConfirmation::class, foreignKey: 'raw_material_request_id');
    }
}
