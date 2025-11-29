@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Kelola Acara (Events)</h2>
    
    {{-- PERBAIKAN: Gunakan admin.events.create --}}
    <a href="{{ route('admin.events.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg shadow-purple-500/30">
        + Tambah Event
    </a>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-slate-300">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800">
            <tr>
                <th class="px-6 py-3">Poster</th>
                <th class="px-6 py-3">Nama Acara</th>
                <th class="px-6 py-3">Jadwal</th>
                <th class="px-6 py-3">Lokasi</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr class="bg-slate-900 border-b border-slate-700 hover:bg-slate-800 transition">
                <td class="px-6 py-4">
                    <img src="{{ $event->image ? asset('storage/'.$event->image) : 'https://placehold.co/100' }}" class="w-16 h-16 object-cover rounded-lg border border-slate-600" alt="Poster">
                </td>
                <td class="px-6 py-4 font-bold text-white">
                    {{ $event->name }}
                    <span class="block text-xs text-purple-400 font-normal mt-1">{{ $event->category }}</span>
                </td>
                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}<br>
                    <span class="text-xs text-slate-500">{{ $event->event_time }}</span>
                </td>
                <td class="px-6 py-4">{{ $event->location }}</td>
                <td class="px-6 py-4 text-center space-y-2">
                    {{-- PERBAIKAN: admin.events.tickets.create --}}
                    <a href="{{ route('admin.events.tickets.create', $event->id) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                        + Tiket
                    </a>

                    {{-- PERBAIKAN: admin.events.edit --}}
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-xs">
                        Edit
                    </a>

                    {{-- PERBAIKAN: admin.events.destroy --}}
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin hapus event ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="block w-full bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection