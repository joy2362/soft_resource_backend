<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_category extends Model
{
    protected $guarded = [];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sub_categories';

    use HasFactory;

    protected $with = ['created_by','updated_by','deleted_by','items'];

    /**
     *
     */
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
    /**
     *
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }


}
