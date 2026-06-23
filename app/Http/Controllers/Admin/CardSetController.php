<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CardSet;
use Illuminate\Http\Request;

class CardSetController extends Controller
{
    public function index()
    {
        $cardSets = CardSet::latest()->get();
        return view('admin.card-sets.index', compact('cardSets'));
    }

    public function create()
    {
        return view('admin.card-sets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'set_code' => 'required|string|unique:card_sets,set_code',
            'set_name' => 'required|string',
            'release_year' => 'required|digits:4|integer',
            'total_cards' => 'required|integer|min:1',
        ]);

        CardSet::create($validated);

        return redirect()->route('admin.card-sets.index')->with('success', 'Set kartu berhasil ditambahkan!');
    }

    public function show(CardSet $cardSet)
    {
        abort(404);
    }

    public function edit(CardSet $cardSet)
    {
        return view('admin.card-sets.edit', compact('cardSet'));
    }

    public function update(Request $request, CardSet $cardSet)
    {
        $validated = $request->validate([
            'set_code' => 'required|string|unique:card_sets,set_code,' . $cardSet->id,
            'set_name' => 'required|string',
            'release_year' => 'required|digits:4|integer',
            'total_cards' => 'required|integer|min:1',
        ]);

        $cardSet->update($validated);

        return redirect()->route('admin.card-sets.index')->with('success', 'Set kartu berhasil diperbarui!');
    }

    public function destroy(CardSet $cardSet)
    {
        $cardSet->delete();

        return redirect()->route('admin.card-sets.index')->with('success', 'Set kartu berhasil dihapus!');
    }
}