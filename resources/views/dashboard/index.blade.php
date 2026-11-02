@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Selamat Datang di Dashboard!</h2>
        <p class="mt-2 text-sm text-gray-600">
            Anda berhasil login sebagai <span class="text-blue-600 font-semibold">{{ auth()->user()->name ?? 'User' }}</span>.
        </p>
    </div>
@endsection