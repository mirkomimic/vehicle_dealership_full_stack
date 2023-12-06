<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
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

  public function scopeFilter(Builder $query, array $filters)
  {
    $query->when(
      $filters['brand'] ?? false,
      function ($query, $value) {
        return $query->whereHas('brand', function ($q) use ($value) {
          return $q->where('brand_id', $value);
        });
      }
    )->when(
      $filters['model'] ?? false,
      function ($query, $value) {
        return $query->whereHas('model', function ($q) use ($value) {
          return $q->where('model_id', $value);
        });
      }
    )->when(
      $filters['minYear'] ?? false,
      function ($query, $value) {
        return $query->where('year', '>=', $value);
      }
    )->when(
      $filters['maxYear'] ?? false,
      function ($query, $value) {
        return $query->where('year', '<=', $value);
      }
    )->when(
      $filters['search'] ?? false,
      function ($query, $value) {
        return $query->whereHas('model', function ($q) use ($value) {
          return $q->where('name', 'like', "%" . $value . "%");
        });
      }
    )->when(
      $filters['sort'] ?? false,
      function ($query, $value) {
        if ($value == 'priceAsc') {
          return $query->orderBy('price', 'asc');
        } else if ($value == 'priceDesc') {
          return $query->orderBy('price', 'desc');
        } else if ($value == 'createdAsc') {
          return $query->orderBy('created_at', 'asc');
        } else if ($value == 'createdDesc') {
          return $query->orderBy('created_at', 'desc');
        } else {
          return $query->orderBy('created_at', 'desc');
        }
      }
    );
  }
}
