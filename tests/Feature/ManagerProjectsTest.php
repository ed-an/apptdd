<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ManagerProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guest_cannot_manage_projects()
    {

        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get('/projects/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_create_a_project() : void
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here'
        ];

        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();

        $response->assertRedirect($response = $project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project() : void
    {

        $project = ProjectFactory::create();
        $attributes = [ 'title'=>'changed', 'description'=>'changed','notes' => 'Changed' ];
        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes);
        $this->patch($project->path(), $attributes);


        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);

    }


    /**
     * @test
     */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();
        $attributes = [ 'notes' => 'Changed' ];
        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes);

        $this->assertDatabaseHas('projects', $attributes);

    }
    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {

        $this->signIn();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee(substr($project->description, 0 ,100));

    }

    /**
     * @test
     */
    public function an_authenticate_user_cannot_view_the_project_of_others()
    {

        $this->signIn();
        $project = ProjectFactory::create();
        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test
     */
    public function an_authenticate_user_cannot_update_the_project_of_others()
    {

        $this->signIn();
        $project = Project::factory()->create();
        $this->patch($project->path(),[])->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_projects_require_title()
    {
        $this->signIn();
        //$this->actingAs(User::factory()->create());
        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_projects_require_description()
    {
        //$this->actingAs(User::factory()->create());
        $this->signIn();
        $attributes = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


    /**
     * @test
     */
    public function a_projects_require_owner()
    {
        //$this->withoutExceptionHandling();
        $attributes = Project::factory()->raw();
        $this->post('/projects', $attributes)->assertRedirect('login');
    }


}
