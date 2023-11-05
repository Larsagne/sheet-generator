<?php

namespace App\Models;

use App\Enums\Moods;
use App\Enums\RootNotes;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Key extends Model
{
    use Sushi;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @return array
     */
    public function getRows(): array
    {
        $keys = [];
        foreach (RootNotes::cases() as $rootNote) {
            foreach (Moods::cases() as $mood) {
                $keys[] = [
                    'id' => $rootNote->name . $mood->name,
                    'shortName' => $rootNote->getShortName() . $mood->getShortName()
                ];
            }
        }

        return $keys;
    }
}
