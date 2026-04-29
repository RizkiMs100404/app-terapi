@extends('admin.layouts.main')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Tahun <span class="text-indigo-600">Akademik</span>
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-2 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-indigo-500"></span>
                Kelola periode aktif dan konfigurasi semester sistem.
            </p>
        </div>

        <a href="{{ route('tahun-ajaran.create') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 active:scale-95 group">
            <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Periode Baru
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-[2.5rem] overflow-hidden shadow-xl shadow-slate-100/50 dark:shadow-none">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-gray-800/50 text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] border-b dark:border-gray-800">
                        <th class="px-8 py-6">Rentang Tahun</th>
                        <th class="px-8 py-6">Semester</th>
                        <th class="px-8 py-6 text-center">Status Aktivasi</th>
                        <th class="px-8 py-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                    @foreach($dataTA as $ta)
                    <tr class="group hover:bg-slate-50/40 dark:hover:bg-gray-800/40 transition-all">
                        <td class="px-8 py-6">
                            <span class="text-lg font-bold text-slate-700 dark:text-slate-200 group-hover:text-indigo-600 transition-colors">
                                {{ $ta->rentang_tahun }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            @if(strtolower($ta->semester) == 'ganjil')
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100 dark:bg-rose-900/20 dark:border-rose-900/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></span>
                                    {{ $ta->semester }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 border border-indigo-100 dark:bg-indigo-900/20 dark:border-indigo-900/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-2"></span>
                                    {{ $ta->semester }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center">
                                <button onclick="toggleStatus({{ $ta->id }})"
                                    class="relative inline-flex items-center gap-3 px-5 py-2.5 rounded-2xl border transition-all duration-300 {{ $ta->status_aktif ? 'bg-emerald-50 border-emerald-200 text-emerald-700 shadow-sm shadow-emerald-100 dark:bg-emerald-900/20 dark:border-emerald-800' : 'bg-white dark:bg-gray-800 border-slate-200 dark:border-gray-700 text-slate-400 hover:border-slate-300' }}">

                                    <div class="relative flex h-2.5 w-2.5">
                                        @if($ta->status_aktif)
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        @endif
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $ta->status_aktif ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                                    </div>

                                    <span class="text-[11px] font-black uppercase tracking-[0.1em]">
                                        {{ $ta->status_aktif ? 'Sedang Aktif' : 'Non-Aktif' }}
                                    </span>
                                </button>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end items-center gap-3">
                                <a href="{{ route('tahun-ajaran.edit', $ta->id) }}"
                                   class="group/edit p-3 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-2xl transition-all"
                                   title="Edit Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('tahun-ajaran.destroy', $ta->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="group/del p-3 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-2xl transition-all"
                                            title="Hapus Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($dataTA->isEmpty())
        <div class="py-20 text-center">
            <div class="inline-flex p-6 bg-slate-50 dark:bg-gray-800 rounded-full mb-4 text-slate-300">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 00-2 2H6a2 2 0 00-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Belum Ada Data</h3>
            <p class="text-slate-500 text-sm">Klik tombol "Tambah Periode Baru" untuk memulai.</p>
        </div>
        @endif
    </div>
</div>

<script>
    function toggleStatus(id) {
        // Gunakan URL Absolut dengan window.location.origin
        const url = `${window.location.origin}/admin/tahun-ajaran/toggle/${id}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            if (!res.ok) {
                const text = await res.text();
                console.error('Server Error:', text);
                throw new Error('Gagal menghubungi server.');
            }
            return res.json();
        })
        .then(data => {
            if(data.success) {
                // Beri feedback visual sedikit sebelum reload (opsional)
                window.location.reload();
            } else {
                alert('Peringatan: ' + (data.message || 'Gagal mengubah status'));
            }
        })
        .catch(err => {
            console.error('Fetch Error:', err);
            alert('Terjadi kesalahan koneksi. Pastikan Route POST /admin/tahun-ajaran/toggle/{id} sudah benar.');
        });
    }
</script>
@endsection
