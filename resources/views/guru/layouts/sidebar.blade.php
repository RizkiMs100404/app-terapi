<aside id="sidebar" class="fixed top-0 left-0 z-30 flex flex-col flex-shrink-0 hidden w-72 h-full pt-20 duration-300 lg:flex transition-all border-r border-gray-100 dark:bg-gray-900 dark:border-gray-800" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 bg-white dark:bg-gray-900">

        <div class="flex flex-col flex-1 pt-2 pb-4 overflow-y-auto px-4 custom-scrollbar">
            <div class="flex-1 space-y-6">

                {{-- KATEGORI: UTAMA --}}
                <div>
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Menu Utama</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/guru/dashboard') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/dashboard*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <svg class="w-5 h-5 transition-colors {{ request()->is('guru/dashboard*') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="ml-3">Dashboard Terapis</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- KATEGORI: PELAYANAN --}}
                <div class="pt-2">
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Pelayanan Terapi</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ route('guru.jadwal.index') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/jadwal*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600' }}">
                                <i class="fa-solid fa-calendar-day w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('guru/jadwal*') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}"></i>
                                <span class="ml-3">Jadwal Hari Ini</span>
                            </a>
                        </li>

                        <li>
    {{-- Perbaikan: Menu ini hanya menyala jika di create atau edit, tapi TIDAK menyala jika di history --}}
    <a href="javascript:void(0)" onclick="confirmInputHasil()"
        class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group
        {{ (request()->is('guru/rekam-terapi*') && !request()->is('guru/rekam-terapi/history*')) ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600' }}">

        <i class="fa-solid fa-file-signature w-5 h-5 flex items-center justify-center transition-colors
        {{ (request()->is('guru/rekam-terapi*') && !request()->is('guru/rekam-terapi/history*')) ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}"></i>

        <span class="ml-3">Input Hasil Sesi</span>
    </a>
</li>

                        <li>
    <a href="{{ url('/guru/rekam-terapi/history') }}"
       class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/rekam-terapi/history*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600' }}">
        <i class="fa-solid fa-clock-rotate-left w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('guru/rekam-terapi/history*') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}"></i>
        <span class="ml-3">Riwayat Terapi</span>
    </a>
</li>
                    </ul>
                </div>

                {{-- KATEGORI: MANAJEMEN SISWA --}}
                <div class="pt-2">
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Grafik Perkembangan</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/guru/siswa-terapi') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/siswa-terapi*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600' }}">
                                <i class="fa-solid fa-user-graduate w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('guru/siswa-terapi*') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}"></i>
                                <span class="ml-3">Siswa Terapi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

{{-- Pastikan SweetAlert2 ter-load sebelum script ini --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmInputHasil() {
        if (typeof Swal === 'undefined') {
            window.location.href = "{{ route('guru.jadwal.index') }}";
            return;
        }

        Swal.fire({
            title: 'Pilih Jadwal Dulu',
            text: "Untuk input hasil terapi, silakan klik tombol 'Input Terapi' pada daftar jadwal siswa!",
            icon: 'info',
            showCancelButton: true,
            // Matikan styling bawaan SWAL biar Tailwind kita masuk 100%
            buttonsStyling: false,
            confirmButtonText: 'Lihat Jadwal',
            cancelButtonText: 'Nanti Dulu',
            background: '#ffffff',
            borderRadius: '2rem',
            customClass: {
                title: 'font-black text-emerald-900',
                popup: 'rounded-[2.5rem] border-4 border-emerald-50',
                // Paksa teks warna putih (!text-white) dan hilangkan outline focus
                confirmButton: 'bg-emerald-600 !text-white px-8 py-3 rounded-full font-black text-sm mx-2 shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all outline-none',
                cancelButton: 'bg-gray-500 !text-white px-8 py-3 rounded-full font-black text-sm mx-2 hover:bg-gray-600 transition-all outline-none'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('guru.jadwal.index') }}";
            }
        });
    }
</script>
