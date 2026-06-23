@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8">
    <div class="mb-8 border-b border-gray-700 pb-5">
        <h2 class="text-3xl font-extrabold text-white">Submit Grading Request</h2>
        <p class="text-gray-400 text-sm mt-2">Mulai proses White-Glove untuk kartu koleksimu. Tim kami akan menjemput kartumu dengan aman.</p>
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

    @if($cards->isEmpty())
        <div class="p-8 text-center bg-gray-800 border border-gray-700 rounded-2xl shadow-xl">
            <h3 class="text-xl font-bold text-white mb-2">Tidak Ada Kartu Raw</h3>
            <p class="text-gray-400 mb-6">Kamu belum menambahkan kartu ke dalam vault, atau semua kartumu sedang/sudah di-grade.</p>
            <a href="{{ route('collection.create') }}" class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                + Tambah Kartu Baru
            </a>
        </div>
    @else
        <form action="{{ route('grading.request.store') }}" method="POST" class="bg-gray-800 p-8 rounded-2xl border border-gray-700 shadow-xl">
            @csrf

            <h3 class="text-xl font-bold text-yellow-500 border-b border-gray-700 pb-2 mb-6">1. Pilih Kartu & Layanan</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block mb-2 text-sm font-medium text-white">Pilih Kartu dari Vault <span class="text-red-500">*</span></label>
                    <select name="card_id" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required>
                        <option value="">-- Pilih Kartu --</option>
                        @foreach($cards as $card)
                            <option value="{{ $card->id }}">{{ $card->card_name }} ({{ $card->cardSet->set_name ?? 'Unknown Set' }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-white">Paket White-Glove Grading <span class="text-red-500">*</span></label>
                    <select name="package_id" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required>
                        <option value="">-- Pilih Paket --</option>
                        @foreach($packages as $pkg)
                            <option value="{{ $pkg->id }}">{{ $pkg->package_name }} - Rp{{ number_format($pkg->price, 0, ',', '.') }} (Estimasi {{ $pkg->estimated_days }} Hari)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h3 class="text-xl font-bold text-yellow-500 border-b border-gray-700 pb-2 mb-6">2. Informasi Logistik White-Glove</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block mb-2 text-sm font-medium text-white">Alamat Penjemputan (Pick-up) <span class="text-red-500">*</span></label>
                    <textarea name="pickup_address" rows="3" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Alamat lengkap lokasi penjemputan kartu oleh staf kami..." required>{{ Auth::user()->default_address }}</textarea>
                    <p class="mt-1 text-xs text-gray-400">Pastikan alamat jelas agar staf dapat menemukan lokasi Anda.</p>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-white">Alamat Pengembalian (Return) <span class="text-red-500">*</span></label>
                    <textarea name="return_address" rows="3" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Alamat pengiriman kembali setelah kartu selesai di-grade..." required>{{ Auth::user()->default_address }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 border-t border-gray-700 pt-6">
                <a href="{{ route('collection.index') }}" class="text-gray-400 bg-transparent hover:text-white font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                    Batal
                </a>
                <button type="submit" class="text-gray-950 bg-gradient-to-r from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-800 font-bold rounded-lg text-sm px-8 py-3 text-center transition-all shadow-lg shadow-yellow-900/40">
                    Submit Transaksi
                </button>
            </div>
        </form>
    @endif
</div>
@endsection