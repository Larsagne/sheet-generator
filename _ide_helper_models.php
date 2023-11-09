<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Key
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Key newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Key newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Key query()
 * @mixin \Eloquent
 */
	class IdeHelperKey {}
}

namespace App\Models{
/**
 * App\Models\Part
 *
 * @property string $id
 * @property string $sheet_id
 * @property string $name
 * @property int $position
 * @property string|null $description
 * @property string|null $lyrics
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sequence> $sequences
 * @property-read int|null $sequences_count
 * @property-read \App\Models\Sheet|null $sheet
 * @method static \Illuminate\Database\Eloquent\Builder|Part newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Part newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Part query()
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereLyrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereSheetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperPart {}
}

namespace App\Models{
/**
 * App\Models\Sequence
 *
 * @property string $id
 * @property string $part_id
 * @property int $position
 * @property int $quantity
 * @property string|null $description
 * @property array $measures
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Part|null $part
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereMeasures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence wherePartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sequence whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperSequence {}
}

namespace App\Models{
/**
 * App\Models\Sheet
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $title
 * @property string|null $description
 * @property string $artist
 * @property int|null $duration
 * @property int|null $tempo
 * @property string $time_signature
 * @property \App\Models\Key|null $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Part> $parts
 * @property-read int|null $parts_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\SheetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereTempo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereTimeSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sheet whereUserId($value)
 * @mixin \Eloquent
 */
	class IdeHelperSheet {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sheet> $sheets
 * @property-read int|null $sheets_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

