<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService) {}

    public function store(CommentRequest $request, Item $item)
    {
        $this->commentService->store($item->id, Auth::id(), $request->comment);

        return redirect()->back();
    }
}
