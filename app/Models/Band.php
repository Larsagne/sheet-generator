<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Band extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name', 'image', 'mode'
    ];

    protected $appends = [
        'member_count'
    ];


    protected static function boot()
    {
        // the founder is automatically stored as a member of the band
        static::created(function (Band $band) {
            $band->members()->attach($band->founder->id);
        });

        parent::boot();
    }

    public function founder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'founder_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'band_member', 'band_id', 'member_id');
    }

    protected function memberCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->members()->count(),
        );
    }

    public function invitations()
    {
        return $this->morphMany(Invitation::class, 'invitable');
    }
}
