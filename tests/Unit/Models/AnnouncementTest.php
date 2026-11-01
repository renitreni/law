<?php

namespace Tests\Unit\Models;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_announcement_can_be_created()
    {
        $user = User::factory()->create();
        $announcement = Announcement::factory()->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('announcements', [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'description' => $announcement->description,
            'type' => $announcement->type,
            'user_id' => $user->id,
            'is_read' => false,
        ]);
    }

    public function test_announcement_uses_soft_deletes()
    {
        $user = User::factory()->create();
        $announcement = Announcement::factory()->create(['user_id' => $user->id]);
        $announcement->delete();

        $this->assertSoftDeleted('announcements', ['id' => $announcement->id]);
    }

    public function test_announcement_belongs_to_user()
    {
        $user = User::factory()->create();
        $announcement = Announcement::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $announcement->user);
        $this->assertEquals($user->id, $announcement->user->id);
    }

    public function test_announcement_default_type_is_reminder()
    {
        $user = User::factory()->create();
        $announcement = Announcement::factory()->create(['user_id' => $user->id]);

        $this->assertEquals('reminder', $announcement->type);
    }
}
