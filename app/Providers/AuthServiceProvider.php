<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Department' => 'App\Policies\DepartmentPolicy',
		'App\Models\ParentDepartment' => 'App\Policies\ParentDepartmentPolicy',
        'App\Models\Counter' => 'App\Policies\CounterPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Setting' => 'App\Policies\SettingsPolicy',
        'App\Models\Call' => 'App\Policies\CallPolicy',
        'App\Models\DisplaySetting' => 'App\Policies\DisplaySettingPolicy',
        'App\Models\QueueSetting' => 'App\Policies\QueueSettingPolicy',
        'App\Models\Limit' => 'App\Policies\LimitPolicy',
        'App\Models\Ad' => 'App\Policies\AdPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
