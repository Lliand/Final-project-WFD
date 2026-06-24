@extends('layouts.app')

@section('content')
<div class="py-6 max-w-6xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-white tracking-wide">Grading History & Tracking</h1>
        <p class="text-sm text-gray-400 mt-1">Lacak status logistik dan proses penilaian kartu Anda secara real-time.</p>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-400 rounded-lg bg-gray-800 border border-green-800" role="alert">
            <span class="font-bold">Sukses!</span> {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-xl border border-gray-700">
        <table class="w-full text-sm text-left text-gray-400 bg-gray-800">
            <thead class="text-xs uppercase bg-gray-900 text-gray-400 border-b border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4">Tiket Logistik</th>
                    <th scope="col" class="px-6 py-4">Kartu & Paket</th>
                    <th scope="col" class="px-6 py-4">Status Logistik</th>
                    <th scope="col" class="px-6 py-4">Status Penilaian</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($requests as $req)
                    <tr class="hover:bg-gray-700/50 transition-colors">
                        
                        <td class="px-6 py-4">
                            <span class="font-bold text-white">{{ $req->ticket_number }}</span>
                            <div class="text-xs text-gray-500 mt-1">{{ $req->created_at->format('d M Y') }}</div>
                        </td>
                        
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-blue-400">{{ $req->pokemonCard->card_name ?? 'Kartu Dihapus' }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $req->package->package_name ?? '-' }} (Rp {{ number_format($req->total_fee, 0, ',', '.') }})</div>
                        </td>

                        
                        <td class="px-6 py-4">
                            @if($req->logistics_status === 'Waiting_For_Pickup')
                                <span class="bg-yellow-950 text-yellow-400 px-2.5 py-1 rounded text-xs font-bold border border-yellow-800 animate-pulse">
                                    Menunggu Penjemputan
                                </span>
                            @elseif($req->logistics_status === 'In_Lab')
                                <span class="bg-blue-950 text-blue-400 px-2.5 py-1 rounded text-xs font-bold border border-blue-800">
                                    Dalam Lab Grading
                                </span>
                            @elseif($req->logistics_status === 'Grading_Done')
                                <span class="bg-purple-950 text-purple-400 px-2.5 py-1 rounded text-xs font-bold border border-purple-800">
                                    Grading Selesai, Dalam Perjalanan
                                </span>
                            @elseif($req->logistics_status === 'Completed')
                                <span class="bg-green-950 text-green-400 px-2.5 py-1 rounded text-xs font-bold border border-green-800">
                                    ✓ Selesai Terverifikasi
                                </span>
                            @else
                                <span class="bg-gray-700 text-gray-300 px-2.5 py-1 rounded text-xs font-bold border border-gray-600">
                                    {{ $req->logistics_status }}
                                </span>
                            @endif
                        </td>

                        
                        <td class="px-6 py-4">
                            @if($req->pokemonCard)
                                @if($req->pokemonCard->status === 'Raw_Pending')
                                    <span class="text-yellow-400 font-medium">Masuk Antrian Staff</span>
                                @elseif($req->pokemonCard->status === 'In_Grading')
                                    <span class="text-blue-400 font-medium">Sedang Dalam Proses Grading</span>
                                @elseif($req->pokemonCard->status === 'Graded_Inventory')
                                    <span class="text-green-400 font-bold">✓ PSA {{ $req->pokemonCard->grade }} (Selesai)</span>
                                @else
                                    <span class="text-gray-400">{{ $req->pokemonCard->status }}</span>
                                @endif
                            @else
                                <span class="text-red-400">Data Tidak Tersedia</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat tiket pengajuan grading.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection