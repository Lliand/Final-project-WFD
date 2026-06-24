@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-white tracking-wide">Submit Grading Request</h1>
        <p class="text-sm text-gray-400 mt-1">Pilih kartu dari brankas, tentukan paket, dan atur penjemputan logistik White-Glove kami.</p>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 text-sm text-red-400 rounded-lg bg-gray-800 border border-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grading.request.store') }}" method="POST" class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-md">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- PILIH KARTU -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Pilih Kartu <span class="text-red-500">*</span></label>
                <select name="card_id" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Kartu --</option>
                    @foreach($cards as $card)
                        <option value="{{ $card->id }}">{{ $card->card_name }} ({{ $card->card_type }})</option>
                    @endforeach
                </select>
            </div>

            <!-- PILIH PAKET -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">Paket Layanan <span class="text-red-500">*</span></label>
                <select name="package_id" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Paket Grading --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->package_name }} - Rp {{ number_format($pkg->price, 0, ',', '.') }} - {{ $pkg->estimated_days }} hari</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-300">Alamat Penjemputan (Pickup Address) <span class="text-red-500">*</span></label>
            <textarea name="pickup_address" rows="2" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan alamat lengkap untuk kurir menjemput kartu mentah Anda..." required></textarea>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-300">Alamat Pengembalian (Return Address) <span class="text-red-500">*</span></label>
            <textarea name="return_address" rows="2" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan alamat lengkap untuk mengirimkan kembali kartu yang sudah di-slab..." required></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-700">
            <a href="{{ route('collection.index') }}" class="text-gray-400 hover:text-white text-sm font-medium px-4 py-2 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-sm transition-colors shadow">
                Buat Tiket Grading
            </button>
        </div>
    </form>
</div>
@endsection