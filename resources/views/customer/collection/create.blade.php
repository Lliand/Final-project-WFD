@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-white">Add New Card to Vault</h2>
        <p class="text-gray-400 text-sm mt-1">Masukkan detail kartu Pokémon baru ke dalam koleksimu.</p>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 text-sm text-red-400 rounded-lg bg-gray-800 border border-red-800" role="alert">
            <span class="font-bold">Periksa kembali input Anda:</span>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('collection.insert') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-8 rounded-2xl border border-gray-700 shadow-xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div>
                <label class="block mb-2 text-sm font-medium text-white">Card Name <span class="text-red-500">*</span></label>
                <input type="text" name="card_name" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Charizard VMAX" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Set / Series <span class="text-red-500">*</span></label>
                <select name="set_id" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Set --</option>
                    @foreach($cardSets as $set)
                        <option value="{{ $set->id }}">{{ $set->set_name }} ({{ $set->set_code }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Card Type <span class="text-red-500">*</span></label>
                <select name="card_type" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Pokemon">Pokémon</option>
                    <option value="Trainer">Trainer</option>
                    <option value="Energy">Energy</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Element Type <span class="text-gray-400 text-xs font-normal">(Kosongkan jika Trainer)</span></label>
                <select name="element_type" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">-- Tidak Ada / Normal --</option>
                    <option value="Fire">Fire</option>
                    <option value="Water">Water</option>
                    <option value="Grass">Grass</option>
                    <option value="Lightning">Lightning</option>
                    <option value="Psychic">Psychic</option>
                    <option value="Darkness">Darkness</option>
                    <option value="Metal">Metal</option>
                    <option value="Dragon">Dragon</option>
                    <option value="Colorless">Colorless</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Card Grade <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                <select name="grade" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Ungraded / Raw</option>
                    <option value="10">10 (Gem Mint)</option>
                    <option value="9">9 (Mint)</option>
                    <option value="8">8 (Near Mint-Mint)</option>
                    <option value="7">7 (Near Mint)</option>
                    <option value="6">6 (Excellent-Mint)</option>
                    <option value="5">5 (Excellent)</option>
                    <option value="4">4 (Very Good-Excellent)</option>
                    <option value="3">3 (Very Good)</option>
                    <option value="2">2 (Good)</option>
                    <option value="1">1 (Poor)</option>
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Date Obtained <span class="text-red-500">*</span></label>
                <input type="date" name="date_obtained" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-yellow-500">Hall of Fame Slot (1-5) <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                <input type="number" name="hall_of_fame_slot" min="1" max="5" class="bg-gray-700 border border-yellow-600/50 text-white text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 placeholder-gray-500" placeholder="Pilih slot 1 sampai 5">
                <p class="mt-1 text-xs text-gray-400">Isi angka 1-5 jika ingin kartu ini dipajang di etalase depan.</p>
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-white">Foto Kartu <span class="text-red-500">*</span></label>
            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 bg-gray-700 border border-gray-600 rounded-lg cursor-pointer focus:outline-none" required>
            <p class="mt-2 text-xs text-gray-400">
                <span class="font-bold text-gray-300">Format yang didukung:</span> JPG, PNG, WEBP (Maksimal 2MB).
            </p>
        </div>

        <div class="mb-8">
            <label class="block mb-2 text-sm font-medium text-white">Description / Notes <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
            <textarea name="description" rows="3" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Tambahkan catatan khusus tentang kartu ini..."></textarea>
        </div>

        <div class="flex items-center justify-end space-x-4 border-t border-gray-700 pt-6">
            <a href="{{ route('collection.index') }}" class="text-gray-400 bg-transparent hover:text-white font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                Cancel
            </a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-8 py-2.5 text-center transition-colors shadow-lg shadow-blue-900/50">
                Save to Vault
            </button>
        </div>

    </form>
</div>
@endsection