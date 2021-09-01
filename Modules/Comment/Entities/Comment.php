<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\User\Entities\User;

/**
 * @method static where(string $string, int $int)
 * @property mixed approved
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "comments";

    /**
     * @var string[]
     */
    protected $fillable=[
        "user_id",
        "commentable_id",
        "commentable_type",
        "approved",
        "parent_id",
        "comment"
    ];

    /**
     * access the user of a comment
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * access the object that include comment
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * access to child comments of a comment
     *
     * @return HasMany
     */

    public function childComments(): HasMany
    {
        return $this->hasMany(Comment::class,"parent_id","id");
    }

    /**
     * show if a comment is approved
     * @return bool
     */
    public function isApproved(): bool
    {
        return !! $this->approved ==1 ;
    }

}
