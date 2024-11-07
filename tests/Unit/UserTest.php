<?php

namespace Tests\Unit;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
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

    /**
     * @test
     */
    public function a_user_has_accesible_projects()
    {
        $john= $this->signIn();
        ProjectFactory::ownedBy($john)->create();
        $this->assertCount(1, $john->accessibleProjects());

        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $project = tap(ProjectFactory::ownedBy($sally)->create())->invite($nick);
        $this->assertCount(1, $john->accessibleProjects());

        $project->invite($john);
        $this->assertCount(2, $john->accessibleProjects());

    }

}
