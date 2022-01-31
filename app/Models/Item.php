<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Item extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $appends = ['image'];
    protected $with =['download','created_by','updated_by','deleted_by'];
    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function getimageAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }

    public function download()
    {
        return $this->hasMany(DownloadLink::class);
    }

    public function gettotalLinkAttribute()
    {
        return $this->download()->count();
    }
    /**
     *
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function deleted_by()
    {
        return $this->belongsTo(User::class,'deleted_by');
    }
}
