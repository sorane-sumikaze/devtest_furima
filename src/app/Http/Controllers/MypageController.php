<?php

namespace App\Http\Controllers;

use App\Services\MypageService;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function __construct(private MypageService $mypageService) {}

    public function index()
    {
        $user = Auth::user();
        $tab  = request()->query('tab', 'sell');

        if ($tab === 'buy') {
            $items = $this->mypageService->getPurchasedItems($user);
        } else {
            $tab   = 'sell';
            $items = $this->mypageService->getSoldItems($user);
        }

        return view('mypage.index', compact('user', 'items', 'tab'));
    }
}
