<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConsultsCoordination extends Model
{
    protected $table='consults';

    public $timestamps = false;

    protected $fillable=[
        'consult_id','floor_id','comment_user_id',
        'content'
    ];
}