<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class activities_user extends Model
{
    protected $table='activities_user';

//    protected $primaryKey=[
//        'user_id','activities_id'
//    ];

    public $timestamps = false;

    protected $fillable = [
        'user_id','activities_id','state'
    ];
}
