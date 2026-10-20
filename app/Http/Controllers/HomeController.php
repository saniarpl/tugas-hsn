<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carousel;
use App\Models\News;
use App\Models\Activity;
use App\Models\Committee;
use App\Models\Feedback;
use App\Models\Donation;
use App\Models\Gallery; // Import Model Gallery

class HomeController extends Controller
{
    public function index()
    {
        $carousels = Carousel::latest()->get();
        $news = News::latest()->take(6)->get();
        $activities = Activity::latest()->take(4)->get();
        $donations = Donation::orderBy('date', 'desc')->take(5)->get();
        
        // Ambil 6 foto galeri terbaru untuk Halaman Utama (Beranda)
        $galleries = Gallery::latest()->take(6)->get();

        return view('frontend.home', compact('carousels', 'news', 'activities', 'donations', 'galleries'));
    }

    public function galleryPage()
    {
        // Ambil seluruh foto galeri untuk Halaman Khusus Galeri (dengan Pagination)
        $galleries = Gallery::latest()->paginate(12);
        
        return view('frontend.gallery', compact('galleries'));
    }

    public function organization($slug)
    {
        $organizationsData = [
            'ipnu' => [
                'title' => 'Ikatan Pelajar Nahdlatul Ulama (IPNU)',
                'description' => 'Wadah kaderisasi, pembinaan, dan perjuangan pelajar putra Nahdlatul Ulama Desa Windunegara.',
                'color' => 'from-emerald-900 to-green-800',
                'about' => 'IPNU Windunegara bertugas membina generasi muda dan pelajar Islam Ahlussunnah wal Jamaah An-Nahdliyah.',
                'proker' => ['Makesta (Masa Kesetiaan Anggota)', 'Kajian Rutin Keislaman & Keilmuan', 'Latihan Hadroh', 'Peringatan Hari Besar Islam (PHBI)']
            ],
            'ippnu' => [
                'title' => 'Ikatan Pelajar Putri Nahdlatul Ulama (IPPNU)',
                'description' => 'Wadah pembinaan, pergerakan, dan pemberdayaan pelajar putri NU Windunegara.',
                'color' => 'from-emerald-800 to-teal-800',
                'about' => 'IPPNU Windunegara berfokus pada pengembangan potensi, kemandirian, dan kepemimpinan pelajar putri NU.',
                'proker' => ['Makesta Putri', 'Kajian Fiqih Wanita', 'Pelatihan Kewirausahaan & Ekonomi Kreatif', 'Bakti Sosial & Literasi']
            ],
            'fatayat' => [
                'title' => 'Fatayat NU',
                'description' => 'Organisasi pemudi Islam Nahdlatul Ulama Desa Windunegara.',
                'color' => 'from-green-800 to-emerald-950',
                'about' => 'Fatayat NU Ranting Windunegara wadah perjuangan pemudi NU dalam pendidikan keluarga dan sosial-keagamaan.',
                'proker' => ['Pengajian Rutin Yasin', 'Penyuluhan Kesehatan Ibu & Anak', 'Pemberdayaan UMKM Pemudi', 'Santunan Anak Yatim']
            ],
            'muslimat' => [
                'title' => 'Muslimat NU',
                'description' => 'Organisasi wanita Islam Nahdlatul Ulama Desa Windunegara.',
                'color' => 'from-emerald-950 to-slate-900',
                'about' => 'Muslimat NU Windunegara menjadi pilar utama dalam dakwah keagamaan wanita dan bina keluarga sakinah.',
                'proker' => ['Majelis Taklim Bulanan', 'Bina Keluarga Sakinah', 'Gerakan Infak Sosial', 'Penguatan Ekonomi Jam\'iyyah']
            ],
            'banser' => [
                'title' => 'Barisan Ansor Serbaguna (Banser)',
                'description' => 'Kader inti Pemuda Ansor pengawal ulama, kiai, dan benteng NKRI.',
                'color' => 'from-amber-900 to-slate-900',
                'about' => 'Banser Ranting Windunegara bertugas menjaga keamanan kegiatan keagamaan, mengawal ulama, serta tanggap bencana.',
                'proker' => ['Pengamanan Kegiatan Keagamaan', 'Diklatsar Banser', 'Tanggap Bencana & Kerja Bakti', 'Latihan Kesamaptaan']
            ]
        ];

        $org = $organizationsData[$slug] ?? [
            'title' => strtoupper($slug),
            'description' => 'Badan Otonom Nahdlatul Ulama Windunegara.',
            'color' => 'from-emerald-900 to-green-950',
            'about' => 'Badan Otonom Nahdlatul Ulama Desa Windunegara.',
            'proker' => ['Kegiatan Rutin Keagamaan']
        ];

        // Ambil data pengurus terkait banom yang dipilih
        $committees = Committee::where('organization', $slug)->get();

        return view('frontend.organization', compact('org', 'slug', 'committees'));
    }

    public function storeFeedback(Request $request)
    {
        // Validasi ketat + honeypot 'website' untuk menjegal bot spam
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'contact' => 'nullable|string|max:30',
            'message' => 'required|string|min:10|max:2000',
            'website' => 'prohibited',
        ], [
            'name.min' => 'Nama minimal 3 karakter.',
            'message.min' => 'Pesan minimal 10 karakter agar jelas.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
            'website.prohibited' => 'Deteksi spam. Pengiriman ditolak.',
        ]);

        // Simpan versi bersih (tanpa tag HTML) untuk mencegah XSS tersimpan
        Feedback::create([
            'name' => strip_tags($request->input('name')),
            'contact' => strip_tags((string) $request->input('contact')),
            'message' => strip_tags((string) $request->input('message')),
        ]);

        // Kembalikan ke halaman utama dengan pesan sukses
        return redirect('/#saran')->with('success', 'Terima kasih! Saran dan kritik Anda berhasil dikirim.');
    }

    public function newsShow(News $news)
    {
        $related = News::latest()->where('id', '!=', $news->id)->take(3)->get();

        return view('frontend.news-show', ['item' => $news, 'related' => $related]);
    }

    public function activityShow(Activity $activity)
    {
        $related = Activity::latest()->where('id', '!=', $activity->id)->take(2)->get();

        return view('frontend.activity-show', ['item' => $activity, 'related' => $related]);
    }
}