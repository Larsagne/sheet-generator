<?php declare(strict_types=1);

namespace App\Enums;

enum RootNotes
{
    case C;

    case CSharp;
    case DFlat;

    case D;

    case DSharp;
    case EFlat;

    case E;

    case F;

    case FSharp;
    case GFlat;

    case G;

    case GSharp;
    case AFlat;

    case A;

    case ASharp;
    case BSharp;

    case B;


    /**
     * @return string
     */
    public function getShortName(): string
    {
        $name = $this->name;
        return str_replace(['Sharp', 'Flat'], ['#', 'b'], $name);
    }
}
