<div class="w-[19rem] bg-white shadow-md hidden md:block fixed md:static z-50" id="sidebar">
      <div class="p-6 flex items-center">
        <div class="bg-indigo-100 p-2 px-3 rounded-lg mr-2">
          <i class="fas fa-wallet text-indigo-600"></i>
        </div>
        <span class="text-lg font-semibold text-gray-800">DompetKu</span>
      </div>
      
      <div class="px-4 py-6 text-gray-600">
        <div class="mb-6">
          <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 px-3">Main Menu</p>
          <a href="{{ route('admin.dashboard.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('admin.dashboard.index') ? 'sidebar-active' : '' }}">
            <i class="fas fa-th-large mr-3"></i>
            <span>Dashboard</span>
          </a>
          <a href="{{ route('admin.topup.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('admin.topup.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-wallet mr-3"></i>
            <span>Data Topup</span>
          </a>
          <a href="{{ route('admin.pembayaran.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('admin.pembayaran.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-shopping-cart mr-3"></i>
            <span>Data Pembayaran Digital</span>
          </a>
          <a href="{{ route('admin.transfer.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('admin.transfer.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-exchange-alt mr-3"></i>
            <span>Data Transfer</span>
          </a>
           <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-user-friends mr-3"></i>
            <span>Data Pengguna</span>
          </a>
        </div>
        
        <div class="mb-6">
          <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 px-3">Lainnya</p>
         
          <a href="{{route('logout')}}" class="sidebar-link flex items-center p-3 rounded-lg">
            <i class="fas fa-sign-out-alt mr-3"></i>
            <span>Keluar</span>
          </a>
        </div>
      </div>
    </div>