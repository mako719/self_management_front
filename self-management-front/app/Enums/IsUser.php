<?php

namespace App\Enums;

enum IsUser: int
{
    case NonUser = 0;
    case User = 1;

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::NonUser => 'ユーザー以外',
            self::User => 'ユーザー本人',
        };
    }
}
