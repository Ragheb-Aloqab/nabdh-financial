<?php

namespace App\Policies;

use App\Models\RoadmapStep;
use App\Models\User;

class RoadmapStepPolicy
{
    public function viewAny(User $user): bool { return $user->isContentManager(); }
    public function view(User $user, RoadmapStep $model): bool { return $user->isContentManager(); }
    public function create(User $user): bool { return $user->isContentManager(); }
    public function update(User $user, RoadmapStep $model): bool { return $user->isContentManager(); }
    public function delete(User $user, RoadmapStep $model): bool { return $user->isContentManager(); }
}
