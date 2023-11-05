<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;

    // protected $table = 'models';

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'model_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
