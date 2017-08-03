<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'name','teacher','start_time','end_time',
        'place','state','information','all_num',
        'attend_num','remainder_num','term'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }
}
