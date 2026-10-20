<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder {
    public function run(): void {
        User::updateOrCreate(['email' => 'admin@wanuwin.id'], ['name' => 'Admin WANUWIN ID', 'password' => Hash::make('password123')]);
    }
}