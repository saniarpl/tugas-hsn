<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Committee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminActivityCommitteeCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_activity(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.activities.store'), [
            'title' => 'Kerja Bakti Masjid',
            'date' => '2026-11-10',
            'location' => 'Masjid Baiturrahman',
            'description' => 'Bersih-bersih lingkungan masjid bersama warga.',
        ])->assertRedirect();

        $activity = Activity::where('title', 'Kerja Bakti Masjid')->firstOrFail();
        $this->assertSame('Masjid Baiturrahman', $activity->location);

        $this->actingAs($user)->put(route('admin.activities.update', $activity), [
            'title' => 'Kerja Bakti Masjid (Revisi)',
            'date' => '2026-11-11',
            'location' => 'Balai Desa',
            'description' => 'Jadwal dan lokasi diperbarui.',
        ])->assertRedirect();

        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'Kerja Bakti Masjid (Revisi)',
            'location' => 'Balai Desa',
        ]);

        $this->actingAs($user)
            ->delete(route('admin.activities.destroy', $activity))
            ->assertRedirect();

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }

    public function test_activity_can_be_saved_without_location(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.activities.store'), [
            'title' => 'Agenda Tanpa Lokasi',
            'date' => '2026-11-12',
            'description' => 'Lokasi boleh dikosongkan.',
        ])->assertRedirect();

        $this->assertDatabaseHas('activities', [
            'title' => 'Agenda Tanpa Lokasi',
            'location' => null,
        ]);
    }

    public function test_admin_can_create_update_and_delete_committee(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.committees.store'), [
            'name' => 'Ahmad Fauzi',
            'position' => 'Ketua IPNU',
            'organization' => 'IPNU',
            'period' => '2026-2028',
            'type' => 'Syuriyah',
        ])->assertRedirect();

        $committee = Committee::where('name', 'Ahmad Fauzi')->firstOrFail();
        $this->assertSame('ipnu', $committee->organization);
        $this->assertSame('2026-2028', $committee->period);
        $this->assertSame('Syuriyah', $committee->type);

        $this->actingAs($user)->put(route('admin.committees.update', $committee), [
            'name' => 'Ahmad Fauzi (Revisi)',
            'position' => 'Bendahara Banser',
            'organization' => 'Banser',
            'period' => '2027-2029',
            'type' => 'Tanfidziyah',
        ])->assertRedirect();

        $this->assertDatabaseHas('committees', [
            'id' => $committee->id,
            'name' => 'Ahmad Fauzi (Revisi)',
            'organization' => 'banser',
            'period' => '2027-2029',
            'type' => 'Tanfidziyah',
        ]);

        $this->actingAs($user)
            ->delete(route('admin.committees.destroy', $committee))
            ->assertRedirect();

        $this->assertDatabaseMissing('committees', ['id' => $committee->id]);
    }

    public function test_activity_and_committee_pages_render_for_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.activities.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.committees.index'))->assertOk();
    }

    public function test_organization_page_matches_legacy_uppercase_organization(): void
    {
        DB::table('committees')->insert([
            'name' => 'Pengurus Lama',
            'position' => 'Ketua',
            'organization' => 'IPNU',
            'period' => '2024-2026',
            'type' => 'Syuriyah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->get(route('organization.detail', 'ipnu'))
            ->assertOk()
            ->assertSee('Pengurus Lama');
    }
}
