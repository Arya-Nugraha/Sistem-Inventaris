{{-- Pesan sukses --}}
@if (session('success'))
    <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
        <span>✅</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- Pesan error --}}
@if (session('error'))
    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
        <span>❌</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Validasi error dari form --}}
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
        <p class="font-semibold mb-1">⚠️ Terdapat kesalahan input:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
