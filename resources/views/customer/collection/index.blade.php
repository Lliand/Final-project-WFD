@extends('layouts.app')

@section('content')
<div class="py-4">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-wide">My Collection</h1>
            <p class="text-sm text-gray-400">Total: {{ count($data) }} kartu di dalam Vault.</p>
        </div>
        <a href="{{ route('collection.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors">
            + Add New Card
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-400 rounded-lg bg-gray-800 border border-green-800 animate-pulse" role="alert">
            <span class="font-bold">Sukses!</span> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('collection.index') }}" method="GET" class="bg-gray-800 p-5 rounded-xl border border-gray-700 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 align-middle">
            
            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-400">Search Card</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}" class="block w-full ps-10 p-2.5 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Ketik nama Pokémon...">
                </div>
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-400">Filters</label>
                <div class="grid grid-cols-3 gap-2">
                    
                    <select name="filterType" class="bg-gray-700 border border-gray-600 text-white text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">All Types</option>
                        <option value="Pokemon" {{ $filterType == 'Pokemon' ? 'selected' : '' }}>Pokémon</option>
                        <option value="Trainer" {{ $filterType == 'Trainer' ? 'selected' : '' }}>Trainer</option>
                        <option value="Energy" {{ $filterType == 'Energy' ? 'selected' : '' }}>Energy</option>
                    </select>

                    <select name="filterElement" class="bg-gray-700 border border-gray-600 text-white text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">All Elements</option>
                        <option value="Fire" {{ $filterElement == 'Fire' ? 'selected' : '' }}>Fire</option>
                        <option value="Water" {{ $filterElement == 'Water' ? 'selected' : '' }}>Water</option>
                        <option value="Grass" {{ $filterElement == 'Grass' ? 'selected' : '' }}>Grass</option>
                        <option value="Lightning" {{ $filterElement == 'Lightning' ? 'selected' : '' }}>Lightning</option>
                        <option value="Psychic" {{ $filterElement == 'Psychic' ? 'selected' : '' }}>Psychic</option>
                        <option value="Darkness" {{ $filterElement == 'Darkness' ? 'selected' : '' }}>Darkness</option>
                        <option value="Metal" {{ $filterElement == 'Metal' ? 'selected' : '' }}>Metal</option>
                        <option value="Dragon" {{ $filterElement == 'Dragon' ? 'selected' : '' }}>Dragon</option>
                        <option value="Colorless" {{ $filterElement == 'Colorless' ? 'selected' : '' }}>Colorless</option>
                    </select>

                    <select name="filterSet" class="bg-gray-700 border border-gray-600 text-white text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">All Sets</option>
                        @foreach($availableSets as $set)
                            @if($set->set_name != '')
                                <option value="{{ $set->id }}" {{ $filterSet == $set->id ? 'selected' : '' }}>
                                    {{ $set->set_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block mb-2 text-xs font-bold uppercase tracking-wider text-gray-400">Sort & Apply</label>
                <div class="flex space-x-2">
                    
                    <select name="sortBy" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="date_obtained" {{ $sortBy == 'date_obtained' ? 'selected' : '' }}>Date Obtained</option>
                        <option value="price" {{ $sortBy == 'price' ? 'selected' : '' }}>Market Price</option>
                        <option value="grade" {{ $sortBy == 'grade' ? 'selected' : '' }}>PSA Grade</option>
                    </select>

                    <select name="sortMode" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="desc" {{ $sortMode == 'desc' ? 'selected' : '' }}>DESC</option>
                        <option value="asc" {{ $sortMode == 'asc' ? 'selected' : '' }}>ASC</option>
                    </select>

                    <button type="submit" class="p-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg border border-blue-700 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Apply
                    </button>
                </div>
            </div>

        </div>
    </form>
    @if(count($data) == 0)
        <div class="text-center py-12 bg-gray-800 rounded-xl border border-gray-700 text-gray-400">
            <p class="text-lg font-medium">Tidak ada kartu yang cocok dengan kriteria filter/pencarian.</p>
            <a href="{{ route('collection.index') }}" class="text-blue-400 underline mt-2 inline-block text-sm">Reset Filter</a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($data as $index => $item)
                
                <a href="{{ route('collection.edit', $item->id) }}" class="group bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-md hover:border-blue-500 transition-all duration-200 flex flex-col relative">
                    
                    @if($item->hall_of_fame_slot != null)
                        <span class="absolute top-2 left-2 bg-yellow-500 text-gray-950 text-[9px] font-black px-2 py-0.5 rounded-full z-10 uppercase tracking-wider shadow">
                            HOF Slot {{ $item->hall_of_fame_slot }}
                        </span>
                    @endif

                    <div class="p-3 bg-gray-900/50 aspect-[3/4] flex items-center justify-center overflow-hidden">
                        @if(str_starts_with($item->raw_image_url ?? '', 'http'))
                            <img src="{{ $item->raw_image_url }}" alt="{{ $item->card_name }}" class="w-full h-full object-contain rounded-lg group-hover:scale-105 transition-transform duration-200">
                        @else
                            <img src="{{ asset('storage/' . $item->raw_image_url) }}" alt="{{ $item->card_name }}" class="w-full h-full object-contain rounded-lg group-hover:scale-105 transition-transform duration-200">
                        @endif
                    </div>

                    <div class="p-3 flex-grow flex flex-col justify-between border-t border-gray-700/50 bg-gray-800">
                        <div>
                            <h3 class="text-sm font-bold text-white truncate group-hover:text-blue-400 transition-colors" title="{{ $item->card_name }}">
                                {{ $item->card_name }}
                            </h3>
                            <span class="text-[11px] text-gray-400 block truncate">{{ $item->cardSet->set_name ?? 'Unknown Set' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-700/40 text-[12px]">
                            <div class="flex flex-col">
                                <span class="text-[9px] text-gray-500 uppercase tracking-widest mb-0.5">Grade</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-white text-xs">
                                        @if($item->final_grade != null)
                                            <span class="text-yellow-500">★</span> {{ $item->final_grade }}
                                        @else
                                            <span class="text-gray-400 text-[9px] font-bold tracking-widest uppercase">Ungraded</span>
                                        @endif
                                    </span>
                                    
                                    @if($item->status === 'Graded_Inventory')
                                        <span class="bg-blue-900/50 text-blue-400 border border-blue-700 text-[8px] font-black uppercase px-1.5 py-0.5 rounded shadow-sm">
                                            ✓ PV Approved
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </a>

            @endforeach
        </div>
    @endif

</div>
@endsection