<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Conversation extends Model
{
    protected $table = 'conversation';

    protected  $primaryKey = 'id';

    protected $fillable = ['name','user_one','status','user_two'];

    public static function boot()
    {
        parent::boot();

        
    }

    
}
