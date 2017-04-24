<?php

namespace App\Providers;

use App\Model\Permission;
use App\Model\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        foreach($this->getPermissions() as $permission){
//            dd($permission->name);

//            $gate->define($permission->name, function(User $user) use ($permission){
////                dd('caonima');
//                return true;
//            });

            $gate->define($permission->name, function(User $user) use ($permission){
//                Log::write('info',$permission->roles);
                return $user->hasRole($permission->roles);
            });
        }
        //
    }

    protected function getPermissions(){
        return Permission::with('roles')->get();
        //把我们所有的permission拿到，把对应的role拿到permission当中，这里return 某个人的permission
    }
}
