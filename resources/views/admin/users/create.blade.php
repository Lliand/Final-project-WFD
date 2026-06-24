@extends('layouts.app')

@section('content')
<div class="py-6 max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors">&larr; Kembali</a>
        <h1 class="text-2xl font-bold text-white">Tambah User Baru</h1>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-md">
        @csrf
        
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-300">Nama Lengkap</label>
            <input type="text" name="name" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-300">Alamat Email</label>
            <input type="email" name="email" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-300">Password Baru</label>
            <input type="password" name="password" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required minlength="8">
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-300">Role / Hak Akses</label>
            <select name="role" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="Customer">Customer</option>
                <option value="Staff">Staff</option>
                <option value="Admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-sm px-5 py-2.5 text-center shadow">
            Simpan User Baru
        </button>
    </form>
</div>
@endsection