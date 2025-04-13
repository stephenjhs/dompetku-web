<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DompetKu - Dompet Digital Modern</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Public Sans', sans-serif;
    }
    .card-hover:hover {
      transform: translateY(-5px);
    }
    .custom-shadow {
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }
    .feature-icon {
      border-radius: 12px;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen">
  <!-- Navigasi Modern -->
  <nav class="bg-indigo-600 text-white py-4">
    <div class="container mx-auto px-6">
      <div class="flex justify-between items-center">
        <a href="#" class="flex items-center space-x-2">
          <div class="bg-white/20 rounded-lg p-2 px-3">
            <i class="fas fa-wallet text-white"></i>
          </div>
          <span class="text-xl font-semibold tracking-tight">DompetKu</span>
        </a>
        
        <div class="flex items-center space-x-4">
          <a href="{{ route('login') }}" class="bg-white/20 hover:bg-white/30 rounded-full px-5 py-2 text-sm font-medium transition duration-200">Masuk</a>
          <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 rounded-full px-5 py-2 text-sm font-medium transition duration-200">Daftar</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Header Section -->
  <header class="container mx-auto px-6 py-10">
    <div class="flex flex-col md:flex-row items-center justify-between">
      <div class="md:w-1/2 mb-10 md:mb-0">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4">Kelola Keuangan DigitalMu</h1>
        <p class="text-gray-600 mb-6 text-lg">Platform dompet digital terpercaya dengan layanan lengkap untuk kebutuhan finansial harian Anda. Kelola saldo, transfer, dan lakukan simulasi pembayaran digital dengan mudah dan cepat.</p>
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 text-center">
          <a href="{{route('login')}}" class="bg-indigo-600 text-white font-medium px-6 py-3 rounded-lg hover:shadow-lg transition duration-300">Mulai Sekarang</a>
          <a href="#features" class="border border-indigo-500 text-indigo-500 font-medium px-6 py-3 rounded-lg hover:bg-indigo-50 transition duration-300">Pelajari Lebih Lanjut</a>
        </div>
      </div>
      <div class="md:w-2/5">
        <img src="{{ asset('images/dompetku.png') }}" alt="DompetKu App" class="rounded-xl shadow-xl w-full h-[500px] object-cover" />
      </div>
    </div>
  </header>

  <!-- Main Features Section -->
  <section class="container mx-auto px-6 py-12" id="features">
    <div class="text-center mb-16">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Layanan Utama</h2>
      <div class="w-16 h-1 bg-indigo-600 mx-auto rounded-full mb-4"></div>
      <p class="text-gray-600 max-w-xl mx-auto">Nikmati kemudahan bertransaksi dengan berbagai layanan utama yang kami sediakan untuk memenuhi kebutuhan finansial digital Anda.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Card 1: Topup -->
      <div class="bg-white rounded-xl custom-shadow transition-all duration-300 card-hover">
        <div class="p-6">
          <div class="bg-indigo-50 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
            <i class="fas fa-wallet text-indigo-600 text-xl"></i>
          </div>
          <h3 class="font-semibold text-xl text-gray-800 mb-3">Topup Saldo</h3>
          <p class="text-gray-600 mb-6 text-sm leading-relaxed">Isi saldo DompetKu Anda dengan mudah melalui berbagai metode pembayaran yang tersedia.</p>
          <div class="flex justify-between items-center">
            <span class="text-xs text-gray-500">Instan & Aman</span>
            <button class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center group">
              <span>Top Up</span>
              <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition duration-200"></i>
            </button>
          </div>
        </div>
      </div>
      
      <!-- Card 2: Pembayaran Digital -->
      <div class="bg-white rounded-xl custom-shadow transition-all duration-300 card-hover">
        <div class="p-6">
          <div class="bg-green-50 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
            <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
          </div>
          <h3 class="font-semibold text-xl text-gray-800 mb-3">Pembayaran Digital</h3>
          <p class="text-gray-600 mb-6 text-sm leading-relaxed">Bayar tagihan, belanja online, dan transaksi lainnya dengan cepat dan praktis.</p>
          <div class="flex justify-between items-center">
            <span class="text-xs text-gray-500">Transfer Via Saldo</span>
            <button class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center group">
              <span>Bayar</span>
              <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition duration-200"></i>
            </button>
          </div>
        </div>
      </div>
      
      <!-- Card 3: Transfer -->
      <div class="bg-white rounded-xl custom-shadow transition-all duration-300 card-hover">
        <div class="p-6">
          <div class="bg-purple-50 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
            <i class="fas fa-exchange-alt text-purple-600 text-xl"></i>
          </div>
          <h3 class="font-semibold text-xl text-gray-800 mb-3">Transfer</h3>
          <p class="text-gray-600 mb-6 text-sm leading-relaxed">Kirim uang ke teman, keluarga, atau rekening bank dengan biaya transfer minimum.</p>
          <div class="flex justify-between items-center">
            <span class="text-xs text-gray-500">Tanpa Biaya Admin</span>
            <button class="text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center group">
              <span>Transfer</span>
              <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition duration-200"></i>
            </button>
          </div>
        </div>
      </div>
      
      <!-- Card 4: Riwayat Transaksi -->
      <div class="bg-white rounded-xl custom-shadow transition-all duration-300 card-hover">
        <div class="p-6">
          <div class="bg-amber-50 w-14 h-14 rounded-xl flex items-center justify-center mb-6 feature-icon">
            <i class="fas fa-history text-amber-600 text-xl"></i>
          </div>
          <h3 class="font-semibold text-xl text-gray-800 mb-3">Riwayat Transaksi</h3>
          <p class="text-gray-600 mb-6 text-sm leading-relaxed">Lacak dan kelola semua riwayat transaksi Anda dalam satu tampilan yang informatif.</p>
          <div class="flex justify-between items-center">
            <span class="text-xs text-gray-500">Laporan Lengkap</span>
            <button class="text-amber-600 hover:text-amber-700 font-medium text-sm flex items-center group">
              <span>Lihat</span>
              <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition duration-200"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-10">
    <div class="container mx-auto px-6">
        <div class="flex text-center justify-center items-center">
          <p class="text-gray-400 text-sm">&copy; 2025 DompetKu. <br> Dibuat oleh Steven Johannes & Steven Sirait.</p>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>