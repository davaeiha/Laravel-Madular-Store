<?php

namespace Modules\Comment\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Comment\Entities\Comment as CommentModel;

class Comment
{
    use SerializesModels;

    /**
     * @var CommentModel
     */
    public $comment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CommentModel $comment)
    {
        $this->comment = $comment;
    }


}
