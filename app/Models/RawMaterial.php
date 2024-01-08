<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['material_name', 'material_type', 'material_quantity', 'quantity_unit', 'req_handler_role'];

    public function requests()
    {
        return $this->hasMany(related: RawMaterialRequest::class, foreignKey: 'raw_material_id');
    }
}
