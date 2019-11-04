<?php

namespace Corp\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Corp\Article;
use Corp\Permissio;
use Corp\Policies\ArticlePolicy;
use Corp\Policies\PermissionPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       Article::class => ArticlePolicy::class,
       Permission::class => PermissionPolicy::class,
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

        //
        $gate->define('view_admin', function($user) {
          return $user->canDo('view_admin');
        });
        $gate->define('view_admin_articles', function($user) {
          return $user->canDo('view_admin_articles');
        });

        $gate->define('edit_users', function($user) {
          return $user->canDo('edit_users', FALSE);
        });

    }
}
