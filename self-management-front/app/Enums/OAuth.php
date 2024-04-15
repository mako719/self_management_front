<?php

namespace App\Enums;

enum OAuth: int
{
    case AppAuth= 1;
    case Google = 2;

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::AppAuth => '通常会員',
            self::Google => 'Google',
        };
    }
}
