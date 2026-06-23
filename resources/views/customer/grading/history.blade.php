@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-wide">Transaction History</h1>
            <p class="text-sm text-gray-400 mt-2">Pantau status logistik dan grading dari kartu yang kamu submit.</p>
        </div>
        <a href="{{ route('grading.request.create') }}" class="text-gray-950 bg-yellow-500 hover:bg-yellow-400 font-bold rounded-lg text-sm px-5 py-2.5 transition-colors shadow-lg shadow-yellow-900/20">
            + Submit Grading
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-400 rounded-lg bg-gray-800 border border-green-800 animate-pulse" role="alert">
            <span class="font-bold">Sukses!</span> {{ session('success') }}
        </div>
    @endif

    @if($requests->isEmpty())
        <div class="p-12 text-center bg-gray-800 border border-gray-700 rounded-2xl shadow-xl">
            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5v14m-6-8h18"/></svg>
            <h3 class="text-xl font-bold text-white mb-2">Belum Ada Transaksi</h3>
            <p class="text-gray-400 mb-6">Kamu belum pernah melakukan permintaan grading White-Glove.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($requests as $req)
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6 flex flex-col shadow-lg hover:shadow-xl hover:border-yellow-600/50 transition-all">
                    
                    <div class="flex justify-between items-start mb-4">
                        <div class="bg-gray-900 px-3 py-1 rounded-md border border-gray-700">
                            <span class="text-xs font-mono text-yellow-500 font-bold">{{ $req->ticket_number }}</span>
                        </div>
                        <span class="text-[10px] text-gray-400">{{ $req->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="mb-4 flex-grow">
                        <h3 class="text-lg font-bold text-white truncate">{{ $req->pokemonCard->card_name ?? 'Kartu Dihapus' }}</h3>
                        <p class="text-xs text-blue-400 font-medium mb-3">{{ $req->package->package_name ?? 'Paket Tidak Tersedia' }}</p>
                        
                        <div class="mt-2">
                            <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold block mb-1">Status Logistik</span>
                            <span class="inline-block px-2 py-1 rounded text-xs font-bold 
                                {{ $req->logistics_status === 'Waiting_For_Pickup' ? 'bg-yellow-900/50 text-yellow-400' : '' }}
                                {{ $req->logistics_status === 'Picked_Up_Unconfirmed' ? 'bg-blue-900/50 text-blue-400' : '' }}
                                {{ $req->logistics_status === 'In_Lab' ? 'bg-purple-900/50 text-purple-400' : '' }}
                                {{ $req->logistics_status === 'Grading_Done' ? 'bg-orange-900/50 text-orange-400' : '' }}
                                {{ $req->logistics_status === 'Returned_Unconfirmed' ? 'bg-indigo-900/50 text-indigo-400' : '' }}
                                {{ $req->logistics_status === 'Completed' ? 'bg-green-900/50 text-green-400' : '' }}">
                                {{ str_replace('_', ' ', $req->logistics_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 pt-4 flex justify-between items-center">
                        <div>
                            <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold block">Biaya Layanan</span>
                            <span class="text-sm font-bold text-green-400">Rp{{ number_format($req->total_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase tracking-widest text-gray-500 font-bold block">PSA Grade</span>
                            <span class="text-lg font-extrabold {{ $req->final_grade ? 'text-yellow-500' : 'text-gray-600' }}">
                                {{ $req->final_grade ?? '---' }}
                            </span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection