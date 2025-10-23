@extends('layout.home')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">

    <div class="flex justify-between items-center pb-4 border-b dark:border-gray-700">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Formulir Siswa Baru</h1>
        <div class="flex gap-3">
            <a href="{{ route('siswa.index') }}" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Batal
            </a>
            <button type="submit" form="siswaForm" class="py-2 px-4 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
                Simpan
            </button>
        </div>
    </div>

    <form id="siswaForm" action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        <div class="grid md:grid-cols-3 gap-8">

            <div class="md:col-span-2 space-y-6">
                
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Dasar</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_depan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Depan</label>
                            <input type="text" id="nama_depan" name="nama_depan" value="{{ old('nama_depan') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan nama depan" required>
                            @error('nama_depan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="nama_belakang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Belakang</label>
                            <input type="text" id="nama_belakang" name="nama_belakang" value="{{ old('nama_belakang') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan nama belakang" required>
                            @error('nama_belakang')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="nisn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NISN</label>
                            <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan NISN (10 angka)" required>
                            @error('nisn')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            @error('tanggal_lahir')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Kontak (Wali)</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="nomor_kontak" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Kontak</label>
                            <input type="tel" id="nomor_kontak" name="nomor_kontak" value="{{ old('nomor_kontak') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: 08123456789" required>
                            @error('nomor_kontak')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan email wali">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                            <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan alamat lengkap">
                            @error('alamat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="kota" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kota/Kabupaten</label>
                            <input type="text" id="kota" name="kota" value="{{ old('kota') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan kota">
                            @error('kota')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="kode_pos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Pos</label>
                            <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan kode pos">
                            @error('kode_pos')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="negara" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Negara</label>
                            <select id="negara" name="negara" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="Indonesia" {{ old('negara', 'Indonesia') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                <option value="Lainnya" {{ old('negara') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('negara')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="md:col-span-1 space-y-6">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Dokumen</h2>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, PNG, atau JPG (maks. 2MB)</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">(Akta Lahir / Kartu Keluarga)</p>
                            </div>
                            <input id="dropzone-file" name="dokumen" type="file" class="hidden" />
                        </label>
                    </div> 
                    @error('dokumen')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Foto Profil</h2>
                    <div class="flex items-center justify-center w-full">
                        <label for="foto-profil" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 0h.01M10 19a7 7 0 0 1-7-7v-1a7 7 0 0 1 14 0v1a7 7 0 0 1-7 7Zm-4-7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v2a3 3 0 0 1-3 3h-2a3 3 0 0 1-3-3v-2Z"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Lampirkan foto</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">JPG atau PNG (maks. 2MB)</p>
                            </div>
                            <input id="foto-profil" name="foto_profil" type="file" class="hidden" />
                        </label>
                    </div>
                    @error('foto_profil')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>
    </form>
</div>
@endsection