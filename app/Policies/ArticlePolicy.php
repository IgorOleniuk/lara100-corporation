<?php

namespace Corp\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Corp\User;
class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(User $user)
    {
      return $user->canDo('add_articles');
    }

    public function edit(User $user)
    {
      return $user->canDo('update_articles');
    }
}
