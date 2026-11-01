<?php

namespace App\Policies;

use App\Models\Pillar;
use App\Models\User;

class PillarPolicy
{
    public function viewAny(User $user): bool { return $user->isContentManager(); }
    public function view(User $user, Pillar $model): bool { return $user->isContentManager(); }
    public function create(User $user): bool { return $user->isContentManager(); }
    public function update(User $user, Pillar $model): bool { return $user->isContentManager(); }
    public function delete(User $user, Pillar $model): bool { return $user->isContentManager(); }
}
