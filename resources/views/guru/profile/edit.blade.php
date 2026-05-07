@extends('guru.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10 dark:bg-gray-950">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Pengaturan <span class="text-emerald-600">Profil</span></h1>
                <p class="text-slate-500 font-semibold italic mt-1 uppercase text-[10px] tracking-widest">Kelola informasi publik dan keamanan akun Anda</p>
            </div>
            <div class="px-6 py-3 bg-white dark:bg-gray-900 border border-emerald-100 dark:border-emerald-800 rounded-2xl shadow-sm text-emerald-600 font-black text-xs uppercase tracking-widest">
                Level Akses: {{ strtoupper(auth()->user()->role) }}
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Sisi Kiri: Biodata & Foto --}}
            <div class="lg:col-span-2">
                {{-- PENTING: Tambahkan enctype="multipart/form-data" --}}
                <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-900 p-10 rounded-[3rem] border border-emerald-50 dark:border-emerald-900/30 shadow-xl shadow-emerald-900/5 relative overflow-hidden transition-all duration-500 hover:shadow-emerald-900/10">
                    @csrf @method('PATCH')

                    {{-- Section Upload Foto & Preview --}}
                    <div class="flex flex-col md:flex-row items-center gap-8 mb-12 p-8 bg-emerald-50/20 dark:bg-emerald-900/10 rounded-[2.5rem] border border-dashed border-emerald-200 dark:border-emerald-800">
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-[2rem] overflow-hidden ring-4 ring-white dark:ring-gray-800 shadow-2xl shadow-emerald-900/20">
                                <img id="preview-foto" 
                                     src="{{ $user->guruTerapis && $user->guruTerapis->foto ? asset('storage/foto_guru/' . $user->guruTerapis->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=10b981&color=fff&bold=true' }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                                     alt="Profile Preview">
                            </div>
                            {{-- Button Overlay --}}
                            <label for="foto" class="absolute inset-0 flex items-center justify-center bg-emerald-600/60 opacity-0 group-hover:opacity-100 transition-all duration-300 cursor-pointer rounded-[2rem] backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke-width="2.5"/><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2.5"/></svg>
                            </label>
                            <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </div>
                        
                        <div class="text-center md:text-left">
                            <h4 class="text-lg font-black text-slate-800 dark:text-white leading-tight">Foto Profil Anda</h4>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1 mb-4">Klik gambar untuk mengganti (JPG, PNG - Max 2MB)</p>
                            @error('foto') <p class="text-[10px] text-rose-500 font-bold uppercase mb-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-14 h-14 bg-emerald-600 rounded-[1.2rem] flex items-center justify-center text-white shadow-xl shadow-emerald-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white">Informasi Dasar</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-emerald-900 dark:text-emerald-400 uppercase tracking-widest ml-1">Nama Lengkap Guru</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-emerald-50/30 dark:bg-emerald-900/10 border-2 @error('name') border-rose-500 @else border-transparent @enderror rounded-[1.5rem] px-6 py-4 focus:border-emerald-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-4 focus:ring-emerald-100 dark:focus:ring-emerald-900/20 transition-all outline-none font-bold text-slate-700 dark:text-gray-200">
                            @error('name') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-emerald-900 dark:text-emerald-400 uppercase tracking-widest ml-1">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                    class="w-full bg-emerald-50/30 dark:bg-emerald-900/10 border-2 @error('username') border-rose-500 @else border-transparent @enderror rounded-[1.5rem] px-6 py-4 focus:border-emerald-500 focus:bg-white dark:focus:bg-gray-800 transition-all outline-none font-bold text-slate-700 dark:text-gray-200">
                                @error('username') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-emerald-900 dark:text-emerald-400 uppercase tracking-widest ml-1">Nomor HP / WhatsApp</label>
                                <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $user->guruTerapis->nomor_hp ?? '') }}"
                                    class="w-full bg-emerald-50/30 dark:bg-emerald-900/10 border-2 @error('nomor_hp') border-rose-500 @else border-transparent @enderror rounded-[1.5rem] px-6 py-4 focus:border-emerald-500 focus:bg-white dark:focus:bg-gray-800 transition-all outline-none font-bold text-slate-700 dark:text-gray-200" placeholder="08xxxxxxxxxx">
                                @error('nomor_hp') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-black text-emerald-900 dark:text-emerald-400 uppercase tracking-widest ml-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-emerald-50/30 dark:bg-emerald-900/10 border-2 @error('email') border-rose-500 @else border-transparent @enderror rounded-[1.5rem] px-6 py-4 focus:border-emerald-500 focus:bg-white dark:focus:bg-gray-800 transition-all outline-none font-bold text-slate-700 dark:text-gray-200">
                            @error('email') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-50 dark:border-gray-800 flex justify-end">
                        <button type="submit" class="group flex items-center gap-3 px-10 py-5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 dark:shadow-none transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Simpan Perubahan
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Sisi Kanan: Keamanan --}}
            <div class="space-y-8">
                <form action="{{ route('guru.profile.password') }}" method="POST" class="group bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-emerald-900/20 text-white relative overflow-hidden transition-all duration-500">
                    @csrf @method('PUT')

                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-600/10 rounded-full transition-all duration-700 group-hover:scale-150"></div>

                    <h3 class="text-lg font-black mb-8 text-emerald-400 flex items-center gap-3 relative z-10 uppercase tracking-widest">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Keamanan
                    </h3>

                    <div class="space-y-6 relative z-10">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block ml-1">Password Sekarang</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="cur_pass" required
                                    class="w-full bg-white/5 border @error('current_password') border-rose-500/50 bg-rose-500/5 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white placeholder-slate-600 focus:bg-white/10 focus:ring-4 focus:ring-emerald-500/20 outline-none transition-all pr-12">
                                <button type="button" onclick="eye('cur_pass', 'cur_o', 'cur_c')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition-colors">
                                    <svg id="cur_o" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg id="cur_c" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L1.39 1.39m7.89 7.89l3.54 3.54m-2.83-2.83l1.25 1.25M21 21l-8.5-8.5M17.272 17.272l2.693-2.693A9.965 9.965 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.226-3.6.633L5.633 3.367"></path></svg>
                                </button>
                            </div>
                            @error('current_password') <p class="text-[10px] text-rose-400 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <hr class="border-white/5">

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block ml-1">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="new_pass" required
                                    class="w-full bg-white/5 border @error('password') border-rose-500/50 bg-rose-500/5 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white placeholder-slate-600 focus:bg-white/10 focus:ring-4 focus:ring-emerald-500/20 outline-none transition-all pr-12">
                                <button type="button" onclick="eye('new_pass', 'new_o', 'new_c')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition-colors">
                                    <svg id="new_o" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg id="new_c" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L1.39 1.39m7.89 7.89l3.54 3.54m-2.83-2.83l1.25 1.25M21 21l-8.5-8.5M17.272 17.272l2.693-2.693A9.965 9.965 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.226-3.6.633L5.633 3.367"/></svg>
                                </button>
                            </div>
                            @error('password') <p class="text-[10px] text-rose-400 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block ml-1">Konfirmasi Ulang</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white focus:bg-white/10 outline-none transition-all placeholder-slate-600" placeholder="••••••••">
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-emerald-500 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // PREVIEW FOTO PROFIL
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-foto');
                preview.src = e.target.result;
                // Animasi dikit pas ganti foto
                preview.classList.add('scale-110');
                setTimeout(() => preview.classList.remove('scale-110'), 500);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // SWEETALERT SUCCESS
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: "{{ session('success') }}",
            background: '#0F172A',
            color: '#ffffff',
            showConfirmButton: false,
            timer: 3000,
            customClass: {
                popup: 'rounded-[2rem] border border-white/10 shadow-2xl'
            }
        });
    @endif

    // TOGGLE EYE PASSWORD
    function eye(inputId, openId, closedId) {
        const input = document.getElementById(inputId);
        const open = document.getElementById(openId);
        const closed = document.getElementById(closedId);

        if (input.type === 'password') {
            input.type = 'text';
            open.classList.remove('hidden');
            closed.classList.add('hidden');
        } else {
            input.type = 'password';
            open.classList.add('hidden');
            closed.classList.remove('hidden');
        }
    }
</script>
@endsection