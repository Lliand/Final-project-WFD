@extends('layouts.app')

@section('content')
<div class="py-6 max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors">&larr; Kembali</a>
        <h1 class="text-2xl font-bold text-white">Edit Data User</h1>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-md">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-300">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $user->name }}" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-300">Alamat Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-300">Role / Hak Akses</label>
            <select name="role" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="Customer" {{ $user->role == 'Customer' ? 'selected' : '' }}>Customer</option>
                <option value="Staff" {{ $user->role == 'Staff' ? 'selected' : '' }}>Staff</option>
                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-6 p-4 bg-gray-900 border border-gray-700 rounded-lg">
            <label class="block mb-2 text-sm font-bold text-yellow-500">Ganti Password (Opsional)</label>
            <p class="text-xs text-gray-400 mb-3">Kosongkan kolom ini jika tidak ingin mengubah password user.</p>
            <input type="password" name="password" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" minlength="8">
        </div>

        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center shadow">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection