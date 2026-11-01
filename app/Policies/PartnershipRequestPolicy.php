<?php

namespace App\Policies;

use App\Models\PartnershipRequest;
use App\Models\User;

class PartnershipRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isFormsManager();
    }

    public function view(User $user, PartnershipRequest $request): bool
    {
        return $user->isFormsManager();
    }

    public function create(User $user): bool
    {
        return false; // Requests come from public site
    }

    public function update(User $user, PartnershipRequest $request): bool
    {
        return $user->isFormsManager();
    }

    public function delete(User $user, PartnershipRequest $request): bool
    {
        return $user->isSuperAdmin();
    }
}
