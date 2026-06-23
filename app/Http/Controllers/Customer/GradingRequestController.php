<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\GradingRequest;
use App\Models\PokemonCard;
use App\Models\GradingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GradingRequestController extends Controller
{
    public function index()
    {
        $requests = GradingRequest::with(['pokemonCard', 'package'])
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();
            
        return view('customer.grading.history', compact('requests'));
    }

    public function create()
    {
        $cards = PokemonCard::where('user_id', Auth::id())
            ->where('status', 'Raw_Pending')
            ->get();
            
        $packages = GradingPackage::all();
        
        return view('customer.grading.create', compact('cards', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:pokemon_cards,id',
            'package_id' => 'required|exists:grading_packages,id',
            'pickup_address' => 'required|string|max:500',
            'return_address' => 'required|string|max:500',
        ]);

        $card = PokemonCard::where('id', $request->card_id)
            ->where('user_id', Auth::id())
            ->where('status', 'Raw_Pending')
            ->firstOrFail();

        $package = GradingPackage::findOrFail($request->package_id);

        // Buat nomor tiket
        $ticketNumber = 'REQ-' . strtoupper(Str::random(8));

        GradingRequest::create([
            'ticket_number' => $ticketNumber,
            'customer_id' => Auth::id(),
            'card_id' => $card->id,
            'package_id' => $package->id,
            'pickup_address' => $request->pickup_address,
            'return_address' => $request->return_address,
            'total_fee' => $package->price,
            'logistics_status' => 'Waiting_For_Pickup',
        ]);

        $card->update(['status' => 'In_Grading']);

        return redirect()->route('customer.grading.history')->with('success', "Permintaan grading {$ticketNumber} berhasil dibuat! Tim White-Glove kami akan segera meluncur.");
    }
}