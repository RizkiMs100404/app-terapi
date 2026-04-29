<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Orangtua;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OrangtuaController extends Controller
{
    /**
     * Display a listing of the resource with Search & Filter
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $filterTahun = $request->get('tahun_ajaran');

        $dataOrangtua = Orangtua::with(['user', 'tahunAjaran'])
            // Search Logic
            ->when($search, function($query) use ($search) {
                $query->where('nama_ibu', 'like', "%$search%")
                      ->orWhere('nomor_hp_aktif', 'like', "%$search%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%")
                            ->orWhere('username', 'like', "%$search%");
                      });
            })
            // Filter Logic
            ->when($filterTahun, function($query) use ($filterTahun) {
                $query->where('id_tahun_ajaran', $filterTahun);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $listTahunAjaran = TahunAjaran::all();

        return view('admin.orangtua.index', compact('dataOrangtua', 'listTahunAjaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // 1. Buat instance kosong untuk Orangtua
    $orangtua = new Orangtua();

    // 2. Karena di View kamu panggil $orangtua->user->name,
    // kita harus pasangkan instance User kosong juga agar tidak error 'Attempt to read property on null'
    $orangtua->setRelation('user', new User());

    $tahunAjaran = TahunAjaran::where('status_aktif', 1)->get();

    // Sekarang variabel $orangtua sudah ada (meskipun kosong)
    return view('admin.orangtua.create', compact('tahunAjaran', 'orangtua'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => 'required|string|max:50|unique:users,username',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:8',
            'id_tahun_ajaran' => 'required|exists:tahun_ajaran,id',
            'nama_ibu'        => 'required|string|max:255',
            'nomor_hp_aktif'  => 'required|numeric',
            'pekerjaan'       => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create User Account
            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'orangtua',
            ]);

            // 2. Create Profil Orangtua
            $user->profilOrangtua()->create([
                'id_tahun_ajaran' => $request->id_tahun_ajaran,
                'nama_ibu'        => $request->nama_ibu,
                'nomor_hp_aktif'  => $request->nomor_hp_aktif,
                'pekerjaan'       => $request->pekerjaan,
            ]);

            DB::commit();
            return redirect()->route('orangtua.index')->with('success', 'Data Orang Tua & Akun berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource (Detail).
     */
    public function show($id)
    {
        // Load orangtua beserta user dan daftar anak (siswa)
        $orangtua = Orangtua::with(['user', 'tahunAjaran', 'anak'])->findOrFail($id);
        return view('admin.orangtua.show', compact('orangtua'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $orangtua = Orangtua::with('user')->findOrFail($id);
        $tahunAjaran = TahunAjaran::all();
        return view('admin.orangtua.edit', compact('orangtua', 'tahunAjaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $orangtua = Orangtua::findOrFail($id);
        $user = $orangtua->user;

        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => ['required', Rule::unique('users')->ignore($user->id)],
            'email'           => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'        => 'nullable|min:8',
            'id_tahun_ajaran' => 'required',
            'nama_ibu'        => 'required',
            'nomor_hp_aktif'  => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Update User
            $userData = [
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            // Update Profil Orangtua
            $orangtua->update([
                'id_tahun_ajaran' => $request->id_tahun_ajaran,
                'nama_ibu'        => $request->nama_ibu,
                'nomor_hp_aktif'  => $request->nomor_hp_aktif,
                'pekerjaan'       => $request->pekerjaan,
            ]);

            DB::commit();
            return redirect()->route('orangtua.index')->with('success', 'Data Orang Tua berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orangtua = Orangtua::findOrFail($id);

        DB::beginTransaction();
        try {
            // Hapus User-nya, maka Profil Orangtua otomatis ikut (jika pakai cascade)
            // atau hapus manual jika tidak cascade:
            $user = $orangtua->user;
            $orangtua->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('orangtua.index')->with('success', 'Data Orang Tua telah dihapus dari sistem.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
