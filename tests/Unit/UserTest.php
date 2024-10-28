<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * @test
     */
    public function a_user_has_projects(): void
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
