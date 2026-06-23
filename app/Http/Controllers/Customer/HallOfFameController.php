<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PokemonCard;
use Illuminate\Support\Facades\Auth;

class HallOfFameController extends Controller
{
    public function index()
    {
        $showcase = PokemonCard::with('cardSet')
            ->where('user_id', Auth::id())
            ->whereNotNull('hall_of_fame_slot')
            ->orderBy('hall_of_fame_slot', 'asc')
            ->get();

        return view('customer.collection.halloffame', compact('showcase'));
    }
}