<?php

namespace Tests\Feature\Photo;

use App\Photo;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SearchPhotoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_search_photos_by_tag()
    {
        $tag = factory(Tag::class)->create(['name' => 'example-tag']);
        $photoA = factory(Photo::class)->create(['title' => 'Example photo titleA']);
        $photoB = factory(Photo::class)->create(['title' => 'Example photo titleB']);
        $photoA->tag($tag);
        $photoB->tag($tag);

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson('/search', [
                'tags' => 'example-tag'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'title' => 'Example photo titleA',
                    'tags'  => [
                        'example-tag'
                    ]
                ],
                [
                    'title' => 'Example photo titleB',
                    'tags'  => [
                        'example-tag'
                    ]
                ]
            ]
        ]);
    }
}
