<?php

namespace App\Providers;

use App\Http\Middleware\Authenticate;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Passport::tokensCan([
            'user' => 'user type',
            'patient' => 'patient type',
            'doctor' => 'doctor type',
        ]);




//        Gate::define('aya',function (User $user){
//              $role= $user->with('user_role');
//              foreach ($role as $roles){
//             if($roles->user_role->role_id==1){
//
//                 return true;
//             }}
//              return false;
//           });
//
        $permission=Permission::select('Title')->get();

        foreach ( $permission as $ability)
        {
                  $permission=$ability->Title;
            Gate::define($permission,function ($auth)use($permission){
                return $auth->hasability($permission);
            });
        }


    }
}
