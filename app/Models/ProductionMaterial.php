<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['material_name', 'raw_material_id', 'pac_size', 'material_quantity', 'req_handler_role'];

    public function requests()
    {
        return $this->hasMany(related: ProductionMaterialRequest::class, foreignKey: 'production_material_id');
    }

    public function productions()
    {
        return $this->hasMany(related: ProductionMaterial::class, foreignKey: 'raw_material_id');
    }

    public function raw_material()
    {
        return $this->belongsTo(related: RawMaterial::class, foreignKey: 'raw_material_id');
    }
}
