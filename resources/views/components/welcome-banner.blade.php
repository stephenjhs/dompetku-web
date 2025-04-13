@php
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    $lastActivity = DB::table('sessions')
        ->where('user_id', Auth::id())
        ->latest('last_activity')
        ->first();

    $lastActiveTime = $lastActivity 
        ? Carbon::createFromTimestamp($lastActivity->last_activity)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
        : 'Tidak tersedia';
@endphp

<!-- Welcome & Balance -->
<div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white card-shadow">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
      <p class="font-medium mb-1">Selamat datang kembali,</p>
      <h2 class="text-2xl font-bold mb-2">{{ auth()->user()->name }}</h2>
      <p class="text-blue-100">Terakhir aktif: {{ $lastActiveTime }}</p>
    </div>
    <div class="mt-4 md:mt-0">
      <p class="text-blue-100 text-sm mb-1">Saldo Anda</p>
      <h3 class="text-3xl font-bold">Rp{{ number_format(auth()->user()->saldo, 2, ',', '.') }}</h3>
    </div>
  </div>
</div>