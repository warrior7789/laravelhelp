<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Ads extends Model
{
    protected $table = 'ads';

    protected  $primaryKey = 'id';

    protected $fillable = ['pagename','title','link','image','description'];

    public static function boot() {
        parent::boot();
    }
}
