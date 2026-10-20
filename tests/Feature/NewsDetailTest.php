<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Feedback;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsDetailTest extends TestCase
{
    use RefreshDatabase;

    private function makeNews(array $overrides = []): News
    {
        return News::create(array_merge([
            'title' => 'Berita Uji Coba',
            'slug' => 'berita-uji-coba',
            'category' => 'Umum',
            'content' => 'Isi lengkap berita uji coba untuk halaman detail yang bisa dibagikan.',
            'author' => 'Admin',
        ], $overrides));
    }

    public function test_news_detail_page_renders_with_share_links(): void
    {
        $news = $this->makeNews();

        $response = $this->get(route('news.show', $news->id));

        $response->assertStatus(200);
        $response->assertSee($news->title);
        $response->assertSee('Bagikan berita ini');
        $response->assertSee('wa.me', false);
        $response->assertSee(route('news.show', $news->id), false);
        // Meta SEO untuk sharelink
        $response->assertSee('og:title', false);
        $response->assertSee('NewsArticle', false);
    }

    public function test_homepage_links_to_news_detail(): void
    {
        $news = $this->makeNews();

        $this->get('/')->assertStatus(200)->assertSee(route('news.show', $news->id), false);
    }

    public function test_activity_detail_page_renders(): void
    {
        $activity = Activity::create([
            'title' => 'Kegiatan Uji',
            'date' => now()->toDateString(),
            'location' => 'Balai Desa',
            'description' => 'Deskripsi lengkap kegiatan uji coba.',
        ]);

        $this->get(route('activities.show', $activity->id))
            ->assertStatus(200)
            ->assertSee('Kegiatan Uji')
            ->assertSee('Bagikan kegiatan ini');
    }

    public function test_feedback_honeypot_rejects_spam(): void
    {
        $response = $this->post(route('feedback.store'), [
            'name' => 'Bot Spam',
            'contact' => '08123456789',
            'message' => 'Pesan spam yang cukup panjang agar lolos validasi panjang.',
            'website' => 'http://spam.example',
        ]);

        $response->assertSessionHasErrors('website');
        $this->assertDatabaseMissing('feedbacks', ['name' => 'Bot Spam']);
    }

    public function test_feedback_rejects_short_message(): void
    {
        $response = $this->post(route('feedback.store'), [
            'name' => 'Warga Asli',
            'message' => 'Singkat',
        ]);

        $response->assertSessionHasErrors('message');
        $this->assertDatabaseCount('feedbacks', 0);
    }

    public function test_feedback_accepts_valid_input(): void
    {
        $response = $this->post(route('feedback.store'), [
            'name' => 'Warga Asli',
            'contact' => '08123456789',
            'message' => 'Masukan yang jelas dan cukup panjang untuk kemajuan bersama.',
        ]);

        $response->assertRedirect('/#saran');
        $this->assertDatabaseHas('feedbacks', ['name' => 'Warga Asli']);
    }

    public function test_feedback_throttle_blocks_flooding(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('feedback.store'), [
                'name' => "Warga {$i} Banjir",
                'message' => 'Masukan yang jelas dan cukup panjang untuk kemajuan bersama.',
            ])->assertRedirect('/#saran');
        }

        // Upaya ke-6 dalam 10 menit harus ditolak (429)
        $this->post(route('feedback.store'), [
            'name' => 'Warga Banjir Enam',
            'message' => 'Masukan yang jelas dan cukup panjang untuk kemajuan bersama.',
        ])->assertStatus(429);
    }

    public function test_login_rate_limit_blocks_brute_force(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post(route('login.post'), [
                'email' => 'penyerang@example.com',
                'password' => 'tebakan-salah',
            ]);
        }

        // Upaya ke-6 harus kena throttle (429) atau pesan kunci login
        $this->assertTrue(
            $response->status() === 429 || str_contains($response->getContent(), 'Terlalu banyak'),
            'Login beruntun harus diblokir rate-limit.'
        );
        $this->assertGuest();
    }
}
