@extends('layouts.dashboard')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Edit Pengguna</h2>
        <a href="{{ route('admin.users') }}" class="text-slate-400 hover:text-white">Batal</a>
    </div>

    <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Email Address</label>
                <input type="email" name="email" value="{{ $user->email }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-slate-300">Role (Peran)</label>
                <select name="role" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pengunjung)</option>
                    <option value="organizer" {{ $user->role == 'organizer' ? 'selected' : '' }}>Event Organizer</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                <p class="mt-2 text-xs text-slate-500">
                    *Jika diubah menjadi Organizer, status otomatis menjadi "Approved".
                </p>
            </div>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection