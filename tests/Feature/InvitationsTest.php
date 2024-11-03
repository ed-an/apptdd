<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectsTasksController;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
class InvitationsTest extends TestCase
{
    use  RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function a_project_can_invite_a_user()
    {

        $project = ProjectFactory::create();
        $project->invite($newUser = User::factory()->create());
        $this->actingAs($newUser)
            ->post(action([ProjectsTasksController::class, 'store'], $project), $task = ['body' => 'Foo task']);
        $this->assertDatabaseHas('tasks', $task);
    }
}
