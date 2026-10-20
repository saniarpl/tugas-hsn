<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GallerySmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_gallery_section(): void
    {
        Gallery::create(['title' => 'Foto Uji', 'image' => 'galleries/uji.jpg']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Galeri Kegiatan');
        $response->assertSee('Foto Uji');
        $response->assertSee('galeriSection');
    }

    public function test_gallery_page_renders(): void
    {
        Gallery::create(['title' => 'Foto Uji', 'image' => 'galleries/uji.jpg']);

        $response = $this->get('/galeri');

        $response->assertStatus(200);
        $response->assertSee('Galeri Kegiatan NU Windunegara');
    }

    public function test_admin_galleries_requires_auth_and_renders_for_admin(): void
    {
        $this->get('/admin/galleries')->assertRedirect('/login');

        $user = User::factory()->create();
        $this->actingAs($user)->get('/admin/galleries')->assertStatus(200);
        $this->actingAs($user)->get('/admin/dashboard')->assertSee('Galeri Foto');
    }
}
