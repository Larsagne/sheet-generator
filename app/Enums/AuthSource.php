<?php

namespace App\Enums;

enum AuthSource: string
{
    case LARAVEL = 'laravel';
    case GOOGLE = 'google';
}
