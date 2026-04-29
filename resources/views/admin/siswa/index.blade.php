@extends('admin.layouts.main')

@section('content')
{{-- Library SweetAlert2 untuk konfirmasi hapus yang mewah --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Data <span class="text-indigo-600">Siswa</span></h1>
                <p class="text-slate-500 font-medium italic">Manajemen profil anak & peserta terapi aktif.</p>
            </div>
            <a href="{{ route('siswa.create') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-xs uppercase tracking-widest shadow-xl shadow-indigo-200 transition-all active:scale-95 flex items-center gap-3 justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Siswa
            </a>
        </div>

        {{-- Filter & Search --}}
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm mb-8">
            <form action="{{ route('siswa.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIS..." class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-sm focus:ring-2 focus:ring-indigo-500 font-medium">
                </div>
                <select name="jk" class="bg-slate-50 border-none rounded-xl px-5 py-3 text-sm focus:ring-2 focus:ring-indigo-500 font-medium text-slate-600 cursor-pointer">
                    <option value="">Semua Gender</option>
                    <option value="L" {{ request('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                <select name="ta" class="bg-slate-50 border-none rounded-xl px-5 py-3 text-sm focus:ring-2 focus:ring-indigo-500 font-medium text-slate-600 cursor-pointer">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta->id }}" {{ request('ta') == $ta->id ? 'selected' : '' }}>{{ $ta->rentang_tahun }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg">Filter Data</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Siswa</th>
                            <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Wali Murid</th>
                            <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Gender / Usia</th>
                            <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Domisili</th>
                            <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kebutuhan Khusus</th>
                            <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($siswa as $s)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg shadow-indigo-100 group-hover:scale-110 transition-transform">
                                        {{ substr($s->nama_siswa, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-base">{{ $s->nama_siswa }}</p>
                                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">NIS: {{ $s->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 font-bold text-slate-600 text-sm italic">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                    {{ $s->orangtua->user->name ?? 'Tidak Ada Wali' }}
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $s->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-600' : 'bg-rose-100 text-rose-600' }}">
                                        {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-400">{{ \Carbon\Carbon::parse($s->tanggal_lahir)->age }} Tahun</span>
                                </div>
                            </td>
                            <td class="p-6">
                                <p class="text-sm font-bold text-slate-700 leading-none">{{ $s->kelurahan }}</p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase font-black">{{ $s->kabupaten_kota }}</p>
                            </td>
                            <td class="p-6">
                                <div class="max-w-[150px] overflow-hidden text-ellipsis">
                                    <span class="text-[11px] font-black text-indigo-700 bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-100 block truncate">
                                        {{ $s->kebutuhan_khusus ?? 'Normal' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Lihat --}}
                                    <a href="{{ route('siswa.show', $s->id) }}" class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-600 hover:bg-indigo-50 rounded-xl transition-all shadow-sm" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('siswa.edit', $s->id) }}" class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-amber-500 hover:border-amber-500 hover:bg-amber-50 rounded-xl transition-all shadow-sm" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    {{-- Hapus --}}
                                    <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit"
            onclick="return confirm('Yakin ingin menghapus data siswa: {{ $s->nama_siswa }}?')"
            class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-600 hover:bg-rose-50 rounded-xl transition-all shadow-sm"
            title="Hapus">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
    </button>
</form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold tracking-widest uppercase text-xs">Data Siswa Tidak Ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-8 bg-slate-50/50 border-t border-slate-100">
                {{ $siswa->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif

@endsection
