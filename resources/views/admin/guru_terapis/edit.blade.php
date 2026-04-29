@extends('admin.layouts.main')

@section('content')
{{-- Library SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen p-6 lg:p-10 bg-[#F8FAFC]">
    <div class="max-w-6xl mx-auto">
        {{-- Alert Error jika validasi gagal --}}
        @if(session('error'))
            <script>
                Swal.fire({ icon: 'error', title: 'Oops...', text: "{{ session('error') }}", confirmButtonColor: '#4f46e5' });
            </script>
        @endif

        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10">
            <a href="{{ route('guru-terapis.index') }}" class="p-3 bg-white border border-indigo-100 rounded-2xl shadow-sm hover:bg-indigo-600 hover:text-white transition-all duration-300 group">
                <svg class="w-5 h-5 text-indigo-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Data <span class="text-indigo-600">Guru Terapis</span></h1>
                <p class="text-slate-600 font-semibold italic">Perbarui informasi tenaga ahli: <span class="text-indigo-600"> {{ $guru->user->name }}</span></p>
            </div>
        </div>

        <form action="{{ route('guru-terapis.update', $guru->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Sisi Kiri: Biodata --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="group bg-white p-8 rounded-[2.5rem] border border-indigo-50 shadow-xl shadow-indigo-900/5 relative overflow-hidden transition-all duration-500 hover:shadow-indigo-900/10">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/5 rounded-full -mr-16 -mt-16 transition-all duration-700 group-hover:scale-[3] group-hover:bg-indigo-600/10"></div>

                        <div class="flex items-center gap-3 mb-8 relative z-10">
                            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Profil Terapis</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $guru->user->name) }}" required
                                    class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all outline-none font-medium text-slate-700">
                                @error('name') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">NIP</label>
                                <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" required
                                    class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all outline-none font-medium text-slate-700">
                                @error('nip') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                    <option value="L" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Nomor HP</label>
                                <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $guru->nomor_hp) }}" required
                                    class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all outline-none font-medium text-slate-700">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Status Kerja</label>
                                <select name="status_kerja" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                    <option value="Aktif" {{ old('status_kerja', $guru->status_kerja) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Non-Aktif" {{ old('status_kerja', $guru->status_kerja) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Tahun Ajaran</label>
                                <select name="id_tahun_ajaran" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" {{ old('id_tahun_ajaran', $guru->id_tahun_ajaran) == $ta->id ? 'selected' : '' }}>{{ $ta->rentang_tahun }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2 space-y-3 mt-4">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Update Bidang Keahlian</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($pilihanKeahlian as $ahli)
                                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-indigo-200 transition-all cursor-pointer group">
                                        <input type="checkbox" name="keahlian_terapi[]" value="{{ $ahli }}"
                                            {{ in_array($ahli, old('keahlian_terapi', $guru->keahlian_terapi ?? [])) ? 'checked' : '' }}
                                            class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $ahli }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('keahlian_terapi') <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Akun & Tombol --}}
                <div class="space-y-8">
                    <div class="group bg-indigo-700 p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-900/20 text-white relative overflow-hidden transition-all duration-500 hover:bg-indigo-800">
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full transition-all duration-700 group-hover:scale-150"></div>

                        <h3 class="text-lg font-bold mb-8 text-indigo-200 flex items-center gap-2 relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Akses Kredensial
                        </h3>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] block mb-2 ml-1">Username</label>
                                <input type="text" name="username" value="{{ old('username', $guru->user->username) }}" required
                                    class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white placeholder-indigo-300 focus:bg-white/20 outline-none transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] block mb-2 ml-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $guru->user->email) }}" required
                                    class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white placeholder-indigo-300 focus:bg-white/20 outline-none transition-all">
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] block mb-2 ml-1">Ganti Password (Opsional)</label>
                                <div class="relative group/pass">
                                    <input type="password" name="password" id="passwordField" minlength="8"
                                        class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white placeholder-indigo-300 focus:bg-white/20 outline-none transition-all pr-12" placeholder="••••••••">

                                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-indigo-300 hover:text-white transition-colors">
                                        <svg id="eyeClosed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L1.39 1.39m7.89 7.89l3.54 3.54m-2.83-2.83l1.25 1.25M21 21l-8.5-8.5M17.272 17.272l2.693-2.693A9.965 9.965 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.226-3.6.633L5.633 3.367"></path></svg>
                                        <svg id="eyeOpen" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                                <p class="text-[10px] text-indigo-300 mt-2 ml-1 flex items-center gap-1 font-bold italic">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    Isi jika ingin ganti, min. 8 karakter
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border border-indigo-50 shadow-xl shadow-indigo-900/5 space-y-3">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-emerald-200 transition-all active:scale-95 uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('guru-terapis.index') }}" class="w-full bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 font-black py-4 rounded-2xl transition-all flex items-center justify-center uppercase tracking-widest text-[10px]">
                            Batal & Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('passwordField');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        } else {
            passwordField.type = 'password';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        }
    }
</script>
@endsection
