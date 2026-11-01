<?php

namespace App\Policies;

use App\Models\ContactSubmission;
use App\Models\User;

class ContactSubmissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isFormsManager();
    }

    public function view(User $user, ContactSubmission $submission): bool
    {
        return $user->isFormsManager();
    }

    public function create(User $user): bool
    {
        return false; // Submissions are created from public site
    }

    public function update(User $user, ContactSubmission $submission): bool
    {
        return $user->isFormsManager();
    }

    public function delete(User $user, ContactSubmission $submission): bool
    {
        return $user->isSuperAdmin();
    }
}
