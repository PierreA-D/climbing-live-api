<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateCamera
{
    #[Assert\NotBlank]
    public string $id = '';

    #[Assert\NotBlank]
    public string $name = '';

    public ?string $location = null;

    public ?string $rtmpUrl = null;

    public ?string $hlsUrl = null;

    public bool $authorized = false;

    #[Assert\NotBlank]
    public string $competition = '';
}