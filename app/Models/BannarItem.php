<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannarItem extends Model
{
  protected $fillable = ['image', 'collection_id'];

 public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id'); // ← foreign key في جدول bannar_items
    }
}
