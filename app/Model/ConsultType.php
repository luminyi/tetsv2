<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConsultType extends Model
{
    protected $table = 'consults_type';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
