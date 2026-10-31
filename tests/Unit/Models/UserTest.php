<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Announcement;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_user_has_announcements_relationship()
    {
        $user = User::factory()->create();
        Announcement::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->announcements);
    }

    public function test_user_hides_password_and_remember_token()
    {
        $user = User::factory()->create([
            'password' => 'secret123',
            'remember_token' => 'token123',
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    public function test_user_casts_email_verified_at()
    {
        $user = User::factory()->create([
            'email_verified_at' => '2024-01-15 10:30:00',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->email_verified_at);
    }
}