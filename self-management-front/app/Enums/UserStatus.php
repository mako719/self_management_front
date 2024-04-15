<?php

namespace App\Enums;

enum UserStatus: int
{
    case ProvisionalMember= 1;
    case RegularMember = 2;

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::ProvisionalMember => '仮会員',
            self::RegularMember => '本会員',
        };
    }
}
