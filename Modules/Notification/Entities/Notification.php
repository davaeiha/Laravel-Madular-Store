<?php

namespace Modules\Notification\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Notification\Database\factories\NotificationFactory;

/**
 * @method static create(array $array)
 * @method static paginate(int $int)
 * @method static where(string $string, string $string1)
 */
class Notification extends Model
{
    use HasFactory;

    protected $table='notifications';

    protected $fillable = [
        'title',
        'description'
    ];

    protected static function newFactory()
    {
        return NotificationFactory::new();
    }

    /**
     * access channels of a
     *
     * @return BelongsToMany
     */
    public function channels(): BelongsToMany
    {
        return $this->belongsToMany(Channel::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('channel_id');
    }
}
