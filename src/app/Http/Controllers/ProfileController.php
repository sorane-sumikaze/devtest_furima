<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService) {}

    public function edit()
    {
        $user = Auth::user();

        return view('mypage.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $this->profileService->update(Auth::user(), $request->validated());

        return redirect('/mypage');
    }
}
