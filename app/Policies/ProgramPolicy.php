<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;

class ProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isContentManager();
    }

    public function view(User $user, Program $program): bool
    {
        return $user->isContentManager();
    }

    public function create(User $user): bool
    {
        return $user->isContentManager();
    }

    public function update(User $user, Program $program): bool
    {
        return $user->isContentManager();
    }

    public function delete(User $user, Program $program): bool
    {
        return $user->isContentManager();
    }
}
