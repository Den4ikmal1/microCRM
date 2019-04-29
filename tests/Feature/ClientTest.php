<?php

namespace Tests\Feature;

use App\Models\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testClientIndex()
    {
        Passport::actingAs(
            factory(Client::class)->create(),
            ['*']
        );

        $response = $this->get('/api/v1/clients');
        $response->assertStatus(200);
    }

    public function testClientShow()
    {
        $client = Passport::actingAs(
            factory(Client::class)->create(),
            ['*']
        );

        $response = $this->get('/api/v1/clients/' . $client->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'         => $client->id,
                    'first_name' => $client->first_name,
                    'last_name'  => $client->last_name,
                    'email'      => $client->email
                ]
            ]);
    }

    public function testClientStore()
    {
        Passport::actingAs(
            factory(Client::class)->create(),
            ['*']
        );

        $payload = [
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            'email' => 'admin@example211.com',
            'password' => bcrypt('secret'),
            'password_confirmation' => bcrypt('secret')
        ];

        $response = $this->post('/api/v1/clients/', $payload);
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'first_name' => $payload['first_name'],
                    'last_name'  => $payload['last_name'],
                    'email'      => $payload['email'],
                ]
            ]);
    }

    public function testClientUpdate()
    {
        $client = Passport::actingAs(
            factory(Client::class)->create(),
            ['*']
        );
        $newData = [
            'first_name' => 'Daniel',
            'last_name' => $client->last_name,
            'email' => $client->email
        ];

        $response = $this->patch('/api/v1/clients/'. $client->id, $newData);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'first_name' => $newData['first_name'],
                ]
            ]);
    }
}
