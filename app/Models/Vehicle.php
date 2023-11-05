<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
  use HasFactory;
  use BelongsToThrough;
  // use Filterable;

  // https://github.com/staudenmeir/belongs-to-through
  public function brand()
  {
    // return $this->belongsTo(Brand::class);
    return $this->belongsToThrough(Brand::class, Models::class);
  }

  public function type()
  {
    // return $this->belongsTo(VehicleType::class, 'vehicle_type_id', 'id');
    return $this->belongsToThrough(VehicleType::class, Models::class);
  }

  public function model()
  {
    return $this->belongsTo(Models::class);
  }

  public function images()
  {
    return $this->hasMany(VehicleImg::class, 'vehicle_id', 'id');
  }

  public function comments()
  {
    return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('created_at', 'DESC');
  }
}
