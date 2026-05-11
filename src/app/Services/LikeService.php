<?php

namespace App\Services;

use App\Models\Like;
use Illuminate\Database\QueryException;

class LikeService
{
    public function toggle(int $itemId, int $userId): void
    {
        $like = Like::where('item_id', $itemId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            try {
                Like::create([
                    'item_id' => $itemId,
                    'user_id' => $userId,
                ]);
            } catch (QueryException $e) {
                // UNIQUE制約違反（連打による重複）は無視する
            }
        }
    }
}
