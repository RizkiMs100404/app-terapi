<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GuruTerapis;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuruTerapisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $filterStatus = $request->get('status_kerja');
        $filterTA = $request->get('id_tahun_ajaran');

        $dataGuru = GuruTerapis::with(['user', 'tahunAjaran'])
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nip', 'like', "%$search%")
                      ->orWhere('nomor_hp', 'like', "%$search%")
                      ->orWhere('keahlian_terapi', 'like', "%$search%") 
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%$search%")
                                    ->orWhere('email', 'like', "%$search%");
                      });
                });
            })
            ->when($filterStatus, function($query) use ($filterStatus) {
                $query->where('status_kerja', $filterStatus);
            })
            ->when($filterTA, function($query) use ($filterTA) {
                $query->where('id_tahun_ajaran', $filterTA);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $dataTA = TahunAjaran::orderBy('rentang_tahun', 'desc')->get();

        return view('admin.guru_terapis.index', compact('dataGuru', 'dataTA'));
    }

    public function create()
    {
        $guru = new GuruTerapis();
        $guru->setRelation('user', new User());
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->get();
        $pilihanKeahlian = ['Wicara', 'Okupasi', 'Perilaku', 'Sensori Integrasi', 'Fisioterapi', 'Psikologi'];

        return view('admin.guru_terapis.create', compact('tahunAjaran', 'guru', 'pilihanKeahlian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => 'required|string|max:50|unique:users,username',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:8',
            'nip'             => 'required|string|unique:guru_terapis,nip',
            'id_tahun_ajaran' => 'required|exists:tahun_ajaran,id',
            'jenis_kelamin'   => 'required|in:L,P',
            'nomor_hp'        => 'required|string|max:20',
            'status_kerja'    => 'required|in:Aktif,Non-Aktif',
            'keahlian_terapi' => 'required|array|min:1',
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'keahlian_terapi.required' => 'Pilih minimal satu keahlian terapi.',
            'nip.unique' => 'NIP sudah terdaftar di sistem.'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'guru',
            ]);

            $guruData = [
                'id_tahun_ajaran' => $request->id_tahun_ajaran,
                'nip'             => $request->nip,
                'jenis_kelamin'   => $request->jenis_kelamin,
                'nomor_hp'        => $request->nomor_hp,
                'keahlian_terapi' => $request->keahlian_terapi,
                'status_kerja'    => $request->status_kerja,
            ];

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_foto = time() . "_" . $file->getClientOriginalName();
                $file->storeAs('public/foto_guru', $nama_foto);
                $guruData['foto'] = $nama_foto;
            }

            $user->guruTerapis()->create($guruData);

            DB::commit();
            return redirect()->route('guru-terapis.index')->with('success', 'Terapis baru berhasil diregistrasi!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan Detail Guru Terapis
     */
    public function show($id)
    {
        $guru = GuruTerapis::with(['user', 'tahunAjaran'])->findOrFail($id);
        
        // Pastikan keahlian_terapi di-decode jika tersimpan sebagai string JSON
        if (is_string($guru->keahlian_terapi)) {
            $guru->keahlian_terapi = json_decode($guru->keahlian_terapi, true);
        }

        return view('admin.guru_terapis.show', compact('guru'));
    }

    /**
     * Menampilkan Form Edit
     */
    public function edit($id)
    {
        $guru = GuruTerapis::with('user')->findOrFail($id);
        $tahunAjaran = TahunAjaran::all();
        $pilihanKeahlian = ['Wicara', 'Okupasi', 'Perilaku', 'Sensori Integrasi', 'Fisioterapi', 'Psikologi'];
        
        // Konversi ke array jika data di DB berupa string
        if (is_string($guru->keahlian_terapi)) {
            $guru->keahlian_terapi = json_decode($guru->keahlian_terapi, true);
        }

        return view('admin.guru_terapis.edit', compact('guru', 'tahunAjaran', 'pilihanKeahlian'));
    }

    public function update(Request $request, $id)
    {
        $guru = GuruTerapis::findOrFail($id);
        $user = $guru->user;

        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => ['required', Rule::unique('users')->ignore($user->id)],
            'email'           => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'        => 'nullable|min:8',
            'nip'             => ['required', Rule::unique('guru_terapis')->ignore($guru->id)],
            'id_tahun_ajaran' => 'required|exists:tahun_ajaran,id',
            'jenis_kelamin'   => 'required|in:L,P',
            'status_kerja'    => 'required|in:Aktif,Non-Aktif',
            'keahlian_terapi' => 'required|array|min:1',
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            $guruData = [
                'id_tahun_ajaran' => $request->id_tahun_ajaran,
                'nip'             => $request->nip,
                'jenis_kelamin'   => $request->jenis_kelamin,
                'nomor_hp'        => $request->nomor_hp,
                'keahlian_terapi' => $request->keahlian_terapi,
                'status_kerja'    => $request->status_kerja,
            ];

            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($guru->foto) {
                    Storage::delete('public/foto_guru/' . $guru->foto);
                }
                
                $file = $request->file('foto');
                $nama_foto = time() . "_" . $file->getClientOriginalName();
                $file->storeAs('public/foto_guru', $nama_foto);
                $guruData['foto'] = $nama_foto;
            }

            $guru->update($guruData);

            DB::commit();
            return redirect()->route('guru-terapis.index')->with('success', 'Data Terapis berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $guru = GuruTerapis::findOrFail($id);
        DB::beginTransaction();
        try {
            $user = $guru->user;

            if ($guru->foto) {
                Storage::delete('public/foto_guru/' . $guru->foto);
            }

            $guru->delete();
            if($user) $user->delete();

            DB::commit();
            return redirect()->route('guru-terapis.index')->with('success', 'Data Terapis telah dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}