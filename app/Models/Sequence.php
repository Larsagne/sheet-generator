<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sequence extends Model
{
    use HasFactory;

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
