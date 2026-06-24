@extends('layouts.app')

@section('content')
<div class="py-6 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-wide">User Management</h1>
            <p class="text-sm text-gray-400 mt-1">Kelola data pengguna, peran (role), dan hak akses sistem.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors shadow">
            + Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-400 rounded-lg bg-gray-800 border border-green-800" role="alert">
            <span class="font-bold">Sukses!</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 mb-6 text-sm text-red-400 rounded-lg bg-gray-800 border border-red-800" role="alert">
            <span class="font-bold">Gagal!</span> {{ session('error') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-xl border border-gray-700">
        <table class="w-full text-sm text-left text-gray-400 bg-gray-800">
            <thead class="text-xs uppercase bg-gray-900 text-gray-400 border-b border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-4">Email</th>
                    <th scope="col" class="px-6 py-4">Role Hak Akses</th>
                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-white">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->role === 'Admin')
                                <span class="bg-green-600 text-white px-2.5 py-1 rounded text-xs font-bold border border-green-800">ADMIN</span>
                            @elseif($user->role === 'Staff')
                                <span class="bg-orange-800 text-white px-2.5 py-1 rounded text-xs font-bold border border-orange-800">STAFF</span>
                            @else
                                <span class="bg-yellow-500 text-gray-950 px-2.5 py-1 rounded text-xs font-bold border border-yellow-800">CUSTOMER</span>
                            @endif  
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="font-medium text-blue-400 hover:underline">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini? Semua data terkait (kartu) bisa ikut terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection