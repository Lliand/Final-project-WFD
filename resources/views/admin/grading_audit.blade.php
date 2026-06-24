@extends('layouts.app')

@section('content')
<div class="py-6 max-w-7xl mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-white tracking-wide">Audit Trail: Grading Records</h1>
        <p class="text-sm text-gray-400 mt-1">Review bukti autentikasi: perbandingan gambar raw vs slab premium dan skor penilaian Staff.</p>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-xl border border-gray-700 bg-gray-800">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-900 text-gray-400 border-b border-gray-700">
                <tr>
                    <th class="px-6 py-4">Tiket & Staff</th>
                    <th class="px-6 py-4 text-center">Bukti Visual (Raw vs Graded)</th>
                    <th class="px-6 py-4">Skor Detail</th>
                    <th class="px-6 py-4">Customer</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($requests as $req)
                    <tr class="hover:bg-gray-700/30">
                        <td class="px-6 py-4">
                            <div class="font-bold text-blue-400">{{ $req->ticket_number }}</div>
                            <div class="text-xs text-gray-500 mt-1">Grader: <span class="text-white">{{ $req->grader->name ?? 'N/A' }}</span></div>
                        </td>
                        
                        <td class="px-6 py-4 flex items-center gap-4 justify-center">
                            <div class="text-center">
                                <span class="text-[10px] text-gray-500 uppercase block mb-1">Raw</span>
                                <img src="{{ asset('storage/' . $req->pokemonCard->raw_image_url) }}" class="h-20 w-14 object-cover rounded border border-gray-600 shadow-sm">
                            </div>
                            <div class="text-2xl text-gray-600">→</div>
                            <div class="text-center">
                                <span class="text-[10px] text-gray-500 uppercase block mb-1">Graded</span>
                                <img src="{{ asset('storage/' . $req->pokemonCard->graded_image_url) }}" class="h-20 w-14 object-cover rounded border border-yellow-500 shadow-lg shadow-yellow-900/20">
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="grid grid-cols-2 gap-x-4 text-[11px] text-gray-300">
                                <div>Centering: <span class="font-bold text-white">{{ $req->centering_score }}</span></div>
                                <div>Corners: <span class="font-bold text-white">{{ $req->corners_score }}</span></div>
                                <div>Edges: <span class="font-bold text-white">{{ $req->edges_score }}</span></div>
                                <div>Surface: <span class="font-bold text-white">{{ $req->surface_score }}</span></div>
                            </div>
                            <div class="mt-2 font-black text-green-400 text-lg border-t border-gray-700 pt-1">
                                FINAL: {{ $req->final_grade }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-white font-medium">{{ $req->customer->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-gray-500">{{ $req->customer->email ?? '-' }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada data grading yang di-audit.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection