@extends('admin.layouts.main')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10" x-data="{ tab: 'admin' }">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Manajemen <span class="text-indigo-600">User</span></h1>
                <p class="text-slate-500 font-medium mt-1">Kelola akses Admin, Guru Terapis, dan Orang Tua.</p>
            </div>

            <a href="{{ route('users.create') }}" class="flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-200 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah User Baru
            </a>
        </div>

        {{-- Navigasi Tab --}}
        <div class="flex gap-2 p-1.5 bg-slate-200/50 rounded-[2rem] mb-8 w-fit">
            <button @click="tab = 'admin'" :class="tab === 'admin' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500'" class="px-8 py-3 rounded-[1.5rem] text-sm font-black transition-all uppercase tracking-wider">Admin</button>
            <button @click="tab = 'guru'" :class="tab === 'guru' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500'" class="px-8 py-3 rounded-[1.5rem] text-sm font-black transition-all uppercase tracking-wider">Guru Terapis</button>
            <button @click="tab = 'orangtua'" :class="tab === 'orangtua' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500'" class="px-8 py-3 rounded-[1.5rem] text-sm font-black transition-all uppercase tracking-wider">Orang Tua</button>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">User</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Username & Email</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach(['admin' => $admins, 'guru' => $gurus, 'orangtua' => $ortus] as $role => $list)
                        @foreach($list as $user)
                        <tr x-show="tab === '{{ $role }}'" x-transition class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xs uppercase">{{ substr($user->name, 0, 2) }}</div>
                                    <span class="text-sm font-black text-slate-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">{{ $user->username }}</span>
                                    <span class="text-[11px] font-medium text-slate-400 italic">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right flex justify-end gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-200 rounded-xl transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 rounded-xl transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
