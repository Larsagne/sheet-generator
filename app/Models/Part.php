<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperPart
 */
class Part extends Model
{
    use HasFactory, HasUuids;

    protected $with = ['sequences'];

    protected $fillable = [
        'name', 'position', 'description', 'lyrics',
    ];

    public function sheet(): BelongsTo
    {
        return $this->belongsTo(Sheet::class);
    }

    public function sequences(): HasMany
    {
        return $this->hasMany(Sequence::class)->orderBy('position');
    }
}
