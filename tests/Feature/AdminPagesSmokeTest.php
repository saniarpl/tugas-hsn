<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_admin_pages_render_without_server_error(): void
    {
        $user = User::factory()->create();

        $routes = [
            'admin.dashboard',
            'admin.carousels.index',
            'admin.news.index',
            'admin.activities.index',
            'admin.committees.index',
            'admin.members.index',
            'admin.donations.index',
            'admin.galleries.index',
            'admin.feedbacks.index',
        ];

        foreach ($routes as $route) {
            $this->actingAs($user)
                ->get(route($route))
                ->assertOk();
        }
    }

    public function test_all_public_pages_render_without_server_error(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('gallery'))->assertOk();

        foreach (['ipnu', 'ippnu', 'fatayat', 'muslimat', 'banser'] as $slug) {
            $this->get(route('organization.detail', $slug))->assertOk();
        }
    }
}
