<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $table = 'visitor_counts';
    use HasFactory;
    public $attributes = [ 'hits' => 0 ];

    protected $fillable = [ 'visitor', 'visit_date','visit_time' ];

    public static function hit() {
        return self::firstOrCreate([
            'visitor'   => $_SERVER['REMOTE_ADDR'],
            'visit_date' => date('Y-m-d'),
        ])->save();
    }

    public static function boot() {
        parent::boot();
        static::saving( function ($tracker) {
            //$tracker->visit_date = date('Y-m-d');
            $tracker->visit_time = date('H:i:s');
            $tracker->hits++;
        } );
    }

    public static function totalVisitor() {
        return self::distinct('visitor')->count('visitor');
    }

    public static function totalHits() {
        return self::sum('hits');
    }

    public static function totalRecentVisit($num) {
        return self::limit($num)->orderBy('id','desc')->get();
    }




}
