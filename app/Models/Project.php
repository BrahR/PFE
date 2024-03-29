<?php

namespace App\Models;

use Eloquent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $timeline
 * @property int $budget
 * @property int $resource_allocation
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereBudget($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDescription($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project whereRecourceAllocation($value)
 * @method static Builder|Project whereTimeline($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereUserId($value)
 * @property-read Collection<int, Phase> $phase
 * @property-read int|null $phase_count
 * @property-read User $user
 * @method static Builder|Project whereResourceAllocation($value)
 * @property string|null $color
 * @property-read Collection<int, Phase> $phases
 * @property-read int|null $phases_count
 * @method static Builder|Project whereColor($value)
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @mixin Eloquent
 */

class Project extends Model
{
  use HasFactory, BroadcastsEvents;

  protected $fillable = [
    "name",
    "description",
    "timeline",
    "budget",
    "color",
    "resource_allocation"
  ];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function phases(): HasMany {
    return $this->hasMany(Phase::class);
  }

  public function tasks(): HasManyThrough {
    return $this->hasManyThrough(Task::class, Phase::class);
  }

  public function broadcastOn(string $event): Channel | PrivateChannel {
    return match ($event) {
      'created' => new Channel('public.projects'),
      default => new PrivateChannel("private.project.{$this->id}"),
    };
  }

  public function broadcastWith(string $event): array {
    return [
      'model' => [
        'id' => $this->id,
        'name' => $this->name,
        'description' => $this->description,
        'timeline' => $this->timeline,
        'budget' => $this->budget,
        'color' => $this->color,
        'resource_allocation' => $this->resource_allocation,
        'phases' => [],
      ],
      'projectId' => $this->id
    ];
  }
}
