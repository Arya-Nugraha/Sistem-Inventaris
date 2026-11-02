<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Inventaris</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-sm bg-white rounded-lg shadow p-8">
            <h1 class="text-xl font-semibold text-center mb-6">Sistem Inventaris</h1>

            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 text-red-700 text-sm px-3 py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    Remember Me
                </label>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded py-2">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>