<?php

namespace App\Policies;

use App\Models\Achievement;
use App\Models\User;

class AchievementPolicy
{
    public function viewAny(User $user): bool { return $user->isContentManager(); }
    public function view(User $user, Achievement $model): bool { return $user->isContentManager(); }
    public function create(User $user): bool { return $user->isContentManager(); }
    public function update(User $user, Achievement $model): bool { return $user->isContentManager(); }
    public function delete(User $user, Achievement $model): bool { return $user->isContentManager(); }
}
