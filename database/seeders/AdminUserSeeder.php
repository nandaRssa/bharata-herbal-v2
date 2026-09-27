<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat atau memperbarui user admin.
     * Jalankan: php artisan db:seed --class=AdminUserSeeder
     *
     * PENTING: Ganti email dan password di bawah sebelum dijalankan di production!
     */
    public function run(): void
    {
        // Set SEMUA user existing menjadi non-admin terlebih dahulu
        User::query()->update(['is_admin' => false]);

        // Buat atau perbarui akun admin utama
        User::updateOrCreate(
            ['email' => 'admin@bharataherbal.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('GantiPasswordIniSegera!2026'),
                'is_admin' => true,
            ]
        );

        $this->command->info('Admin user created: admin@bharataherbal.id');
        $this->command->warn('PENTING: Segera ubah password admin via panel pengaturan!');
    }
}
