<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConsultsUser extends Model
{
    protected $table='consult_user';

    public $timestamps = false;

    protected $fillable=[
        'user_id','consults_type_id','submit_time',
        'term','state','meta_description','phone'
    ];
}
