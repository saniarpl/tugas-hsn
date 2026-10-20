<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\Activity;
use App\Models\Committee;
use App\Models\Member;
use App\Models\Carousel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@wanuwin.com'],
            ['name' => 'Admin WANUWIN', 'password' => Hash::make('password123')]
        );

        // 2. Isi Data Carousel (Banner)
        Carousel::insert([
            [
                'title' => 'Selamat Datang di WANUWIN',
                'description' => 'Pusat Layanan Informasi, Kegiatan, dan Database Warga Nahdlatul Ulama Desa Windunegara.',
                'image' => '', 
                'status' => 1,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'title' => 'Mari Bersinergi Membangun Umat',
                'description' => 'Bersama IPNU, IPPNU, Fatayat, Muslimat, dan Banser kita wujudkan kemandirian jamiyyah.',
                'image' => '', 
                'status' => 1,
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 3. Isi Data Berita 
        News::insert([
            [
                'title' => 'Pelantikan Pengurus Ranting IPNU IPPNU Windunegara',
                'slug' => Str::slug('Pelantikan Pengurus Ranting IPNU IPPNU Windunegara'),
                'image' => '',
                'category' => 'IPNU',
                'content' => 'Telah sukses diselenggarakan acara pelantikan pengurus Pimpinan Ranting (PR) IPNU dan IPPNU Desa Windunegara masa khidmat 2026-2028. Acara ini dihadiri oleh jajaran pengurus MWC, tokoh masyarakat, serta puluhan pelajar NU se-Desa Windunegara. Diharapkan dengan pengurus baru ini, pelajar NU semakin kreatif dan inovatif.',
                'author' => 'Admin',
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'title' => 'Lailatul Ijtima dan Ngaji Bareng MWC NU',
                'slug' => Str::slug('Lailatul Ijtima dan Ngaji Bareng MWC NU'),
                'image' => '',
                'category' => 'NU',
                'content' => 'Rutinitas bulanan Lailatul Ijtima Ranting NU Windunegara kembali digelar dengan khidmat. Selain pembacaan tahlil dan istighosah, acara diisi dengan kajian kitab kuning (ngaji bareng) yang membahas tentang pentingnya menjaga ukhuwah Islamiyah di era modern.',
                'author' => 'Admin',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'title' => 'Bakti Sosial Banser Windunegara Bersihkan Masjid',
                'slug' => Str::slug('Bakti Sosial Banser Windunegara Bersihkan Masjid'),
                'image' => '',
                'category' => 'Banser',
                'content' => 'Puluhan anggota Banser Satkorkel Windunegara melakukan kegiatan bakti sosial berupa kerja bakti membersihkan lingkungan Masjid Agung. Kegiatan ini merupakan wujud nyata kepedulian Banser terhadap kenyamanan tempat ibadah masyarakat sekitar.',
                'author' => 'Admin',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 4. Isi Data Kegiatan
        Activity::insert([
            [
                'title' => 'Pengajian Selapanan Ahad Pon',
                'date' => now()->addDays(3),
                'location' => 'Masjid Baiturrahman Windunegara',
                'description' => 'Pengajian rutin gabungan seluruh badan otonom NU. Akan diisi dengan pembacaan Maulid Nabi dan Mauidhoh Hasanah oleh Kyai setempat.',
                'image' => '',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'title' => 'Rapat Koordinasi KARTANU',
                'date' => now()->addDays(7),
                'location' => 'Gedung Serbaguna Desa',
                'description' => 'Pembahasan percepatan pendataan warga untuk penerbitan KARTANU elektronik wilayah Windunegara.',
                'image' => '',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'title' => 'Latihan Rutin Hadroh Pagar Nusa',
                'date' => now()->addDays(12),
                'location' => 'Halaman Pesantren',
                'description' => 'Kegiatan rutin pelestarian budaya kesenian Islami dan pencak silat Pagar Nusa ranting Windunegara.',
                'image' => '',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // 5. Isi Data Pengurus
        Committee::insert([
            ['name' => 'Kyai H. Ahmad Shodiq', 'position' => 'Rais Syuriyah', 'organization' => 'NU', 'period' => '2024-2029', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ust. Muhammad Hasan', 'position' => 'Ketua Tanfidziyah', 'organization' => 'NU', 'period' => '2024-2029', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Budi Santoso', 'position' => 'Kasatkorkel', 'organization' => 'Banser', 'period' => '2025-2028', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ahmad Farsal', 'position' => 'Ketua Pimpinan Ranting', 'organization' => 'IPNU', 'period' => '2026-2028', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hj. Siti Aminah', 'position' => 'Ketua', 'organization' => 'Muslimat', 'period' => '2023-2028', 'created_at' => now(), 'updated_at' => now()]
        ]);

        // 6. Isi Data Warga NU
        Member::insert([
            ['name' => 'Slamet Riyadi', 'nik' => '3302111000000001', 'phone' => '081234567890', 'address' => 'RT 01 RW 02, Dusun I, Windunegara', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nurul Hidayah', 'nik' => '3302111000000002', 'phone' => '085712345678', 'address' => 'RT 03 RW 01, Dusun II, Windunegara', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Joko Purwanto', 'nik' => '3302111000000003', 'phone' => '089698765432', 'address' => 'RT 02 RW 03, Dusun I, Windunegara', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}