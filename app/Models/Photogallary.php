<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Photogallary extends Model
{
    protected $table = 'photogallary';

    protected  $primaryKey = 'id';

    protected $fillable = ['user_id','title','status','image'];

    public static function boot() {
        parent::boot();
    }

    
}
