@extends('layouts.app')

@section('content')
<div class="py-6 max-w-7xl mx-auto px-4">
    
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-white tracking-wide">Staff Workspace</h1>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-400 rounded-lg bg-gray-800 border border-green-800 shadow">
            <span class="font-bold">Sukses!</span> {{ session('success') }}
        </div>
    @endif

    <div class="border-b border-gray-700 mb-6">
        <ul class="flex flex-wrap -mb-px text-sm font-bold text-center">
            <li class="me-2">
                <a href="{{ route('staff.dashboard', ['tab' => 'pickup']) }}" class="inline-block p-4 rounded-t-lg border-b-2 {{ $currentTab === 'pickup' ? 'text-blue-500 border-blue-500 bg-gray-800' : 'text-gray-400 border-transparent hover:text-gray-300 hover:border-gray-700' }}">
                    Pick Up Queue
                </a>
            </li>
            <li class="me-2">
                <a href="{{ route('staff.dashboard', ['tab' => 'lab']) }}" class="inline-block p-4 rounded-t-lg border-b-2 {{ $currentTab === 'lab' ? 'text-blue-500 border-blue-500 bg-gray-800' : 'text-gray-400 border-transparent hover:text-gray-300 hover:border-gray-700' }}">
                    Grading Lab
                </a>
            </li>
            <li class="me-2">
                <a href="{{ route('staff.dashboard', ['tab' => 'dropoff']) }}" class="inline-block p-4 rounded-t-lg border-b-2 {{ $currentTab === 'dropoff' ? 'text-blue-500 border-blue-500 bg-gray-800' : 'text-gray-400 border-transparent hover:text-gray-300 hover:border-gray-700' }}">
                    Drop Off Queue
                </a>
            </li>
        </ul>
    </div>

    @if($gradingRequest)
        <div class="mb-8 p-6 bg-gray-800 border border-yellow-600/50 rounded-xl shadow-lg">
            <h3 class="text-lg font-bold text-yellow-500 mb-2">Penilaian Khusus Tiket: {{ $gradingRequest->ticket_number }}</h3>
            <p class="text-sm text-gray-400 mb-4">Kartu: <span class="text-white font-bold">{{ $gradingRequest->pokemonCard->card_name }}</span></p>
            
            <form action="{{ route('staff.request.lab-submit', $gradingRequest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-300">Centering (1-10)</label>
                        <input type="number" name="centering_score" min="1" max="10" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg block w-full p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-300">Corners (1-10)</label>
                        <input type="number" name="corners_score" min="1" max="10" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg block w-full p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-300">Edges (1-10)</label>
                        <input type="number" name="edges_score" min="1" max="10" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg block w-full p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-300">Surface (1-10)</label>
                        <input type="number" name="surface_score" min="1" max="10" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg block w-full p-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-300">Final Grade</label>
                        <select name="final_grade" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg block w-full p-2" required>
                            <option value="10">10 (Gem Mint)</option>
                            <option value="9">9 (Mint)</option>
                            <option value="8">8 (Near Mint-Mint)</option>
                            <option value="7">7 (Near Mint)</option>
                            <option value="6">6 (Excellent-Mint)</option>
                            <option value="5">5 (Excellent)</option>
                            <option value="4">4 (Very Good-Excellent)</option>
                            <option value="3">3 (Very Good)</option>
                            <option value="2">2 (Good)</option>
                            <option value="1">1 (Poor)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block mb-1 text-xs font-medium text-gray-300">Foto Bukti Slab (Graded Image) <span class="text-red-500">*</span></label>
                    <input type="file" name="graded_image" accept="image/*" class="block w-full text-xs text-gray-400 bg-gray-700 border border-gray-600 rounded-lg cursor-pointer file:py-2 file:px-4 file:bg-blue-600 file:text-white file:border-0 file:font-bold mr-4" required>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('staff.dashboard', ['tab' => 'lab']) }}" class="px-4 py-2 bg-transparent text-gray-400 hover:text-white text-sm font-medium">Batal</a>
                    <button type="submit" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg text-sm shadow">Simpan Hasil Grading</button>
                </div>
            </form>
        </div>
    @endif

    @if($currentTab === 'pickup')
        <div class="relative overflow-x-auto shadow-md sm:rounded-xl border border-gray-700 bg-gray-800">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-900 text-gray-400 border-b border-gray-700">
                    <tr>
                        <th class="px-6 py-4">Tanggal Request</th>
                        <th class="px-6 py-4">No. Tiket / Pemilik</th>
                        <th class="px-6 py-4">Alamat Penjemputan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-700/40">
                            <td class="px-6 py-4 text-white font-medium">{{ $req->created_at->format('d M Y H:i') }} WIB</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-blue-400">{{ $req->ticket_number }}</span>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $req->pokemonCard->user->name ?? 'User' }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs max-w-xs truncate" title="{{ $req->pickup_address }}">{{ $req->pickup_address }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('staff.request.pickup', $req->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg shadow">Pick Up</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Antrean penjemputan kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if($currentTab === 'lab')
        <div class="bg-gray-900 p-4 rounded-xl border border-gray-700 mb-4 flex items-center justify-between">
            <form method="GET" action="{{ route('staff.dashboard') }}" class="flex items-center gap-3">
                <input type="hidden" name="tab" value="lab">
                <label class="text-xs font-bold uppercase text-gray-400">Urutan Prioritas Paket:</label>
                <select name="package_id" onchange="this.form.submit()" class="bg-gray-800 border border-gray-600 text-white text-xs rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Semua Layanan --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}" {{ $packageFilter == $pkg->id ? 'selected' : '' }}>{{ $pkg->package_name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-xl border border-gray-700 bg-gray-800">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-900 text-gray-400 border-b border-gray-700">
                    <tr>
                        <th class="px-6 py-4">Tanggal Request</th>
                        <th class="px-6 py-4">No. Tiket / Kartu</th>
                        <th class="px-6 py-4">Jenis Paket</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-700/40">
                            <td class="px-6 py-4 text-white font-medium">{{ $req->created_at->format('d M Y H:i') }} WIB</td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-white">{{ $req->ticket_number }}</span>
                                <div class="text-xs text-yellow-500 font-bold mt-0.5">{{ $req->pokemonCard->card_name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 bg-blue-900/50 text-blue-400 border border-blue-800 text-xs font-bold rounded">{{ $req->package->package_name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('staff.dashboard', ['tab' => 'lab', 'grading_id' => $req->id]) }}" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-bold text-xs rounded-lg shadow">Start Grading</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Laboratorium bersih. Tidak ada kartu yang sedang antri nilai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if($currentTab === 'dropoff')
        <div class="relative overflow-x-auto shadow-md sm:rounded-xl border border-gray-700 bg-gray-800">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-900 text-gray-400 border-b border-gray-700">
                    <tr>
                        <th class="px-6 py-4">No. Tiket</th>
                        <th class="px-6 py-4">Kartu & Skor Final</th>
                        <th class="px-6 py-4">Alamat Pengembalian</th>
                        <th class="px-6 py-4 text-center">Konfirmasi Kurir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-700/40">
                            <td class="px-6 py-4 font-bold text-white">{{ $req->ticket_number }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $req->pokemonCard->card_name ?? '-' }}</div>
                                <div class="text-xs text-green-400 font-black mt-0.5">SCORE: {{ $req->pokemonCard->grade ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs max-w-xs truncate" title="{{ $req->return_address }}">{{ $req->return_address }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('staff.request.dropoff', $req->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold text-xs rounded-lg shadow">Drop Off</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Antrian pengembalian kurir kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection