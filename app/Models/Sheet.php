<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperSheet
 */
class Sheet extends Model
{
    use HasFactory, HasUuids;

    protected $with = ['parts', 'user'];

    protected $fillable = [
        'title', 'description', 'artist', 'key', 'duration', 'tempo', 'time_signature',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class)->orderBy('position');
    }

    public function key(): HasOne
    {
        return $this->hasOne(Key::class);
    }

    protected static function boot()
    {
        parent::boot();
    }
}
