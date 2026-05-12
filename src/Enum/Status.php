<?php

namespace App\Enum;

enum Status: string
{
    case SCHEDULED = 'scheduled';
    case LIVE = 'live';
    case FINISHED = 'finished';

    public function getLabel(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Planifier',
            self::LIVE => 'Live',
            self::FINISHED => 'Terminer',
        };
    }
}