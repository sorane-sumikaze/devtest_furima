<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Services\SellService;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function __construct(private SellService $sellService) {}

    public function create()
    {
        $categories = Category::all();
        return view('sell.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $this->sellService->store(Auth::user(), $request->validated());

        return redirect('/');
    }
}
