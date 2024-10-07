<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Access extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'accessable_id', 'accessable_type', 'resourceable_id', 'resourceable_type'
    ];

    public function accessable(): MorphTo
    {
        return $this->morphTo();
    }

    public function resourceable(): MorphTo
    {
        return $this->morphTo();
    }
}
