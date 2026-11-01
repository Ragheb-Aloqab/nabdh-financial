<?php

namespace App\Policies;

use App\Models\PageSection;
use App\Models\User;

class PageSectionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isContentManager();
    }

    public function view(User $user, PageSection $section): bool
    {
        return $user->isContentManager();
    }

    public function create(User $user): bool
    {
        return $user->isContentManager();
    }

    public function update(User $user, PageSection $section): bool
    {
        return $user->isContentManager();
    }

    public function delete(User $user, PageSection $section): bool
    {
        return $user->isSuperAdmin();
    }
}
