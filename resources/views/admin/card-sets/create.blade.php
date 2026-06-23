@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-white">Tambah Card Set Baru</h2>
        <p class="text-gray-400 text-sm mt-1">Masukkan detail set rilis Pokémon baru ke dalam database.</p>
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

    <form action="{{ route('admin.card-sets.store') }}" method="POST" class="bg-gray-800 p-8 rounded-2xl border border-gray-700 shadow-xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block mb-2 text-sm font-medium text-white">Set Code <span class="text-red-500">*</span></label>
                <input type="text" name="set_code" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: PAF" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Nama Set <span class="text-red-500">*</span></label>
                <input type="text" name="set_name" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Paldean Fates" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Tahun Rilis <span class="text-red-500">*</span></label>
                <input type="number" name="release_year" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: 2024" required>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-white">Total Kartu <span class="text-red-500">*</span></label>
                <input type="number" name="total_cards" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: 245" required>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4 border-t border-gray-700 pt-6">
            <a href="{{ route('admin.card-sets.index') }}" class="text-gray-400 bg-transparent hover:text-white font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                Cancel
            </a>
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-8 py-2.5 text-center transition-colors shadow-lg shadow-blue-900/50">
                Simpan Set
            </button>
        </div>
    </form>
</div>
@endsection