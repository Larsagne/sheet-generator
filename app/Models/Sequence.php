<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperSequence
 */
class Sequence extends Model
{
    use HasFactory, HasUuids;

    protected $casts = [
        'measures' => 'array',
    ];

    protected $fillable = [
        'position', 'quantity', 'description', 'measures',
    ];

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}
