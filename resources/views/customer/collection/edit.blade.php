@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    
    <div class="mb-8 flex justify-between items-end border-b border-gray-700 pb-5">
        <div>
            <h2 class="text-3xl font-extrabold text-white">Edit Card Details</h2>
            <p class="text-gray-400 text-sm mt-1">Perbarui informasi atau hapus kartu ini dari Vault.</p>
        </div>
        <a href="{{ route('collection.index') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">
            &larr; Back to Collection
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 text-sm text-red-400 rounded-lg bg-gray-800 border border-red-800 shadow-lg" role="alert">
            <span class="font-bold">Periksa kembali input Anda:</span>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 flex flex-col items-center shadow-xl relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-900/80 z-0"></div>
                
                @if(str_starts_with($card->raw_image_url ?? '', 'http'))
                    <img src="{{ $card->raw_image_url }}" alt="{{ $card->card_name }}" class="w-full max-w-xs rounded-xl object-contain drop-shadow-2xl relative z-10 mb-5">
                @else
                    <img src="{{ asset('storage/' . $card->raw_image_url) }}" alt="{{ $card->card_name }}" class="w-full max-w-xs rounded-xl object-contain drop-shadow-2xl relative z-10 mb-5">
                @endif
                
                <div class="relative z-10 text-center w-full border-t border-gray-700/50 pt-4">
                    <h3 class="text-xl font-bold text-white truncate">{{ $card->card_name }}</h3>
                    <p class="text-yellow-500 text-sm font-medium">{{ $card->cardSet->set_name ?? 'Unknown Set' }}</p>
                </div>
            </div>
            
            <div class="bg-red-900/10 border border-red-800/40 rounded-2xl p-5">
                <h4 class="text-red-500 font-bold mb-2 flex items-center">
                    <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    Danger Zone
                </h4>
                <p class="text-xs text-gray-400 mb-4 leading-relaxed">Tindakan ini akan menghapus kartu secara permanen dari database. Tindakan ini tidak bisa dibatalkan.</p>
                
                <form action="{{ route('collection.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membakar kartu {{ $card->card_name }} ini dari koleksi?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-900 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors shadow-lg shadow-red-900/30">
                        Delete Card
                    </button>
                </form>
            </div>

        </div>

        <div class="lg:col-span-2">
            <form action="{{ route('collection.update', $card->id) }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-8 rounded-2xl border border-gray-700 shadow-xl">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white">Card Name <span class="text-red-500">*</span></label>
                        <input type="text" name="card_name" value="{{ old('card_name', $card->card_name) }}" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-white">Set / Series <span class="text-red-500">*</span></label>
                        <select name="set_id" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @foreach($cardSets as $set)
                                <option value="{{ $set->id }}" {{ $card->set_id == $set->id ? 'selected' : '' }}>{{ $set->set_name }} ({{ $set->set_code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-white">Card Type <span class="text-red-500">*</span></label>
                        <select name="card_type" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="Pokemon" {{ $card->card_type == 'Pokemon' ? 'selected' : '' }}>Pokémon</option>
                            <option value="Trainer" {{ $card->card_type == 'Trainer' ? 'selected' : '' }}>Trainer</option>
                            <option value="Energy" {{ $card->card_type == 'Energy' ? 'selected' : '' }}>Energy</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-white">Element Type</label>
                        <select name="element_type" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="" {{ $card->element_type == null ? 'selected' : '' }}>-- Tidak Ada / Normal --</option>
                            <option value="Fire" {{ $card->element_type == 'Fire' ? 'selected' : '' }}>Fire</option>
                            <option value="Water" {{ $card->element_type == 'Water' ? 'selected' : '' }}>Water</option>
                            <option value="Grass" {{ $card->element_type == 'Grass' ? 'selected' : '' }}>Grass</option>
                            <option value="Lightning" {{ $card->element_type == 'Lightning' ? 'selected' : '' }}>Lightning</option>
                            <option value="Psychic" {{ $card->element_type == 'Psychic' ? 'selected' : '' }}>Psychic</option>
                            <option value="Darkness" {{ $card->element_type == 'Darkness' ? 'selected' : '' }}>Darkness</option>
                            <option value="Metal" {{ $card->element_type == 'Metal' ? 'selected' : '' }}>Metal</option>
                            <option value="Dragon" {{ $card->element_type == 'Dragon' ? 'selected' : '' }}>Dragon</option>
                            <option value="Colorless" {{ $card->element_type == 'Colorless' ? 'selected' : '' }}>Colorless</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-yellow-500">Hall of Fame Slot (1-5)</label>
                        <input type="number" name="hall_of_fame_slot" min="1" max="5" value="{{ old('hall_of_fame_slot', $card->hall_of_fame_slot) }}" class="bg-gray-700 border border-yellow-600/50 text-white text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 placeholder-gray-500" placeholder="Kosongkan jika tidak dipajang">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-white">Perbarui Foto Kartu <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                    <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-gray-600 file:text-white hover:file:bg-gray-500 bg-gray-700 border border-gray-600 rounded-lg cursor-pointer focus:outline-none">
                    <p class="mt-2 text-xs text-gray-400">Biarkan kosong jika Anda tidak ingin mengubah gambar saat ini.</p>
                </div>

                <div class="mb-8">
                    <label class="block mb-2 text-sm font-medium text-white">Description / Notes</label>
                    <textarea name="description" rows="3" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('description', $card->description) }}</textarea>
                </div>

                <div class="flex justify-end pt-5 border-t border-gray-700">
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-8 py-2.5 shadow-lg shadow-blue-900/50 transition-colors">
                        Update Data Kartu
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection