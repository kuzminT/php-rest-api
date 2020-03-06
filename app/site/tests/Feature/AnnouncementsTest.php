<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\User;
use \App\Announcement;

//use Faker\Generator as Faker;
//use Faker\Factory;


class AnnouncementsTest extends TestCase
{
//    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsAnnouncementsAreCreatedCorrectly()
    {

        $payload = [
            'title' => 'Lorem',
            'price' => 12.37,
            'user_id' => 1,
            'description' => 'Description of the announcement',
            'photos' => ['https://lorempixel.com/640/480/cats/?28427', 'https://lorempixel.com/640/480/cats/?71114',
                'https://lorempixel.com/640/480/cats/?45117'
            ],
        ];


        $this->json('POST', '/api/announcements', $payload)
            ->assertStatus(201)
            ->assertJson(['user_id' => 1, 'title' => 'Lorem', 'price' => 12.37,
                'description' => 'Description of the announcement', 'main_photo'
                => 'https://lorempixel.com/640/480/cats/?28427']);

        $this->assertDatabaseHas('announcements', ['user_id' => 1, 'title' => 'Lorem', 'price' => 12.37,
            'description' => 'Description of the announcement',
            'id' => 51
        ]);

        // @todo check return some id without one hardcoded number
    }


    public function testsIncorrectDataStore()
    {
        $faker = \Faker\Factory::create();

        $payload = [
            'title' => $faker->sentence(100, '.'),
//            'price' => 12.37,
            'user_id' => 1,
            'description' => 'Description of the announcement',
            'photos' => ['https://lorempixel.com/640/480/cats/?28427', 'https://lorempixel.com/640/480/cats/?71114',
                'https://lorempixel.com/640/480/cats/?45117',
            ],
        ];

        $payload_without_title = $payload;

        unset($payload_without_title['title']);

        $response = $this->json('POST', '/api/announcements', $payload_without_title)
            ->assertStatus(422);

        $response->assertJsonFragment(['message' => 'The given data was invalid.',
        ]);

        $response->assertJson([
            'errors' => [
                'title' => [
                    'The title field is required.',
                ],
                "price" => [
                    "The price field is required."
                ]
            ]
        ]);

        $payload['description'] = $faker->text(2000);

        $payload['photos'][] = 'https://lorempixel.com/640/480/cats/?123343';

        $response = $this->json('POST', '/api/announcements', $payload)
            ->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'title' => [
                    "The title may not be greater than 200 characters.",
                ],
                "price" => [
                    "The price field is required."
                ],
                'description' => [
                    "The description may not be greater than 1000 characters.",
                ],
                'photos' => [
                    "The photos may not have more than 3 items."
                ],
            ]
        ]);

    }

    public function testsGetAnnouncementWithoutFields()
    {
        $response = $this->json('GET', '/api/announcements/1', [])
            ->assertStatus(200);

        $responseArr = json_decode($response->getContent(), true);
        $this->assertArrayNotHasKey('description', $responseArr['data']);
        $this->assertArrayNotHasKey('photos', $responseArr['data']);

    }

    public function testsGetAnnouncementWithFields()
    {

        $id = \random_int(1, 50);

        $response = $this->json('GET', "/api/announcements/{$id}",
            ['fields' => ['description', 'photos']])
            ->assertStatus(200);

        $responseArr = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('description', $responseArr['data']);
        $this->assertArrayHasKey('photos', $responseArr['data']);

//        $response->dump();

    }

    public function testsAnnouncementsAreListedCorrectly()
    {
        $ann_data = [
            [
                'title' => 'First Announcement',
                'price' => '30.10',
                'description' => 'First Description'],
            [
                'title' => 'Second Announcement',
                'description' => 'Second Description',
                'price' => '10.12',
            ]
        ];

        $photo_data = [
            ['url' => 'https://lorempixel.com/640/480/cats/?28427'],
            ['url' => 'https://lorempixel.com/640/480/cats/?45117']
        ];

        factory(Announcement::class)->create($ann_data[0])->photos()
            ->create($photo_data[0]);

        factory(Announcement::class)->create($ann_data[1])->photos()->create($photo_data[1]);

        $response = $this->json('GET', '/api/announcements', [])
            ->assertStatus(200);

//        $response->dump();

//        $response->assertJsonStructure([
//                '*' => ['id', 'price', 'title', 'created_at', 'main_photo'],
//            ]);

        $response->assertJsonFragment([
            'title' => $ann_data[1]['title'],
            'price' => $ann_data[1]['price'],
            'main_photo' => $photo_data[1]['url'],
        ]);

        $response->assertJsonFragment([
            'title' => $ann_data[0]['title'],
            'price' => $ann_data[0]['price'],
            'main_photo' => $photo_data[0]['url'],
        ]);

//        $response->assertJson([
//                [
//                    'title' => $ann_data[1]['title']
//                ],
//                [
//                    'title' => $ann_data[0]['title']
//                ],
//            ], false
//        );

//            ->assertJsonStructure([
//                '*' => ['id', 'price', 'title', 'created_at', 'main_photo'],
//            ]);

    }

    public function testsAnnouncementsSortedCorrectly()
    {
        $response = $this->json('GET', '/api/announcements', ['sort' => '-price'])
            ->assertStatus(200);

        $responseArr = json_decode($response->getContent(), true);

        $this->assertLessThanOrEqual($responseArr['data'][0]['price'], $responseArr['data'][3]['price']);

        $this->assertLessThanOrEqual($responseArr['data'][3]['price'], $responseArr['data'][6]['price']);

        $response = $this->json('GET', '/api/announcements', ['sort' => 'created_at'])
            ->assertStatus(200);
    }


}
