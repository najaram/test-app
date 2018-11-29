<?php

namespace Tests\Feature\Photo;

use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoUploadTest extends TestCase
{
    use DatabaseMigrations;

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Example title',
            'photo' => UploadedFile::fake()->image('image.jpg')
        ], $overrides);
    }

    /** @test */
    public function user_can_upload_a_photo_with_a_tag()
    {
        Storage::fake('local');
        $user = factory(User::class)->create();
        $tag = factory(Tag::class)->create(['name' => 'example-tag']);

        $response = $this->actingAs($user)
            ->post('/photo', [
                'user_id' => $user->id,
                'title'   => 'Example title',
                'photo'   => UploadedFile::fake()->image('image.jpg'),
                'tags'    => $tag->id
            ]);

        $response->assertJson([
            'data' => [
                'title'     => 'Example title',
                'file_name' => 'image.jpg',
                'path'      => 'http://test-app.test/photo/1/preview/',
                'tags'      => [
                    'example-tag'
                ]
            ]
        ]);
    }

    /** @test */
    public function user_can_upload_a_photo_without_a_tag()
    {
        Storage::fake('local');
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/photo', [
                'user_id' => $user->id,
                'title'   => 'Example title',
                'photo'   => UploadedFile::fake()->image('image.jpg'),
                'tags'    => ''
            ]);

        $response->assertJson([
            'data' => [
                'title'     => 'Example title',
                'file_name' => 'image.jpg',
                'path'      => 'http://test-app.test/photo/1/preview/',
                'tags'      => []
            ]
        ]);
    }

    /** @test */
    public function user_can_upload_a_photo_with_multiple_tags()
    {
        Storage::fake('local');
        $user = factory(User::class)->create();
        $tagA = factory(Tag::class)->create(['name' => 'example-tag-A']);
        $tagB = factory(Tag::class)->create(['name' => 'example-tag-B']);

        $response = $this->actingAs($user)
            ->post('/photo', [
                'user_id' => $user->id,
                'title'   => 'Example title',
                'photo'   => UploadedFile::fake()->image('image.jpg'),
                'tags'    => [$tagA->id, $tagB->id]
            ]);

        $response->assertJson([
            'data' => [
                'title'     => 'Example title',
                'file_name' => 'image.jpg',
                'path'      => 'http://test-app.test/photo/1/preview/',
                'tags'      => [
                    'example-tag-A',
                    'example-tag-B',
                ]
            ]
        ]);
    }

    /** @test */
    public function guest_user_cannot_upload_image()
    {
        $response = $this->post('/photo', $this->validParams());

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_id_should_exists_on_users_table_to_upload_an_image()
    {
        $response = $this->post('/photo', $this->validParams([
            'user_id' => 1234
        ]));

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function photo_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/photo', $this->validParams([
                'photo' => ''
            ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('photo');
    }

    /** @test */
    public function photo_is_should_be_a_file()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('/photo', $this->validParams([
                'photo' => 'invalid-photo'
            ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('photo');
    }


}
