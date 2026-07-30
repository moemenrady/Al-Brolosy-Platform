<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
  protected $fillable = ['name'];

  public function bannarItem()
  {
    return $this->hasOne(BannarItem::class);
  }
  public function products()
  {
    return $this->hasMany(Product::class);
  }
}
