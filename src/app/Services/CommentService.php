<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    public function store(int $itemId, int $userId, string $comment): void
    {
        Comment::create([
            'item_id' => $itemId,
            'user_id' => $userId,
            'comment' => $comment,
        ]);
    }
}
