<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Services\AddressService;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct(private AddressService $addressService) {}

    public function edit(Item $item)
    {
        $user = Auth::user();
        return view('purchase.address', compact('user', 'item'));
    }

    public function update(AddressRequest $request, Item $item)
    {
        $this->addressService->update(Auth::user(), $request->validated());

        return redirect('/purchase/' . $item->id);
    }
}
