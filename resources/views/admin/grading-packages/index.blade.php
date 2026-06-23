@extends('layouts.app')

@section('content')
<div class="py-4">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-wide">Grading Packages</h1>
            <p class="text-sm text-gray-400">Kelola daftar paket dan harga layanan White-Glove.</p>
        </div>
        <a href="{{ route('admin.grading-packages.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors shadow-lg shadow-blue-900/20">
            + Tambah Paket
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
                        <th scope="col" class="px-6 py-4">Nama Paket</th>
                        <th scope="col" class="px-6 py-4">Harga (Rp)</th>
                        <th scope="col" class="px-6 py-4 text-center">Estimasi Selesai</th>
                        <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $pkg)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-750 transition-colors bg-gray-800">
                        <td class="px-6 py-4 font-bold text-white">{{ $pkg->package_name }}</td>
                        <td class="px-6 py-4 text-green-400 font-medium">Rp {{ number_format($pkg->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center text-yellow-500 font-bold">{{ $pkg->estimated_days }} Hari</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-4">
                                <a href="{{ route('admin.grading-packages.edit', $pkg->id) }}" class="text-blue-400 hover:text-blue-300 font-medium transition-colors">Edit</a>
                                <form action="{{ route('admin.grading-packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 font-medium transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 bg-gray-800">
                            Belum ada paket layanan yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection