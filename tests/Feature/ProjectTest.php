<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Passport::actingAs(
            factory(Client::class)->create(),
            ['*']
        );
    }

    public function testProjectIndex()
    {
        $response = $this->get('/api/v1/projects');
        $response->assertStatus(200);
    }

    public function testProjectShow()
    {
        $project = factory(Project::class)->create();
        $response = $this->get('/api/v1/projects/' . $project->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'          => $project->id,
                    'name'        => $project->name,
                    'description' => $project->description,
                    'status'      => $project->status
                ]
            ]);
    }

    public function testProjectStore()
    {
        $payload = [
            'name' => 'name',
            'description' => 'description',
            'status' => Project::PLANNED,
        ];

        $response = $this->post('/api/v1/projects/', $payload);
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $payload['name'],
                    'description' => $payload['description'],
                    'status' => Project::PLANNED,
                ]
            ]);
    }

    public function testProjectUpdate()
    {
        $project = factory(Project::class)->create();
        $newData = [
            'name' => 'name_name',
            'status' => Project::PLANNED
        ];

        $response = $this->patch('/api/v1/projects/'. $project->id, $newData);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $newData['name'],
                    'status' => $newData['status']
                ]
            ]);
    }

    public function testProjectDelete()
    {
        $project = factory(Project::class)->create();
        $response = $this->delete('/api/v1/projects/'. $project->id);
        $response->assertStatus(204);
    }
}
