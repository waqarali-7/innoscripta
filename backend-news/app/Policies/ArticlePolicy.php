<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{

    /**
     * Determine if the given article can be deleted by the user.
     */
    public function delete(User $user, Article $article): bool
    {
        // Allow only admins to delete
        return $user->is_admin;
    }

    /**
     * Determine if the user can update the given article.
     */
    public function update(User $user, Article $article): bool
    {
        // Allow only admins to update
        return $user->is_admin;
    }
}
