<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Show extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name', 'description', 'date'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'band_member', 'band_id', 'member_id');
    }
}
