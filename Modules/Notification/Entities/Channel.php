<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Notification\Database\factories\ChannelFactory;

/**
 * @method static create(array $array)
 * @method static paginate(int $int)
 * @method static where(string $string, string $string1)
 */
class Channel extends Model
{
    use HasFactory;

    protected $table='channels';

    protected $fillable = [
        'title',
        'description'
    ];

    protected static function newFactory()
    {
        return ChannelFactory::new();
    }

    /**
     * access notifications of a channel
     *
     * @return BelongsToMany
     */
    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class);
    }
}
