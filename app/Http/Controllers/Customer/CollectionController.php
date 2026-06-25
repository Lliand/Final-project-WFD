<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\PokemonCard;
use App\Models\CardSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterType = $request->input('filterType');
        $filterElement = $request->input('filterElement');
        $filterSet = $request->input('filterSet'); 
        $sortBy = $request->input('sortBy', 'created_at');
        $sortMode = $request->input('sortMode', 'desc');

        $query = PokemonCard::with('cardSet')->where('user_id', Auth::id());

        if ($search) $query->where('card_name', 'like', "%{$search}%");
        if ($filterType) $query->where('card_type', $filterType);
        if ($filterElement) $query->where('element_type', $filterElement);
        if ($filterSet) $query->where('set_id', $filterSet);

        $sortColumn = $sortBy == 'date_obtained' ? 'created_at' : ($sortBy == 'price' ? 'id' : 'grade');
        $data = $query->orderBy($sortColumn, $sortMode)->get();

        $availableSets = CardSet::all();

        return view('customer.collection.index', compact('data', 'search', 'filterType', 'filterElement', 'filterSet', 'availableSets', 'sortBy', 'sortMode'));
    }

    public function create()
    {
        $cardSets = CardSet::all();
        return view('customer.collection.create', compact('cardSets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_name' => 'required|string',
            'set_id' => 'required|exists:card_sets,id',
            'card_type' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hall_of_fame_slot' => 'nullable|integer|min:1|max:5',
        ]);

        $imagePath = $request->file('image')->store('cards', 'public');
        $targetSlot = $request->hall_of_fame_slot;

        DB::transaction(function () use ($request, $imagePath, $targetSlot) {
            
            if (!is_null($targetSlot)) {
                $existingCard = PokemonCard::where('user_id', Auth::id())
                    ->where('hall_of_fame_slot', $targetSlot)
                    ->first();

                if ($existingCard) {
                    $existingCard->update([
                        'hall_of_fame_slot' => null
                    ]);
                }
            }

            PokemonCard::create([
                'user_id' => Auth::id(),
                'set_id' => $request->set_id,
                'card_name' => $request->card_name,
                'card_type' => $request->card_type,
                'element_type' => $request->element_type,
                'raw_image_url' => $imagePath,
                'hall_of_fame_slot' => $targetSlot,
                'status' => 'Raw_Collection', 
                'grade' => null,
            ]);
        });

        return redirect()->route('collection.index')->with('success', 'Kartu berhasil ditambahkan ke Vault!');
    }

    public function edit($id)
    {
        $card = PokemonCard::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cardSets = CardSet::all();
        return view('customer.collection.edit', compact('card', 'cardSets'));
    }

    public function update(Request $request, $id)
    {
        $card = PokemonCard::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'card_name' => 'required|string',
            'set_id' => 'required|exists:card_sets,id',
            'card_type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hall_of_fame_slot' => 'nullable|integer|min:1|max:5',
        ]);

        $imagePath = $card->raw_image_url;
        if ($request->hasFile('image')) {
            if ($card->raw_image_url && !str_starts_with($card->raw_image_url, 'http')) {
                Storage::disk('public')->delete($card->raw_image_url);
            }
            $imagePath = $request->file('image')->store('cards', 'public');
        }

        $currentSlot = $card->hall_of_fame_slot;
        $targetSlot = $request->hall_of_fame_slot;

        DB::transaction(function () use ($card, $currentSlot, $targetSlot, $request, $imagePath) {
            
            if ($currentSlot != $targetSlot) {
                if (!is_null($targetSlot)) {
                    $existingCard = PokemonCard::where('user_id', Auth::id())
                        ->where('hall_of_fame_slot', $targetSlot)
                        ->first();

                    if ($existingCard) {
                        $existingCard->update([
                            'hall_of_fame_slot' => $currentSlot
                        ]);
                    }
                }
            }

            // Simpan seluruh perubahan kartu
            $card->update([
                'set_id' => $request->set_id,
                'card_name' => $request->card_name,
                'card_type' => $request->card_type,
                'element_type' => $request->element_type,
                'hall_of_fame_slot' => $targetSlot,
                'raw_image_url' => $imagePath,
            ]);
        });

        return redirect()->route('collection.index')->with('success', 'Detail kartu dan slot Hall of Fame berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $card = PokemonCard::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($card->raw_image_url && !str_starts_with($card->raw_image_url, 'http')) {
            Storage::disk('public')->delete($card->raw_image_url);
        }
        
        $card->delete();

        return redirect()->route('collection.index')->with('success', 'Kartu berhasil dihapus dari Vault.');
    }
}