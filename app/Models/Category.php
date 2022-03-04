<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model
{
    use HasFactory;
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['NumberOfSubCategory','numberOfItems'];


    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    //protected $with = ['items'];

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


    public function sub_category()
    {
        return $this->hasMany(sub_category::class,'category_id','id');
    }

    public function getNumberOfSubCategoryAttribute()
    {
        return $this->sub_category()->count();
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function getnumberOfItemsAttribute()
    {
        return $this->items()->count();
    }


}
