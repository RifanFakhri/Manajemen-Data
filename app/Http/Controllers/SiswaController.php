<?php

namespace App\Http\Controllers;

use App\Models\Siswa; // Pastikan Model Siswa di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk mengelola file
use Illuminate\Validation\Rule; // <-- Ini SANGAT PENTING untuk validasi update

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa (halaman 'data_siswa').
     */
    public function index()
    {
        // Mengambil data siswa terbaru dengan paginasi
        $siswas = Siswa::latest()->paginate(10); 
        
        // Menampilkan view 'pages.data_siswa' dan mengirim data 'siswas'
        return view('pages.data_siswa', compact('siswas'));
    }

    /**
     * Menampilkan formulir tambah siswa baru.
     */
    public function create()
    {
        // Ini akan menampilkan view 'pages.siswa_form'
        // (Anda perlu membuat file ini jika belum ada)
        return view('pages.siswa_form');
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (CREATE)
        $validatedData = $request->validate([
            'nama_depan'    => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'nisn'          => 'required|string|size:10|unique:siswas', // unique di tabel siswas
            'tanggal_lahir' => 'required|date',
            'nomor_kontak'  => 'required|string|max:15',
            'email'         => 'nullable|email|max:255|unique:siswas', // unique di tabel siswas
            'jurusan'       => 'nullable|string|in:TKJ,RPL,MM,TJA', // <-- INI TAMBAHAN
            'alamat'        => 'nullable|string',
            'kota'          => 'nullable|string|max:100',
            'kode_pos'      => 'nullable|string|max:10',
            'negara'        => 'required|string',
            'dokumen'       => 'nullable|file|mimes:pdf,png,jpg|max:2048', // max 2MB
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        // 2. Siapkan data untuk disimpan
        $dataToCreate = $validatedData;

        // 3. Handle Upload File (jika ada)
        if ($request->hasFile('dokumen')) {
            // Simpan file di 'storage/app/public/dokumen-siswa'
            $dataToCreate['dokumen_path'] = $request->file('dokumen')->store('dokumen-siswa', 'public');
        }

        if ($request->hasFile('foto_profil')) {
            // Simpan file di 'storage/app/public/foto-profil'
            $dataToCreate['foto_profil_path'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        // 4. Hapus key file asli dari array (karena kita menyimpan path-nya)
        unset($dataToCreate['dokumen']);
        unset($dataToCreate['foto_profil']);

        // 5. Buat Data Siswa di database
        Siswa::create($dataToCreate);

        // 6. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('siswa.index')->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * (Tidak digunakan dalam kasus ini, biarkan kosong)
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * (Tidak digunakan karena kita pakai modal, biarkan kosong)
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update data siswa yang ada di database.
     */
    public function update(Request $request, Siswa $siswa)
    {
        // 1. Validasi Input (UPDATE)
        $validatedData = $request->validate([
            'nama_depan'    => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nomor_kontak'  => 'required|string|max:15',
            'negara'        => 'required|string',
            'jurusan'       => 'nullable|string|in:TKJ,RPL,MM,TJA', // <-- INI TAMBAHAN

            // INI BAGIAN PENTING YANG DIPERBAIKI:
            'nisn' => [
                'required',
                'string',
                'size:10',
                Rule::unique('siswas')->ignore($siswa->id), // Abaikan ID siswa ini saat cek unique
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('siswas')->ignore($siswa->id), // Abaikan ID siswa ini saat cek unique
            ],

            // Validasi opsional
            'alamat'        => 'nullable|string',
            'kota'          => 'nullable|string|max:100',
            'kode_pos'      => 'nullable|string|max:10',
            
            // Validasi file (nullable berarti boleh tidak di-upload ulang)
            'dokumen'       => 'nullable|file|mimes:pdf,png,jpg|max:2048',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Siapkan data untuk di-update
        $dataToUpdate = $validatedData;

        // 3. Handle Upload File (Ganti file lama jika ada file baru)
        if ($request->hasFile('dokumen')) {
            // Hapus file lama jika ada
            if ($siswa->dokumen_path) {
                Storage::disk('public')->delete($siswa->dokumen_path);
            }
            // Simpan file baru
            $dataToUpdate['dokumen_path'] = $request->file('dokumen')->store('dokumen-siswa', 'public');
        }

        if ($request->hasFile('foto_profil')) {
            // Hapus file lama jika ada
            if ($siswa->foto_profil_path) {
                Storage::disk('public')->delete($siswa->foto_profil_path);
            }
            // Simpan file baru
            $dataToUpdate['foto_profil_path'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        // 4. Hapus key file asli dari array
        unset($dataToUpdate['dokumen']);
        unset($dataToUpdate['foto_profil']);

        // 5. Update Data Siswa di database
        $siswa->update($dataToUpdate);

        // 6. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus data siswa dari database.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            // 1. Hapus file-file terkait dari storage
            if ($siswa->dokumen_path) {
                Storage::disk('public')->delete($siswa->dokumen_path);
            }
            if ($siswa->foto_profil_path) {
                Storage::disk('public')->delete($siswa->foto_profil_path);
            }

            // 2. Hapus data dari database
            $siswa->delete();

            // 3. Redirect
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');

        } catch (\Exception $e) {
            // Tangkap jika ada error (misal: error database)
            return redirect()->route('siswa.index')->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }
}

