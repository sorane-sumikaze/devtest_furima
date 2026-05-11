<?php

namespace App\Services;

use App\Models\User;

class AddressService
{
    public function update(User $user, array $data): void
    {
        $user->post_code = $data['post_code'];
        $user->address   = $data['address'];
        $user->building  = $data['building'] ?? null;
        $user->save();
    }
}
