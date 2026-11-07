<?php

namespace Tests\Feature;

use App\Models\Carousel;
use App\Models\Donation;
use App\Models\Feedback;
use App\Models\Gallery;
use App\Models\Member;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudCoverageTest extends TestCase
{
    use RefreshDatabase;

    /** JPEG 1x1 valid agar tidak bergantung pada ekstensi GD. */
    private const PIXEL_JPEG = '/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////wgALCAABAAEBAQEBAQAAAAAAAAAAAAAAwgACAAEDBAQDAQEBAQEBAQAAAAAAAAECAwQFBgcICQoLEAACAQMDAgIDAwEAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAX/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oACAEBAAEFAn//xAAUEAEAAAAAAAAAAAAAAAAAAAAA/9oACAEBAAEWF//Z';

    public function test_carousel_crud_works_and_cleans_up_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.carousels.store'), [
            'title' => 'Banner Uji',
            'description' => 'Deskripsi banner uji.',
            'image' => $this->jpeg('banner.jpg'),
        ])->assertRedirect();

        $carousel = Carousel::where('title', 'Banner Uji')->firstOrFail();
        Storage::disk('public')->assertExists($carousel->image);

        $this->actingAs($user)->put(route('admin.carousels.update', $carousel), [
            'title' => 'Banner Uji Revisi',
            'description' => 'Deskripsi baru.',
        ])->assertRedirect();

        $this->assertDatabaseHas('carousels', ['id' => $carousel->id, 'title' => 'Banner Uji Revisi']);

        $oldImage = $carousel->image;
        $this->actingAs($user)->delete(route('admin.carousels.destroy', $carousel))->assertRedirect();

        $this->assertDatabaseMissing('carousels', ['id' => $carousel->id]);
        Storage::disk('public')->assertMissing($oldImage);
    }

    public function test_gallery_upload_and_delete_works(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.galleries.store'), [
            'title' => 'Foto Uji',
            'image' => $this->jpeg('galeri.jpg'),
        ])->assertRedirect();

        $gallery = Gallery::where('title', 'Foto Uji')->firstOrFail();
        Storage::disk('public')->assertExists($gallery->image);

        $this->actingAs($user)->delete(route('admin.galleries.destroy', $gallery))->assertRedirect();

        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
        Storage::disk('public')->assertMissing($gallery->image);
    }

    public function test_member_update_delete_and_card_page_work(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $member = Member::create([
            'name' => 'Warga Uji',
            'nik' => '3302111000000099',
            'phone' => '081200000099',
            'address' => 'RT 01 RW 02',
        ]);

        $this->actingAs($user)
            ->get(route('admin.members.card', $member->id))
            ->assertOk()
            ->assertSee('Warga Uji');

        $this->actingAs($user)->put(route('admin.members.update', $member), [
            'name' => 'Warga Uji Revisi',
            'nik' => '3302111000000099',
            'phone' => '081200000099',
            'address' => 'RT 03 RW 04',
        ])->assertRedirect();

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'name' => 'Warga Uji Revisi',
            'address' => 'RT 03 RW 04',
        ]);

        $this->actingAs($user)->delete(route('admin.members.destroy', $member))->assertRedirect();
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    public function test_donation_update_and_delete_work(): void
    {
        $user = User::factory()->create();
        $donation = Donation::create([
            'name' => 'Hamba Allah',
            'amount' => 50000,
            'date' => '2026-11-06',
        ]);

        $this->actingAs($user)->put(route('admin.donations.update', $donation), [
            'name' => 'Hamba Allah Revisi',
            'amount' => 75000,
            'date' => '2026-11-07',
        ])->assertRedirect();

        $this->assertDatabaseHas('donations', [
            'id' => $donation->id,
            'name' => 'Hamba Allah Revisi',
            'amount' => 75000,
        ]);

        $this->actingAs($user)->delete(route('admin.donations.destroy', $donation))->assertRedirect();
        $this->assertDatabaseMissing('donations', ['id' => $donation->id]);
    }

    public function test_news_and_feedback_delete_work(): void
    {
        $user = User::factory()->create();
        $news = News::create([
            'title' => 'Berita Hapus',
            'slug' => 'berita-hapus',
            'category' => 'Umum',
            'content' => 'Konten berita yang akan dihapus.',
            'author' => 'Admin',
        ]);
        $feedback = Feedback::create([
            'name' => 'Pengunjung',
            'contact' => '081200000000',
            'message' => 'Masukan yang akan dihapus.',
        ]);

        $this->actingAs($user)->delete(route('admin.news.destroy', $news))->assertRedirect();
        $this->actingAs($user)->delete(route('admin.feedbacks.destroy', $feedback->id))->assertRedirect();

        $this->assertDatabaseMissing('news', ['id' => $news->id]);
        $this->assertDatabaseMissing('feedbacks', ['id' => $feedback->id]);
    }

    private function jpeg(string $name): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'upl').'.jpg';
        file_put_contents($path, base64_decode(self::PIXEL_JPEG));

        return new UploadedFile($path, $name, 'image/jpeg', null, true);
    }
}
