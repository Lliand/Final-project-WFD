@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="mb-12">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-yellow-500 to-yellow-600 drop-shadow-sm mb-1">
            Hall of Fame
        </h1>
        <p class="text-gray-400 text-sm">-- Best Cards of the Collection</p>
    </div>

    @if($showcase->isEmpty())
        <div class="flex flex-col items-center justify-center p-12 bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700">
            <svg class="w-16 h-16 text-gray-500 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14v4m-4 1h8M1 10h18M2 1h16a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-300 mb-2">Hall Of Fame Masih Kosong</h2>
            <p class="text-gray-400 text-center mb-6">Kamu belum memilih kartu untuk dipajang di Hall of Fame.</p>
            <a href="{{ route('collection.index') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                Pilih Kartu dari Koleksi
            </a>
        </div>
    @else
        
        @php
            $highlight = $showcase->firstWhere('hall_of_fame_slot', 1);
            $others = $showcase->where('hall_of_fame_slot', '!=', 1)->sortBy('hall_of_fame_slot');
        @endphp

        @if($highlight)
            <div class="flex justify-center mb-16 relative">
                <div class="absolute inset-0 bg-yellow-500/10 blur-[100px] rounded-full w-96 h-96 mx-auto z-0"></div>

                <div class="relative w-full max-w-sm bg-gray-800/90 backdrop-blur-md rounded-3xl border-2 border-yellow-500/50 shadow-[0_0_40px_rgba(234,179,8,0.3)] hover:shadow-[0_0_60px_rgba(234,179,8,0.5)] transition-all duration-500 transform hover:-translate-y-2 overflow-hidden flex flex-col z-10">
                    
                    <div class="absolute top-4 right-4 bg-yellow-500/20 backdrop-blur-sm border border-yellow-500/50 text-yellow-400 text-xs font-black px-4 py-1.5 rounded-full z-20 shadow-lg uppercase tracking-widest flex items-center">
                        <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M11 2.016a1 1 0 0 1 1.764-.648l2.946 3.513 3.513-2.946a1 1 0 0 1 1.648.764v15.301a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2.699a1 1 0 0 1 1.648-.764l3.513 2.946 2.946-3.513a1 1 0 0 1 .893-.352Z"/></svg>
                        Main Showcase
                    </div>

                    <div class="p-6 flex-grow flex items-center justify-center relative aspect-[3/4] overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-900/90 z-0"></div>
                        @if(str_starts_with($highlight->raw_image_url ?? '', 'http'))
                            <img src="{{ $highlight->raw_image_url }}" alt="{{ $highlight->card_name }}" class="w-full h-full object-contain rounded-lg relative z-10 drop-shadow-2xl">
                        @else
                            <img src="{{ asset('storage/' . $highlight->raw_image_url) }}" alt="{{ $highlight->card_name }}" class="w-full h-full object-contain rounded-lg relative z-10 drop-shadow-2xl">
                        @endif
                    </div>

                    <div class="p-6 relative z-10 bg-gray-900/80 border-t border-yellow-600/30">
                        <h3 class="text-2xl font-extrabold text-white mb-1 truncate">{{ $highlight->card_name }}</h3>
                        <p class="text-base text-yellow-500 font-bold mb-5">{{ $highlight->cardSet->set_name ?? 'Unknown Set' }}</p>

                        <div class="flex justify-between items-center bg-gray-950 rounded-2xl p-4 border border-gray-800">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-400 uppercase tracking-widest mb-1">Grade</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-lg text-white">
                                        @if($highlight->grade != null)
                                            <span class="text-yellow-500">★</span> {{ $highlight->grade }}
                                        @else
                                            <span class="text-gray-500 text-xs font-bold tracking-widest uppercase italic">Ungraded</span>
                                        @endif
                                    </span>
                                    
                                    @if($highlight->status === 'Graded_Inventory')
                                        <span class="bg-blue-900/40 text-blue-400 border border-blue-700/50 text-[9px] font-black uppercase px-2 py-1 rounded shadow-sm">
                                            ✓ PV Approved
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($others->isNotEmpty())
            <div class="flex items-center justify-center mb-10">
                <div class="h-px w-1/4 bg-gradient-to-r from-transparent to-gray-700"></div>
                <span class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Honorable Mentions</span>
                <div class="h-px w-1/4 bg-gradient-to-l from-transparent to-gray-700"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($others as $item)
                    <div class="relative bg-gray-800/90 backdrop-blur-md rounded-2xl border-2 border-yellow-600/20 shadow-[0_0_15px_rgba(234,179,8,0.1)] hover:shadow-[0_0_25px_rgba(234,179,8,0.3)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col overflow-hidden group">
                        
                        <div class="absolute inset-x-0 top-0 bg-yellow-500/5 blur-[40px] h-32 z-0"></div>

                        <div class="absolute top-3 right-3 bg-gray-900/80 text-yellow-500 text-[10px] font-black px-3 py-1 rounded-full z-20 shadow-md uppercase tracking-wider border border-yellow-600/30">
                            Slot {{ $item->hall_of_fame_slot }}
                        </div>

                        <div class="p-4 flex-grow flex items-center justify-center relative aspect-[3/4] overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-900/90 z-0"></div>
                            @if(str_starts_with($item->raw_image_url ?? '', 'http'))
                                <img src="{{ $item->raw_image_url }}" alt="{{ $item->card_name }}" class="w-full h-full object-contain rounded-lg relative z-10 drop-shadow-xl">
                            @else
                                <img src="{{ asset('storage/' . $item->raw_image_url) }}" alt="{{ $item->card_name }}" class="w-full h-full object-contain rounded-lg relative z-10 drop-shadow-xl">
                            @endif
                        </div>

                        <div class="p-4 relative z-10 bg-gray-900/80 border-t border-yellow-600/20">
                            <h3 class="text-base font-bold text-white mb-0.5 truncate">{{ $item->card_name }}</h3>
                            <p class="text-xs text-yellow-500/80 font-medium mb-4">{{ $item->cardSet->set_name ?? 'Unknown Set' }}</p>

                            <div class="flex justify-between items-center bg-gray-950 rounded-xl p-3 border border-gray-800">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-gray-500 uppercase tracking-widest mb-0.5">Grade</span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-bold text-white text-xs">
                                            @if($item->grade != null)
                                                <span class="text-yellow-500">★</span> {{ $item->grade }}
                                            @else
                                                <span class="text-gray-400 text-[9px] font-bold tracking-widest uppercase">Ungraded</span>
                                            @endif
                                        </span>

                                        @if($item->status === 'Graded_Inventory')
                                            <span class="bg-blue-900/40 text-blue-400 border border-blue-700/50 text-[7px] font-black uppercase px-1.5 py-0.5 rounded shadow-sm">
                                                ✓ PV
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
@endsection