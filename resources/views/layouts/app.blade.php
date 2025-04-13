<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'DompetKu')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="//unpkg.com/alpinejs" defer></script>
  <style>
    body {
      font-family: 'Public Sans', sans-serif;
      background-color: #f5f7fa;
    }
    button {
      cursor: pointer ;
    }
    .sidebar-active {
      background-color: #4f46e5;
      color: white;
    }
    .sidebar-link:hover:not(.sidebar-active) {
      background-color: #EFF6FF;
      color: #4f46e5;
    }
    .card-shadow {
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    @if(auth()->user()->role === 'admin')
        @include('layouts.adminSidebar')
    @else
        @include('layouts.sidebar')
    @endif

    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top Navbar -->
      <header class="bg-white shadow-sm z-10">
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center">
            <button id="toggleSidebar" class="md:hidden mr-4 text-gray-500 focus:outline-none">
              <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-lg font-semibold">@yield('title', 'DompetKu')</h1>
          </div>
          
          <div class="flex items-center space-x-4">
            <a href="/profil" class="flex items-center">
              <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-2">
                @php
                    $parts = explode(' ', trim(auth()->user()->name));
                    $inisial = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                @endphp

                <span class="font-medium text-indigo-600">{{$inisial}}</span>
              </div>
              <span class="text-sm font-medium text-gray-700 hidden md:block">{{auth()->user()->name}}</span>
            </a>
          </div>
        </div>
      </header>
      
      <!-- Content -->
      @yield('content')
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

   document.addEventListener('click', function (e) {
  if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
    sidebar.classList.add('hidden');
  }
});

    toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('top-0');
    sidebar.classList.toggle('left-0');
    sidebar.classList.toggle('bottom-0');
  });

  // Auto atur sidebar ketika resize
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
      // Hapus class mobile positioning
      sidebar.classList.remove('hidden', 'top-0', 'left-0', 'bottom-0');
    } else {
      // Saat mobile, biarin tetap hidden sampai toggle di-click
      sidebar.classList.add('hidden');
    }
  });


  </script>

  @stack('scripts')
</body>
</html>