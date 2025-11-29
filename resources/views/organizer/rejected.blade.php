@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="bg-slate-800 p-8 rounded-2xl shadow-2xl text-center max-w-md border border-red-900">
        <div class="text-6xl mb-4">❌</div>
        <h2 class="text-2xl font-bold text-red-500 mb-2">Pengajuan Ditolak</h2>
        <p class="text-slate-400 mb-6">
            Mohon maaf, pengajuan akun Organizer Anda tidak memenuhi kriteria kami saat ini.
        </p>

        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Yakin hapus akun?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-900 font-medium rounded-lg text-sm px-5 py-2.5">
                Hapus Akun Saya
            </button>
        </form>
    </div>
</div>
@endsection