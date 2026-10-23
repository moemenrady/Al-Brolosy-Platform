<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = [
    'sector_id',

    'name_ar',
    'name_en',

    'logo',

    'copyright_sentence_ar',
    'copyright_sentence_en',

    'description_ar',
    'description_en',

    'location_ar',
    'location_en',

    'latitude',
    'longitude',

    'image',
    'hover_image',

    'price_budget',

    'status',
    'sort_order',
    'featured',
    'is_active',

    'delivery_time',
    'booking_phone',
  ];

  protected $casts = [
    'latitude' => 'float',
    'longitude' => 'float',
    'featured' => 'boolean',
    'is_active' => 'boolean',
  ];

  public function getEffectiveBookingPhoneAttribute()
  {
      return !empty($this->booking_phone)
          ? $this->booking_phone
          : \App\Models\PlatformSetting::get('booking_whatsapp_number', '201032550422');
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

  public function getHoverImageUrlAttribute(): string
  {
      if (!$this->hover_image) return $this->image_url;
      if (str_starts_with($this->hover_image, 'http://') || str_starts_with($this->hover_image, 'https://')) {
          return $this->hover_image;
      }
      if (file_exists(public_path('storage/' . $this->hover_image))) {
          return asset('storage/' . $this->hover_image);
      }
      if (file_exists(public_path('images/projects/' . $this->hover_image))) {
          return asset('images/projects/' . $this->hover_image);
      }
      if (file_exists(public_path($this->hover_image))) {
          return asset($this->hover_image);
      }
      return asset('images/projects/' . $this->hover_image);
  }

  public function getLogoUrlAttribute(): ?string
  {
      if (!$this->logo) return null;
      if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
          return $this->logo;
      }
      if (file_exists(public_path('storage/' . $this->logo))) {
          return asset('storage/' . $this->logo);
      }
      if (file_exists(public_path('images/projects_logo/' . $this->logo))) {
          return asset('images/projects_logo/' . $this->logo);
      }
      if (file_exists(public_path($this->logo))) {
          return asset($this->logo);
      }
      return asset('storage/' . $this->logo);
  }

  /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

  public function images()
  {
    return $this->hasMany(ProjectImage::class);
  }

  public function sector()
  {
    return $this->belongsTo(Sector::class);
  }

  public function unitTypes()
  {
    return $this->hasMany(ProjectUnitType::class);
  }

  public function actualUnits()
  {
    return $this->hasMany(ProjectUnit::class);
  }

  public function units()
  {
    return $this->hasMany(ProjectUnit::class);
  }

  public function getUnitsAttribute()
  {
    return $this->relationLoaded('unitTypes')
      ? $this->getRelation('unitTypes')
      : $this->unitTypes()->get();
  }

  public function paymentPlan()
  {
    return $this->hasOne(ProjectPaymentPlan::class);
  }

  public function paymentPlans()
  {
    return $this->hasMany(ProjectPaymentPlan::class);
  }

  public function features()
  {
    return $this->hasMany(ProjectFeature::class);
  }
  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  /*
    |--------------------------------------------------------------------------
    | ACCESSORS (MULTI LANGUAGE)
    |--------------------------------------------------------------------------
    */

  public function getNameAttribute()
  {
    return app()->getLocale() == 'ar'
      ? $this->name_ar
      : $this->name_en;
  }

  public function getDescriptionAttribute()
  {
    return app()->getLocale() == 'ar'
      ? $this->description_ar
      : $this->description_en;
  }

  public function getLocationAttribute()
  {
    return app()->getLocale() == 'ar'
      ? $this->location_ar
      : $this->location_en;
  }

  public function getCopyrightSentenceAttribute()
  {
    return app()->getLocale() == 'ar'
      ? $this->copyright_sentence_ar
      : $this->copyright_sentence_en;
  }
}
