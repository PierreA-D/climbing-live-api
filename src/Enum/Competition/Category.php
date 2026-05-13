<?php

namespace App\Enum\Competition;

enum Category: string
{
    case BLOCK = 'block';
    case SPEED = 'speed';
    case DIFFICULTY = 'difficulty';
    case TEAM = 'team';

    public function getLabel(): string
    {
        return match ($this) {
            self::BLOCK => 'Bloc',
            self::SPEED => 'Vitesse',
            self::DIFFICULTY => 'Difficulté',
            self::TEAM => 'Équipe',
        };
    }
}