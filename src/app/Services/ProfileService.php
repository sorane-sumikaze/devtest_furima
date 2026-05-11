<?php

namespace App\Services;

use App\Models\User;

class ProfileService
{
    public function update(User $user, array $data): void
    {
        if (isset($data['profile_image'])) {
            $path = $data['profile_image']->store('users', 'public');
            $user->profile_image = $path;
        }

        $user->user_name = $data['user_name'];
        $user->post_code = $data['post_code'];
        $user->address   = $data['address'];
        $user->building  = $data['building'] ?? null;
        $user->save();
    }
}
