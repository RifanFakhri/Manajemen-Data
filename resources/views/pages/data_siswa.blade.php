@extends('layout.home')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Siswa</h1>
        
        {{-- Tombol ini akan mengarah ke formulir yang akan kita buat --}}
        <a href="{{ route('siswa.create') }}" class="inline-flex items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
            </svg>
            Tambah Siswa Baru
        </a>
    </div>

    {{-- 
      ======================================================================
      BAGIAN PLACEHOLDER LAMA DIHAPUS DAN DIGANTI DENGAN KODE DI BAWAH INI
      ======================================================================
    --}}

    {{-- Pesan Sukses (jika ada, setelah redirect dari 'store') --}}
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nama Siswa
                    </th>
                    <th scope="col" class="px-6 py-3">
                        NISN
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kontak
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tgl. Daftar
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                
                {{-- Kita akan loop data $siswas di sini --}}
                @forelse ($siswas as $siswa)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        {{-- Cek jika ada foto, jika tidak tampilkan placeholder --}}
                        @if($siswa->foto_profil_path)
                            <img class="w-10 h-10 rounded-full" src="{{ Storage::url($siswa->foto_profil_path) }}" alt="Foto {{ $siswa->nama_depan }}">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                <span class="text-gray-500">{{ substr($siswa->nama_depan, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="ps-3">
                            {{-- Kita gunakan accessor 'nama_lengkap' dari Model --}}
                            <div class="text-base font-semibold">{{ $siswa->nama_lengkap }}</div>
                            <div class="font-normal text-gray-500">{{ $siswa->email ?? 'email tidak ada' }}</div>
                        </div>  
                    </th>
                    <td class="px-6 py-4">
                        {{ $siswa->nisn }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $siswa->nomor_kontak }}
                    </td>
                    <td class="px-6 py-4">
                        {{-- Format tanggal agar lebih rapi --}}
                        {{ $siswa->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        {{-- 
                          Rute 'siswa.edit' dan 'siswa.destroy' otomatis ada 
                          karena kita pakai Route::resource
                        --}}
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        
                        <form action="#" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                {{-- Ini akan ditampilkan jika $siswas kosong --}}
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Belum ada data siswa.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Ini untuk menampilkan link Paginasi (Next, Prev, 1, 2, 3...) --}}
    <div class="mt-4">
        {{ $siswas->links() }}
    </div>

@endsection