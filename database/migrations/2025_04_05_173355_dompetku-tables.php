<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->unique()->nullable();
            $table->double('saldo')->default(0);
            $table->double('saldo_dollar')->default(0);
            $table->string('role')->default('member');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Tabel: topup
        Schema::create('topup', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('jumlah');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel: pembayaran_digital
        Schema::create('pembayaran_digital', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis', ['pulsa', 'token_listrik', 'qr']);
            $table->string('tujuan');
            $table->double('jumlah');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel: investasi
        Schema::create('investasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis', ['dollar']);
            $table->double('jumlah');
            $table->double('rate');
            $table->double('selisih');
            $table->enum('aksi', ['jual', 'beli']);
            $table->timestamps();
        });

        // Tabel: transfer
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dari_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ke_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('ke_nama')->nullable();
            $table->enum('ke_tipe', ['dompetku', 'dana', 'ovo', 'gopay', 'bri', 'bni', 'mandiri']);
            $table->string('ke_nomor');
            $table->double('jumlah');
            $table->enum('status', ['berhasil', 'gagal'])->default('berhasil');
            $table->timestamps();
        });

        // Tabel: riwayat_transaksi
        Schema::create('riwayat_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->string('kategori');
            $table->double('jumlah');
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('topup');
        Schema::dropIfExists('pembayaran_digital');
        Schema::dropIfExists('investasi');
        Schema::dropIfExists('transfer');
        Schema::dropIfExists('riwayat_transaksi');
    }
};
