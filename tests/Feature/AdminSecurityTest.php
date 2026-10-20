<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    /** JPEG 1x1 valid untuk uji upload tanpa ekstensi GD. */
    private const PIXEL_JPEG = '/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////wgALCAABAAEBAQEBAQAAAAAAAAAAAAAAwgACAAEDBAQDAQEBAQEBAQAAAAAAAAECAwQFBgcICQoLEAACAQMDAgIDAwEAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAX/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oACAEBAAEFAn//xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oACAEBAAEWF//Z';

    public function test_admin_news_store_works_and_ignores_injected_fields(): void
    {
        $user = User::factory()->create(['name' => 'Admin Uji']);

        $response = $this->actingAs($user)->post(route('admin.news.store'), [
            'title' => 'Berita Admin Baru',
            'content' => 'Isi konten yang cukup panjang untuk validasi admin.',
            'status' => 'published',
            'slug' => 'diambil-alih',
            'author' => 'Penyerang',
        ]);

        $response->assertRedirect();
        $news = News::where('title', 'Berita Admin Baru')->firstOrFail();
        $this->assertSame('berita-admin-baru', $news->slug);
        $this->assertSame('Umum', $news->category);
        $this->assertSame('Admin Uji', $news->author);
        $this->assertSame('draft', $news->status);
    }

    public function test_admin_news_update_keeps_slug_stable(): void
    {
        $user = User::factory()->create();
        $news = News::create([
            'title' => 'Judul Lama', 'slug' => 'judul-lama', 'category' => 'Umum',
            'content' => 'Isi lama.', 'author' => 'Admin',
        ]);

        $this->actingAs($user)
            ->put(route('admin.news.update', $news->id), [
                'title' => 'Judul Baru',
                'content' => 'Isi baru yang cukup.',
                'slug' => 'coba-ganti',
            ])
            ->assertRedirect();

        $this->assertSame('judul-lama', $news->fresh()->slug);
        $this->assertSame('Judul Baru', $news->fresh()->title);
    }

    public function test_member_store_ignores_extra_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.members.store'), [
            'name' => 'Warga Uji',
            'nik' => '1234567890',
            'phone' => '08123456789',
            'address' => 'RT 01 RW 02 Windunegara',
            'role' => 'admin',
            'is_admin' => true,
        ])->assertRedirect();

        $this->assertDatabaseHas('members', ['name' => 'Warga Uji', 'nik' => '1234567890']);
    }

    public function test_donation_store_ignores_extra_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.donations.store'), [
            'name' => 'Hamba Allah',
            'amount' => 50000,
            'date' => now()->toDateString(),
            'status' => 'approved',
        ])->assertRedirect();

        $this->assertDatabaseHas('donations', ['name' => 'Hamba Allah', 'amount' => 50000]);
    }

    public function test_detail_routes_reject_non_numeric_ids(): void
    {
        $this->get('/berita/1x')->assertNotFound();
        $this->get('/berita/1%20OR%201=1')->assertNotFound();
        $this->get('/kegiatan/2y')->assertNotFound();
    }

    public function test_admin_news_rejects_shell_upload(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.news.store'), [
            'title' => 'Uji Shell',
            'content' => 'Isi konten yang cukup panjang untuk validasi admin.',
            'image' => UploadedFile::fake()->create('shell.php', 100, 'application/x-php'),
        ]);

        $response->assertSessionHasErrors('image');
        $this->assertCount(0, Storage::disk('public')->allFiles('news'));
        $this->assertDatabaseMissing('news', ['title' => 'Uji Shell']);
    }

    public function test_admin_news_double_extension_is_neutralized(): void
    {
        // File bernama shell.php.jpg berisi JPEG valid: validasi lolos,
        // tetapi store() membuang nama penyerang -> tersimpan sebagai hash acak berekstensi .jpg
        Storage::fake('public');
        $user = User::factory()->create();

        $path = tempnam(sys_get_temp_dir(), 'upl') . '.jpg';
        file_put_contents($path, base64_decode(self::PIXEL_JPEG));
        $file = new UploadedFile($path, 'shell.php.jpg', 'image/jpeg', null, true);

        $this->actingAs($user)->post(route('admin.news.store'), [
            'title' => 'Uji Ganda',
            'content' => 'Isi konten yang cukup panjang untuk validasi admin.',
            'image' => $file,
        ])->assertRedirect();

        $news = News::where('title', 'Uji Ganda')->firstOrFail();
        $this->assertStringNotContainsString('shell', $news->image);
        $this->assertStringNotContainsString('.php', $news->image);
        $this->assertMatchesRegularExpression('#^news/[A-Za-z0-9]+\.jpe?g$#', $news->image);
    }

    public function test_admin_news_accepts_valid_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        // JPEG 1x1 asli tanpa ekstensi GD
        $path = tempnam(sys_get_temp_dir(), 'upl') . '.jpg';
        file_put_contents($path, base64_decode(self::PIXEL_JPEG));

        $this->actingAs($user)->post(route('admin.news.store'), [
            'title' => 'Berita Bergambar',
            'content' => 'Isi konten yang cukup panjang untuk validasi admin.',
            'image' => new UploadedFile($path, 'foto.jpg', 'image/jpeg', null, true),
        ])->assertRedirect();

        $news = News::where('title', 'Berita Bergambar')->firstOrFail();
        Storage::disk('public')->assertExists($news->image);
    }

    public function test_jsonld_escapes_script_breakout(): void
    {
        $news = News::create([
            'title' => 'Uji </script><script>alert(1)</script>',
            'slug' => 'uji-xss-jsonld',
            'category' => 'Umum',
            'content' => 'Isi aman.',
            'author' => 'Admin',
        ]);

        $response = $this->get(route('news.show', $news->id));

        $response->assertStatus(200);
        $response->assertDontSee('</script><script>alert(1)', false);
        $response->assertSee('\u003C/script\u003E', false);
    }
}
