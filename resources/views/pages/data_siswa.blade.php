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

    {{-- Di sini Anda bisa menambahkan tabel data siswa nantinya --}}
    <div class="flex items-center justify-center h-96 mb-4 rounded-sm bg-gray-50 dark:bg-gray-800">
        <p class="text-2xl text-gray-400 dark:text-gray-500">
            Tabel data siswa akan muncul di sini...
        </p>
    </div>
@endsection