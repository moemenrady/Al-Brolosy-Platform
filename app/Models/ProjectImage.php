<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
  protected $fillable = [
    'project_id',
    'image',
  ];

  public function project()
  {
    return $this->belongsTo(Project::class);
  }

  public function getImageUrlAttribute(): string
  {
      if (!$this->image) return asset('albrolosy_logo.png');
      if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
          return $this->image;
      }
      if (file_exists(public_path('storage/' . $this->image))) {
          return asset('storage/' . $this->image);
      }
      if (file_exists(public_path('images/projects/' . $this->image))) {
          return asset('images/projects/' . $this->image);
      }
      if (file_exists(public_path($this->image))) {
          return asset($this->image);
      }
      return asset('images/projects/' . $this->image);
  }
}
