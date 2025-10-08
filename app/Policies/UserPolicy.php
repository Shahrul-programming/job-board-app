<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can access admin features
     */
    public function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can manage jobs
     */
    public function manageJobs(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can manage applications
     */
    public function manageApplications(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view job applications
     */
    public function viewApplications(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can create jobs
     */
    public function createJobs(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can edit jobs
     */
    public function editJobs(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can delete jobs
     */
    public function deleteJobs(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can apply for jobs
     */
    public function applyForJobs(User $user): bool
    {
        return true; // Both admin and guest can apply for jobs
    }

    /**
     * Determine if the user can view jobs
     */
    public function viewJobs(User $user): bool
    {
        return true; // Both admin and guest can view jobs
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role === 'admin' && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->role === 'admin' && $user->id !== $model->id;
    }
}
