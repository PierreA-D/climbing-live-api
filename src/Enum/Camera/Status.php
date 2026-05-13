<?php

namespace App\Enum\Camera;

enum Status: string
{
    case ONLINE = 'online';
    case OFFLINE = 'offline';

    public function getLabel(): string
    {
        return match ($this) {
            self::ONLINE => 'Online',
            self::OFFLINE => 'Offline',
        };
    }
}