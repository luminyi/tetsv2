<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }

    public function givePermission(Permission $permission){
        return $this->permissions()->save($permission);
    }
//    roles->givepermission($permission)
}
