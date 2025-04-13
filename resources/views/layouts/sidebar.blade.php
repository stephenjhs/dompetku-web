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
          <a href="{{ route('dashboard.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('dashboard.index') ? 'sidebar-active' : '' }}">
            <i class="fas fa-th-large mr-3"></i>
            <span>Dashboard</span>
          </a>
          <a href="{{ route('topup.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('topup.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-wallet mr-3"></i>
            <span>Topup</span>
          </a>
          <a href="{{ route('pembayaran.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('pembayaran.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-shopping-cart mr-3"></i>
            <span>Pembayaran Digital</span>
          </a>
          <a href="{{ route('transfer.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('transfer.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-exchange-alt mr-3"></i>
            <span>Transfer</span>
          </a>
          <a href="{{ route('riwayat-transaksi.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('riwayat-transaksi.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-history mr-3"></i>
            <span>Riwayat Transaksi</span>
          </a>
        </div>
        
        <div class="mb-6">
          <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 px-3">Lainnya</p>
          <a href="{{ route('profil.index') }}" class="sidebar-link flex items-center mb-2 p-3 rounded-lg {{ request()->routeIs('profil.*') ? 'sidebar-active' : '' }}">
            <i class="fas fa-user-circle mr-3"></i>
            <span>Profil</span>
          </a>
          <a href="{{ route('logout') }}" class="sidebar-link flex items-center p-3 rounded-lg">
            <i class="fas fa-sign-out-alt mr-3"></i>
            <span>Keluar</span>
          </a>
        </div>
      </div>
    </div>