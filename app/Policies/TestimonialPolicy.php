<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\User;

class TestimonialPolicy
{
    public function viewAny(User $user): bool { return $user->isContentManager(); }
    public function view(User $user, Testimonial $model): bool { return $user->isContentManager(); }
    public function create(User $user): bool { return $user->isContentManager(); }
    public function update(User $user, Testimonial $model): bool { return $user->isContentManager(); }
    public function delete(User $user, Testimonial $model): bool { return $user->isContentManager(); }
}
