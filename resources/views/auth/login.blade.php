<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DompetKu - Halaman Login</title>
  @vite(['/resources/css/app.css', '/resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f5f7fa;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Masuk ke Akun Anda</h1>
            <p class="text-gray-500 text-sm mt-2">Masukkan email dan password Anda untuk melanjutkan</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="nama@email.com" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-sm" 
                    required
                >
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Masukkan password Anda" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors text-sm" 
                    required
                >
            </div>
            <button 
                type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg text-sm font-medium transition-colors"
            >
                Masuk
            </button>
        </form>

        <div class="text-center mt-6 text-sm text-gray-500">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Daftar sekarang</a>
        </div>
    </div>
</body>
</html>
