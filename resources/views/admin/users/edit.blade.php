@extends('admin.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10 bg-[#F8FAFC]">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10">
            <a href="{{ route('users.index') }}" class="p-3 bg-white border border-indigo-100 rounded-2xl shadow-sm hover:bg-indigo-600 hover:text-white transition-all duration-300 group">
                <svg class="w-5 h-5 text-indigo-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit <span class="text-indigo-600">User</span></h1>
                <p class="text-slate-600 font-semibold italic">Memperbarui data akun pengguna</p>
            </div>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Sisi Kiri --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="group bg-white p-8 rounded-[2.5rem] border border-indigo-50 shadow-xl shadow-indigo-900/5 relative overflow-hidden transition-all duration-500">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/5 rounded-full -mr-16 -mt-16"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name }}" required
                                    class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-medium text-slate-700">
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Hak Akses (Role)</label>
                                <div class="relative">
                                    <select name="role" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                        <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru Terapis</option>
                                        <option value="orangtua" {{ $user->role == 'orangtua' ? 'selected' : '' }}>Orang Tua / Wali</option>
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan --}}
                <div class="space-y-8">
                    <div class="group bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-900/20 text-white relative overflow-hidden transition-all duration-500">
                        <div class="space-y-6 relative z-10">
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2 ml-1">Username</label>
                                <input type="text" name="username" value="{{ $user->username }}" required
                                    class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white outline-none transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2 ml-1">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" required
                                    class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2 ml-1 italic">Ganti Password (Opsional)</label>
                                <div class="relative">
                                    <input type="password" name="password" id="passEdit" minlength="8"
                                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder-slate-500 outline-none pr-12" placeholder="••••••••">
                                    <button type="button" onclick="togglePassword('passEdit', 'eO', 'eC')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition-colors">
                                        <svg id="eO" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <svg id="eC" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L1.39 1.39m7.89 7.89l3.54 3.54m-2.83-2.83l1.25 1.25M21 21l-8.5-8.5M17.272 17.272l2.693-2.693A9.965 9.965 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7-1.274 0-2.483.226-3.6.633L5.633 3.367"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] border border-indigo-50 shadow-xl shadow-indigo-900/5">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl shadow-xl transition-all active:scale-95 uppercase tracking-widest text-xs">
                            Perbarui User
                        </button>
                        <a href="{{ route('users.index') }}" class="block text-center mt-4 text-[10px] font-bold text-slate-400 hover:text-red-500 tracking-widest uppercase transition-colors">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(fieldId, openId, closedId) {
        const field = document.getElementById(fieldId);
        const open = document.getElementById(openId);
        const closed = document.getElementById(closedId);

        if (field.type === 'password') {
            field.type = 'text';
            open.classList.remove('hidden');
            closed.classList.add('hidden');
        } else {
            field.type = 'password';
            open.classList.add('hidden');
            closed.classList.remove('hidden');
        }
    }
</script>
@endsection
