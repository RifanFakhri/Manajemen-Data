@extends('layout.home') {{-- Sesuaikan dengan nama layout Anda --}}

@section('content')

{{-- Definisi $jurusanList agar bisa dipakai di tabel dan modal --}}
@php
    $jurusanList = [
        'TKJ' => 'Teknik Komputer Jaringan',
        'RPL' => 'Rekayasa Perangkat Lunak',
        'MM'  => 'Multimedia',
        'TJA' => 'Teknik Jaringan Akses',
    ];
@endphp

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Siswa</h1>
        
        {{-- Tombol ini mengarah ke route 'siswa.create' --}}
        <a href="{{ route('siswa.create') }}" class="inline-flex items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
            Tambah Siswa Baru
        </a>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div id="success-alert" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    {{-- Pesan Error Validasi (Penting untuk debug modal edit) --}}
    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <span class="font-medium">Validasi Gagal!</span> Periksa kembali data yang Anda masukkan. Jika error terjadi saat mengedit, modal mungkin tertutup. Periksa data Anda sebelum submit.
            <ul class="mt-1.5 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Awal Tabel --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Foto</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">NISN</th>
                    <th scope="col" class="px-6 py-3">Jurusan</th>
                    <th scope="col" class="px-6 py-3">Kontak</th>
                    <th scope="col" class="px-6 py-3">Dokumen</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse ($siswas as $siswa)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    
                    {{-- Foto Profil --}}
                    <td class="px-6 py-4">
                        <img class="w-10 h-10 rounded-full" src="{{ $siswa->foto_profil_url }}" alt="Foto {{ $siswa->nama_depan }}">
                    </td>
                    
                    {{-- Nama Lengkap --}}
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $siswa->nama_lengkap }}
                    </td>
                    
                    {{-- NISN --}}
                    <td class="px-6 py-4">{{ $siswa->nisn }}</td>

                    {{-- Jurusan --}}
                    <td class="px-6 py-4">
                        {{ $jurusanList[$siswa->jurusan] ?? $siswa->jurusan }}
                    </td>

                    {{-- Kontak --}}
                    <td class="px-6 py-4">{{ $siswa->nomor_kontak }}</td>
                    
                    {{-- Dokumen (Tombol Preview) --}}
                    <td class="px-6 py-4">
                        @if($siswa->dokumen_url)
                            <button type="button" 
                                    data-modal-target="preview-modal-{{ $siswa->id }}" 
                                    data-modal-toggle="preview-modal-{{ $siswa->id }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                Lihat
                            </button>
                        @else
                            -
                        @endif
                    </td>

                    {{-- Aksi (Edit & Hapus) --}}
                    <td class="px-6 py-4">
                        {{-- Tombol Pemicu Modal Edit --}}
                        <button type="button" 
                                data-modal-target="edit-modal-{{ $siswa->id }}" 
                                data-modal-toggle="edit-modal-{{ $siswa->id }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Edit
                        </button>
                        
                        {{-- Form Hapus --}}
                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- ============================================= --}}
                {{-- MODAL EDIT SISWA --}}
                {{-- ============================================= --}}
                <div id="edit-modal-{{ $siswa->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            {{-- Modal Header --}}
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Edit Data Siswa
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-modal-{{ $siswa->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Tutup modal</span>
                                </button>
                            </div>

                            {{-- Form Edit --}}
                            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                {{-- Modal Body --}}
                                <div class="p-4 md:p-5 space-y-4">
                                    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2">
                                        {{-- Nama Depan --}}
                                        <div class="col-span-1">
                                            <label for="nama_depan-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Depan</label>
                                            <input type="text" name="nama_depan" id="nama_depan-{{ $siswa->id }}" value="{{ old('nama_depan', $siswa->nama_depan) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                        </div>
                                        {{-- Nama Belakang --}}
                                        <div class="col-span-1">
                                            <label for="nama_belakang-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Belakang</label>
                                            <input type="text" name="nama_belakang" id="nama_belakang-{{ $siswa->id }}" value="{{ old('nama_belakang', $siswa->nama_belakang) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                        </div>
                                        {{-- NISN --}}
                                        <div class="col-span-1">
                                            <label for="nisn-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NISN</label>
                                            <input type="text" name="nisn" id="nisn-{{ $siswa->id }}" value="{{ old('nisn', $siswa->nisn) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                        </div>
                                        {{-- Email --}}
                                        <div class="col-span-1">
                                            <label for="email-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                            <input type="email" name="email" id="email-{{ $siswa->id }}" value="{{ old('email', $siswa->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                        </div>
                                        {{-- Tanggal Lahir --}}
                                        <div class="col-span-1">
                                            <label for="tanggal_lahir-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir-{{ $siswa->id }}" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir->format('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                        </div>
                                        
                                        {{-- Jurusan --}}
                                        <div class="col-span-1">
                                            <label for="jurusan-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
                                            <select id="jurusan-{{ $siswa->id }}" name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                                <option value="">-- Pilih Jurusan --</option>
                                                @foreach ($jurusanList as $key => $value)
                                                    <option value="{{ $key }}" {{ old('jurusan', $siswa->jurusan) == $key ? 'selected' : '' }}>
                                                        {{ $value }} ({{ $key }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        {{-- Nomor Kontak --}}
                                        <div class="col-span-1">
                                            <label for="nomor_kontak-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Kontak</label>
                                            <input type="text" name="nomor_kontak" id="nomor_kontak-{{ $siswa->id }}" value="{{ old('nomor_kontak', $siswa->nomor_kontak) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                        </div>
                                        
                                        {{-- Negara --}}
                                        <div class="col-span-1">
                                            <label for="negara-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Negara</label>
                                            <input type="text" name="negara" id="negara-{{ $siswa->id }}" value="{{ old('negara', $siswa->negara) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                        </div>

                                        {{-- Alamat --}}
                                        <div class="col-span-1 sm:col-span-2">
                                            <label for="alamat-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                            <textarea id="alamat-{{ $siswa->id }}" name="alamat" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">{{ old('alamat', $siswa->alamat) }}</textarea>                    
                                        </div>
                                        {{-- Kota --}}
                                        <div class="col-span-1">
                                            <label for="kota-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kota</label>
                                            <input type="text" name="kota" id="kota-{{ $siswa->id }}" value="{{ old('kota', $siswa->kota) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                        </div>
                                        {{-- Kode Pos --}}
                                        <div class="col-span-1">
                                            <label for="kode_pos-{{ $siswa->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos</label>
                                            <input type="text" name="kode_pos" id="kode_pos-{{ $siswa->id }}" value="{{ old('kode_pos', $siswa->kode_pos) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                        </div>
                                        
                                        {{-- Ganti Foto Profil --}}
                                        <div class="col-span-1 sm:col-span-2">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto_profil-{{ $siswa->id }}">Ganti Foto Profil</label>
                                            <input name="foto_profil" id="foto_profil-{{ $siswa->id }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400" type="file" accept="image/png, image/jpeg, image/jpg">
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-300">Foto saat ini: <a href="{{ $siswa->foto_profil_url }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a> (Kosongkan jika tidak ingin ganti)</div>
                                        </div>
                                        
                                        {{-- Ganti Dokumen --}}
                                        <div class="col-span-1 sm:col-span-2">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="dokumen-{{ $siswa->id }}">Ganti Dokumen</label>
                                            <input name="dokumen" id="dokumen-{{ $siswa->id }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400" type="file" accept=".pdf,.png,.jpg,.jpeg">
                                            @if($siswa->dokumen_url)
                                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-300">Dokumen saat ini: <a href="{{ $siswa->dokumen_url }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a> (Kosongkan jika tidak ingin ganti)</div>
                                            @else
                                                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-300">Belum ada dokumen. (Kosongkan jika tidak ingin ganti)</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Footer --}}
                                <div class="flex items-center justify-end p-4 md:p-5 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="w-5 h-5 me-1 -ms-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        Update Data Siswa
                                    </button>
                                    <button type="button" data-modal-hide="edit-modal-{{ $siswa->id }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- ============================================= --}}
                {{-- AKHIR DARI MODAL EDIT --}}
                {{-- ============================================= --}}


                {{-- ============================================= --}}
                {{-- MODAL PREVIEW DOKUMEN --}}
                {{-- ============================================= --}}
                @if($siswa->dokumen_url)
                <div id="preview-modal-{{ $siswa->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full">
                    <div class="relative p-4 w-full max-w-5xl max-h-full"> {{-- Dibuat lebar (max-w-5xl) --}}
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            {{-- Modal Header --}}
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Preview Dokumen: {{ $siswa->nama_lengkap }}
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="preview-modal-{{ $siswa->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Tutup modal</span>
                                </button>
                            </div>

                            {{-- Modal Body --}}
                            <div class="p-4 md:p-5">
                                {{-- Iframe untuk menampilkan PDF/Gambar --}}
                                <iframe src="{{ $siswa->dokumen_url }}" class="w-full h-[75vh]" frameborder="0">
                                    Browser Anda tidak mendukung iframe. Silakan <a href="{{ $siswa->dokumen_url }}" target="_blank">klik di sini</a> untuk melihat dokumen.
                                </iframe>
                            </div>

                            {{-- Modal Footer --}}
                            <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <a href="{{ $siswa->dokumen_url }}" target="_blank" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    Buka di Tab Baru
                                </a>
                                <button type="button" data-modal-hide="preview-modal-{{ $siswa->id }}" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                {{-- ============================================= --}}
                {{-- AKHIR DARI MODAL PREVIEW --}}
                {{-- ============================================= --}}


                @empty
                {{-- Baris jika tidak ada data --}}
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Belum ada data siswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Akhir Tabel --}}

    {{-- Link Paginasi --}}
    <div class="mt-4">
        {{ $siswas->links() }}
    </div>

    {{-- Script untuk menyembunyikan alert sukses --}}
    <script>
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.add('hidden');
            }, 3000); // Sembunyikan setelah 3 detik
        }
    </script>
@endsection