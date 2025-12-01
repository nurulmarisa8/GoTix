@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-white">Kelola Pengguna (Manage Users)</h2>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-slate-700">
    <table class="w-full text-sm text-left text-slate-300">
        {{-- Header Tabel --}}
        <thead class="text-xs text-slate-400 uppercase bg-slate-800">
            <tr>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Role</th>
                <th scope="col" class="px-6 py-3">Status Organizer</th>
                <th scope="col" class="px-6 py-3 text-center">Action</th>
            </tr>
        </thead>
        
        {{-- Body Tabel --}}
        <tbody>
            @foreach($users as $user)
            <tr class="bg-slate-900 border-b border-slate-700 hover:bg-slate-800 transition">
                
                {{-- Kolom 1: Nama --}}
                <td class="px-6 py-4 font-medium text-white">
                    {{ $user->name }}
                    @if(Auth::id() === $user->id)
                        <span class="ml-2 text-xs text-purple-400">(Anda)</span>
                    @endif
                </td>

                {{-- Kolom 2: Email --}}
                <td class="px-6 py-4">
                    {{ $user->email }}
                </td>

                {{-- Kolom 3: Role (Badge) --}}
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-bold border border-opacity-30 
                        {{ $user->role == 'admin' ? 'bg-red-900 text-red-300 border-red-500' : 
                          ($user->role == 'organizer' ? 'bg-purple-900 text-purple-300 border-purple-500' : 'bg-blue-900 text-blue-300 border-blue-500') }}">
                        {{ strtoupper($user->role) }}
                    </span>
                </td>

                {{-- Kolom 4: Status Organizer --}}
                <td class="px-6 py-4">
                    @if($user->role == 'organizer')
                        @if($user->organizer_status == 'pending')
                            <span class="text-yellow-400 font-bold flex items-center gap-2 bg-yellow-400/10 px-2 py-1 rounded w-fit">
                                <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span> Pending Review
                            </span>
                        @elseif($user->organizer_status == 'approved')
                            <span class="text-green-400 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Active
                            </span>
                        @elseif($user->organizer_status == 'rejected')
                            <span class="text-red-400 font-medium bg-red-400/10 px-2 py-1 rounded">Rejected</span>
                        @endif
                    @else
                        <span class="text-slate-600 text-xs">-</span>
                    @endif
                </td>

                {{-- Kolom 5: Action (Tombol ACC/Reject/Edit/Delete) --}}
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        
                        {{-- A. TOMBOL APPROVE/REJECT (Khusus Organizer Pending) --}}
                        @if($user->role == 'organizer' && $user->organizer_status == 'pending')
                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-bold transition shadow-lg" title="Approve">
                                    ✓
                                </button>
                            </form>

                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-bold transition shadow-lg" title="Reject">
                                    ✕
                                </button>
                            </form>
                        @endif

                        {{-- B. TOMBOL EDIT (Semua User) --}}
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-600 hover:bg-yellow-500 text-white px-2 py-1.5 rounded text-xs transition" title="Edit User">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>

                        {{-- C. TOMBOL DELETE (Kecuali Diri Sendiri) --}}
                        @if(Auth::id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini? Data terkait akan hilang permanen!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-slate-700 hover:bg-red-600 text-white px-2 py-1.5 rounded text-xs transition" title="Hapus User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        @endif

                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection