@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-wide">Master Card Sets</h1>
            <p class="text-sm text-gray-400">Kelola daftar set rilis Pokémon.</p>
        </div>
        <a href="{{ route('admin.card-sets.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-800 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors shadow-lg shadow-blue-900/50">
            + Tambah Set
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-400 rounded-lg bg-gray-800 border border-green-800 animate-pulse" role="alert">
            <span class="font-bold">Sukses!</span> {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-xl mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-400">
                <thead class="text-xs text-gray-300 uppercase bg-gray-900 border-b border-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-4">Set Code</th>
                        <th scope="col" class="px-6 py-4">Nama Set</th>
                        <th scope="col" class="px-6 py-4 text-center">Tahun Rilis</th>
                        <th scope="col" class="px-6 py-4 text-center">Total Kartu</th>
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cardSets as $set)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-750 transition-colors bg-gray-800">
                        <td class="px-6 py-4 font-bold text-blue-400">{{ $set->set_code }}</td>
                        <td class="px-6 py-4 text-white">{{ $set->set_name }}</td>
                        <td class="px-6 py-4 text-center text-gray-300">{{ $set->release_year }}</td>
                        <td class="px-6 py-4 text-center text-gray-300">{{ $set->total_cards }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-4">
                                <a href="{{ route('admin.card-sets.edit', $set->id) }}" class="text-blue-400 hover:text-blue-300 font-medium transition-colors">Edit</a>
                                <form action="{{ route('admin.card-sets.destroy', $set->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus set ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 font-medium transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 bg-gray-800">
                            Belum ada data set kartu yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection