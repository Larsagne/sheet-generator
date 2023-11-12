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
        'title', 'description', 'artist', 'key', 'duration', 'tempo', 'time_signature', 'parts'
    ];

    protected static function boot()
    {
        static::saving(function ($model) {
            self::setParts(is_array($model->parts) ? $model->parts : $model->parts->toArray(), $model);

            unset($model->parts);
        });

        parent::boot();
    }

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

    private static function setParts(array $parts, Sheet $sheet): void
    {
        $parts = self::sort($parts);

        $partIds = array_map(fn($part) => self::handlePart($part, $sheet), $parts);
        $oldParts = $sheet->parts()->whereNotIn('id', $partIds);
        Part::destroy($oldParts->pluck('id'));
    }

    private static function handlePart(array $part, Sheet $sheet): string
    {
        if (isset($part['id'])) {
            $partModel = Part::find($part['id']);
            $partModel->update($part);
        } else {
            $partModel = $sheet->parts()->create($part);
        }

        self::setSequences($part['sequences'], $partModel);

        return $partModel->id;
    }

    private static function setSequences(array $sequences, Part $part): void
    {
        $sequences = self::sort($sequences);

        $sequenceIds = array_map(fn($sequence) => self::handleSequence($sequence, $part), $sequences);
        $oldSequences = $part->sequences()->whereNotIn('id', $sequenceIds);
        Sequence::destroy($oldSequences->pluck('id'));
    }


    private static function handleSequence(array $sequence, Part $part): string
    {
        if (isset($sequence['id'])) {
            $sequenceModel = Sequence::find($sequence['id']);
            $sequenceModel->update($sequence);
        } else {
            $sequenceModel = $part->sequences()->create($sequence);
        }

        return $sequenceModel->id;
    }

    /**
     * This method is used to set the position attributes of parts and sequences
     */
    private static function sort(array $entities): array
    {
        $sortedEntities = [];
        foreach ($entities as $position => $entity) {
            $entity['position'] = $position;
            $sortedEntities[] = $entity;
        }

        return $sortedEntities;
    }
}
