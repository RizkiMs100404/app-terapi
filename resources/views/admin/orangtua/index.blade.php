@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Data <span class="text-indigo-600">Wali Murid</span></h1>
                <p class="text-slate-500 font-medium mt-1">Manajemen akses portal orang tua dan informasi keluarga.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('orangtua.create') }}" class="flex items-center gap-3 px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-xl shadow-indigo-200 transition-all active:scale-95 group">
                    <svg class="w-5 h-5 text-indigo-200 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="font-bold tracking-wide text-sm">TAMBAH WALI</span>
                </a>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm mb-8">
            <form action="{{ route('orangtua.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama wali, nama anak, atau email..."
                        class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-4 focus:ring-indigo-50 transition-all outline-none">
                </div>

                <div class="flex flex-wrap md:flex-nowrap gap-4">
                    {{-- New: Filter Tingkat --}}
                    <select name="tingkat" class="px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-50 outline-none">
                        <option value="">Semua Tingkat</option>
                        @foreach(['SDLB', 'SMPLB', 'SMALB'] as $tkt)
                            <option value="{{ $tkt }}" {{ request('tingkat') == $tkt ? 'selected' : '' }}>{{ $tkt }}</option>
                        @endforeach
                    </select>

                    <select name="tahun_ajaran" class="px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-50 outline-none">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach($listTahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ request('tahun_ajaran') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->rentang_tahun }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all">
                        FILTER
                    </button>

                    @if(request()->anyFilled(['search', 'tahun_ajaran', 'tingkat']))
                        <a href="{{ route('orangtua.index') }}" class="px-6 py-4 bg-red-50 text-red-600 rounded-2xl font-bold text-sm hover:bg-red-100 transition-all flex items-center justify-center">
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
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Wali Murid</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Informasi Ibu</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tahun Ajaran</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Anak & Kelas</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($dataOrangtua as $ortu)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-md group-hover:scale-110 transition-transform">
                                        {{ substr($ortu->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-none mb-1">{{ $ortu->user->name }}</p>
                                        <p class="text-xs text-slate-400 font-medium">{{ $ortu->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-slate-700">
                                        <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="text-sm font-bold">{{ $ortu->nama_ibu }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span class="text-xs font-medium">{{ $ortu->nomor_hp_aktif }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest rounded-full">
                                    {{ $ortu->tahunAjaran->rentang_tahun }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col gap-3">
                                    @if($ortu->siswa->count() > 0)
                                        @foreach($ortu->siswa as $anak)
                                            <div class="flex flex-col group/child">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-400 group-hover/child:scale-150 transition-transform"></div>
                                                    <span class="text-xs font-black text-slate-700 uppercase tracking-tight">
                                                        {{ $anak->nama_siswa }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2 mt-0.5 ml-3.5">
                                                    <span class="text-[9px] font-black text-indigo-500 px-1.5 py-0.5 bg-indigo-50 rounded shadow-sm">{{ $anak->tingkat }}</span>
                                                    <span class="text-[9px] font-bold text-slate-400 italic">Kelas {{ $anak->kelas }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-[10px] font-black text-slate-300 italic uppercase tracking-widest">Belum Terhubung</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('orangtua.show', $ortu->id) }}" class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('orangtua.edit', $ortu->id) }}" class="p-2.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('orangtua.destroy', $ortu->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data orang tua dan akun loginnya?')">
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
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">Belum Ada Data</h3>
                                <p class="text-slate-500 mt-2">Data wali murid yang Anda cari tidak ditemukan atau masih kosong.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $dataOrangtua->links() }}
        </div>
    </div>
</div>
@endsection