<?php

namespace Tests\Feature\Tag;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateTagTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_create_a_tag()
    {
        $response = $this->actingAs(factory(User::class)->create())
            ->post('/tags', [
                'name' => 'Example tag'
            ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name' => 'Example tag'
            ]
        ]);
    }

    /** @test */
    public function guest_cannot_create_a_tag()
    {
        $response = $this->post('/tags', [
            'name' => 'Example tag'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function name_tag_should_be_required()
    {
        $response = $this->actingAs(factory(User::class)->create())
            ->post('/tags', [
                'name' => ''
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function name_tag_max_should_be_255()
    {
        $response = $this->actingAs(factory(User::class)->create())
            ->post('/tags', [
                'name' => str_repeat('a', 256)
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function name_tag_should_be_a_string()
    {
        $response = $this->actingAs(factory(User::class)->create())
            ->post('/tags', [
                'name' => 1234
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }
}
