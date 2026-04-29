@extends('admin.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10 bg-[#F8FAFC]">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Pengaturan <span class="text-indigo-600">Profil</span></h1>
                <p class="text-slate-500 font-semibold italic mt-1">Kelola informasi publik dan keamanan akun Anda</p>
            </div>
            <div class="px-6 py-3 bg-white border border-indigo-100 rounded-2xl shadow-sm text-indigo-600 font-black text-xs uppercase tracking-widest">
                Level Akses: {{ strtoupper(auth()->user()->role) }}
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Sisi Kiri: Biodata --}}
            <div class="lg:col-span-2">
                <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white p-10 rounded-[3rem] border border-indigo-50 shadow-xl shadow-indigo-900/5 relative overflow-hidden transition-all duration-500 hover:shadow-indigo-900/10">
                    @csrf @method('PUT')

                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-14 h-14 bg-indigo-600 rounded-[1.2rem] flex items-center justify-center text-white shadow-xl shadow-indigo-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800">Informasi Dasar</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-indigo-900 uppercase tracking-widest ml-1">Nama Lengkap Pengguna</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-indigo-50/30 border-2 @error('name') border-rose-500 @else border-transparent @enderror rounded-[1.5rem] px-6 py-4 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 transition-all outline-none font-bold text-slate-700">
                            @error('name') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-indigo-900 uppercase tracking-widest ml-1">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                    class="w-full bg-indigo-50/30 border-2 @error('username') border-rose-500 @else border-transparent @enderror rounded-[1.5rem] px-6 py-4 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700">
                                @error('username') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-indigo-900 uppercase tracking-widest ml-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full bg-indigo-50/30 border-2 @error('email') border-rose-500 @else border-transparent @enderror rounded-[1.5rem] px-6 py-4 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700">
                                @error('email') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-50 flex justify-end">
                        <button type="submit" class="group flex items-center gap-3 px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Simpan Perubahan
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Sisi Kanan: Password --}}
            <div class="space-y-8">
                <form action="{{ route('admin.profile.password') }}" method="POST" class="group bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-indigo-900/20 text-white relative overflow-hidden transition-all duration-500">
                    @csrf @method('PUT')

                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-indigo-600/10 rounded-full transition-all duration-700 group-hover:scale-150"></div>

                    <h3 class="text-lg font-black mb-8 text-indigo-400 flex items-center gap-3 relative z-10 uppercase tracking-widest">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Keamanan
                    </h3>

                    <div class="space-y-6 relative z-10">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block ml-1">Password Sekarang</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="cur_pass" required
                                    class="w-full bg-white/5 border @error('current_password') border-rose-500/50 bg-rose-500/5 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white placeholder-slate-600 focus:bg-white/10 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all pr-12">
                                <button type="button" onclick="eye('cur_pass', 'cur_o', 'cur_c')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white">
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
                                    class="w-full bg-white/5 border @error('password') border-rose-500/50 bg-rose-500/5 @else border-white/10 @enderror rounded-2xl px-5 py-4 text-white placeholder-slate-600 focus:bg-white/10 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all pr-12">
                                <button type="button" onclick="eye('new_pass', 'new_o', 'new_c')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white">
                                    <svg id="new_o" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg id="new_c" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L1.39 1.39m7.89 7.89l3.54 3.54m-2.83-2.83l1.25 1.25M21 21l-8.5-8.5M17.272 17.272l2.693-2.693A9.965 9.965 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.226-3.6.633L5.633 3.367"/></svg>
                                </button>
                            </div>
                            @error('password') <p class="text-[10px] text-rose-400 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block ml-1">Konfirmasi Ulang</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white focus:bg-white/10 outline-none transition-all" placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white font-black py-5 rounded-2xl shadow-xl hover:bg-indigo-500 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
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
