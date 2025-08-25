<?php

namespace App\Models;

use Database\Factories\WorkspaceFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $image
 * @property-read int $episodesCount
 * @property-read int $usersCount
 * @property-read bool $isCurrent
 * @property-read User $user
 * @property-read Collection<int, Episode> $episodes
 */
class Workspace extends Model
{
    /** @use HasFactory<WorkspaceFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'user_id'
    ];

    /**
     * Attributes that should be appended to array/JSON form.
     *
     * @var list<string>
     */
    protected $appends = [
        'image',
        'episodesCount',
        'usersCount',
        'isCurrent'
    ];

    /**
     * Get test image based on the first character of the name.
     *
     * @return string
     */
    public function getImageAttribute(): string
    {
        $firstCharacter = strtolower($this->name[0]);
        $integerToUse = is_numeric($firstCharacter) ? ord($firstCharacter) - 21 : ord($firstCharacter) - 96;

        return "https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-".$integerToUse.".png";
    }

    /**
     * Get the total amount of episodes in the workspace.
     *
     * @return int
     */
    public function getEpisodesCountAttribute(): int
    {
        return $this->episodes()->count();
    }

    /**
     * Get the total amount of users in the workspace.
     *
     * @return int
     */
    public function getUsersCountAttribute(): int
    {
        return $this->user()->count();
    }

    /**
     * Checks whether the current session holds the workspace.
     *
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getIsCurrentAttribute(): bool
    {
        return session()->get('workspace_id') === $this->id;
    }

    /**
     * Workspace should have only 1 user.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Workspace can have many episodes.
     *
     * @return HasMany<Episode, $this>
     */
    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }
}
