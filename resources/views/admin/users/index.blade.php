@extends('layouts.dashboard')

@section('content')
<h2 class="text-2xl font-bold mb-6">Manage Users</h2>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                </td>

                {{-- Kolom 2: Email --}}
                <td class="px-6 py-4">
                    {{ $user->email }}
                </td>

                {{-- Kolom 3: Role (Badge) --}}
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-bold 
                        {{ $user->role == 'admin' ? 'bg-red-900 text-red-300' : 
                          ($user->role == 'organizer' ? 'bg-purple-900 text-purple-300' : 'bg-blue-900 text-blue-300') }}">
                        {{ strtoupper($user->role) }}
                    </span>
                </td>

                {{-- Kolom 4: Status Organizer --}}
                <td class="px-6 py-4">
                    @if($user->role == 'organizer')
                        @if($user->organizer_status == 'pending')
                            <span class="text-yellow-400 font-bold flex items-center gap-1">
                                <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span> Pending Review
                            </span>
                        @elseif($user->organizer_status == 'approved')
                            <span class="text-green-400 font-medium">Active</span>
                        @elseif($user->organizer_status == 'rejected')
                            <span class="text-red-400 font-medium">Rejected</span>
                        @endif
                    @else
                        <span class="text-slate-600">-</span>
                    @endif
                </td>

                {{-- Kolom 5: Action (Tombol ACC/Reject) --}}
                <td class="px-6 py-4 text-center">
                    @if($user->role == 'organizer' && $user->organizer_status == 'pending')
                        <div class="flex items-center justify-center gap-2">
                            {{-- Tombol Approve --}}
                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold transition shadow-lg hover:shadow-green-500/50">
                                    ✓ ACC
                                </button>
                            </form>

                            {{-- Tombol Reject --}}
                            <form action="{{ route('admin.approve', $user->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold transition shadow-lg hover:shadow-red-500/50">
                                    ✕ Tolak
                                </button>
                            </form>
                        </div>
                    @elseif($user->role == 'organizer' && $user->organizer_status == 'approved')
                        <span class="text-green-500 text-xs font-bold border border-green-500/30 px-2 py-1 rounded">
                            Verified
                        </span>
                    @elseif($user->role == 'organizer' && $user->organizer_status == 'rejected')
                        <span class="text-red-500 text-xs">Ditolak</span>
                    @else
                        <span class="text-slate-600 text-xs">-</span>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection