<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\User\Entities\User;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";

    protected $fillable=[
        "user_id",
        "commentable_id",
        "commentable_type",
        "approved",
        "parent_id",
        "comment"
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function childComments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class,"parent_id","id");
    }

//    public function childComments($comment){
//         return Comment::where('parent_id',$comment->id)->get();
//    }
}
