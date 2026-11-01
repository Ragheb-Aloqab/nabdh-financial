<?php

namespace App\Policies;

use App\Models\TeamMember;
use App\Models\User;

class TeamMemberPolicy
{
    public function viewAny(User $user): bool { return $user->isContentManager(); }
    public function view(User $user, TeamMember $model): bool { return $user->isContentManager(); }
    public function create(User $user): bool { return $user->isContentManager(); }
    public function update(User $user, TeamMember $model): bool { return $user->isContentManager(); }
    public function delete(User $user, TeamMember $model): bool { return $user->isContentManager(); }
}
