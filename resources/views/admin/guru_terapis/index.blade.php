@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Data <span class="text-indigo-600">Guru Terapis</span></h1>
                <p class="text-slate-500 font-medium mt-1">Manajemen tenaga ahli dan spesialis pelayanan terapi SLB.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('guru-terapis.create') }}" class="flex items-center gap-3 px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-xl shadow-indigo-200 transition-all active:scale-95 group">
                    <svg class="w-5 h-5 text-indigo-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-bold tracking-wide text-sm">TAMBAH GURU</span>
                </a>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm mb-8">
            <form action="{{ route('guru-terapis.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari NIP, nama guru, atau keahlian..."
                        class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-50 transition-all outline-none">
                </div>

                <div class="flex flex-wrap md:flex-nowrap gap-4">
                    <select name="status_kerja" class="px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-50 outline-none">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status_kerja') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ request('status_kerja') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>

                    <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all">
                        FILTER
                    </button>

                    @if(request()->anyFilled(['search', 'status_kerja']))
                        <a href="{{ route('guru-terapis.index') }}" class="px-6 py-4 bg-red-50 text-red-600 rounded-2xl font-bold text-sm hover:bg-red-100 transition-all flex items-center justify-center">
                            RESET
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table Section --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Profil Guru</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">NIP & Kontak</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Keahlian Terapi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($dataGuru as $guru)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-md group-hover:scale-110 transition-transform">
                                        {{ substr($guru->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-none mb-1">{{ $guru->user->name }}</p>
                                        <p class="text-xs text-slate-400 font-medium italic">
                                            {{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-slate-700">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                        <span class="text-sm font-bold tracking-tight">{{ $guru->nip }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span class="text-xs font-medium">{{ $guru->nomor_hp }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-4 py-1.5 {{ $guru->status_kerja == 'Aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} text-[10px] font-black uppercase tracking-widest rounded-full border {{ $guru->status_kerja == 'Aktif' ? 'border-emerald-100' : 'border-red-100' }}">
                                    {{ $guru->status_kerja }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-wrap gap-1.5">
                                    @php
                                        $skills = is_array($guru->keahlian_terapi) ? $guru->keahlian_terapi : json_decode($guru->keahlian_terapi, true) ?? [];
                                    @endphp
                                    @forelse($skills as $skill)
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[9px] font-black uppercase rounded-lg border border-slate-200 shadow-sm">
                                            {{ $skill }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] font-bold text-slate-300 italic text-center w-full">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('guru-terapis.show', $guru->id) }}" class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('guru-terapis.edit', $guru->id) }}" class="p-2.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('guru-terapis.destroy', $guru->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data guru terapis dan akun loginnya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">Belum Ada Tenaga Ahli</h3>
                                <p class="text-slate-500 mt-2">Data guru terapis yang Anda cari tidak ditemukan atau masih kosong.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $dataGuru->links() }}
        </div>
    </div>
</div>
@endsection
