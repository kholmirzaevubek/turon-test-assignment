<?php

namespace App\Models\Traits;

use App\Enums\RoleEnums;

trait HasRole
{
    public function isAdmin(): bool
    {
        return $this->role_id === RoleEnums::ADMIN->value;
    }

    public function isUser(): bool
    {
        return $this->role_id === RoleEnums::USER->value;
    }
}
