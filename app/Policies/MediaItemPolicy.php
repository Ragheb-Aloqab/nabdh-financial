<?php

namespace App\Policies;

use App\Models\MediaItem;
use App\Models\User;

class MediaItemPolicy
{
    public function viewAny(User $user): bool { return $user->isContentManager(); }
    public function view(User $user, MediaItem $model): bool { return $user->isContentManager(); }
    public function create(User $user): bool { return $user->isContentManager(); }
    public function update(User $user, MediaItem $model): bool { return $user->isContentManager(); }
    public function delete(User $user, MediaItem $model): bool { return $user->isContentManager(); }
}
