<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $appends = ['AppLogo'];

    /**
     * Register the media collections
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('app_logo')->singleFile();
    }

    public function getAppLogoAttribute()
    {
        return $this->getFirstMediaUrl('app_logo');
    }
}
