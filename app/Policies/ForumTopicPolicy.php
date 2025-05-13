<?php

namespace App\Policies;

use App\Models\ForumTopic;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumTopicPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ForumTopic $forumTopic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForumTopic $forumTopic): bool
    {
        return $user->id === $forumTopic->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumTopic $forumTopic): bool
    {
        return $user->hasRole('admin'); // Only admins can delete topics
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ForumTopic $forumTopic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ForumTopic $forumTopic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can pin the model.
     */
    public function pin(User $user, ForumTopic $forumTopic): bool
    {
        return $user->hasRole('admin');
    }
}
