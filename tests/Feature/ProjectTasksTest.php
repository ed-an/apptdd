<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Facades\Tests\Setup\ProjectFactory;

use Tests\TestCase;


class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();
        $this->post($project->path(). '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $body = ['body' => 'Lorem ipsum'];
        $this->post($project->path(). '/tasks', $body)->assertStatus(403);
        $this->assertDatabaseMissing(  'tasks', $body);

    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();

        $project= ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks[0]->path() , ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing(  'tasks', ['body' => 'changed']);

    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
        ]);
    }
    /** @test */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_completed()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }
    /** @test */
    public function a_projec_can_have_tasks()
    {

        $project= ProjectFactory::create();
        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');

    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project= ProjectFactory::create();

        $attributes = Task::factory()->raw(['body' => '']);
        $this->actingAs($project->owner)
            ->post($project->path().'/tasks', $attributes)
            ->assertSessionHasErrors('body');

    }
}
