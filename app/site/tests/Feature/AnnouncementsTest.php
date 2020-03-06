<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\User;
use \App\Announcement;

class AnnouncementsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsAnnouncementsAreCreateCorrectly()
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

    // @todo Add test to create Announcement with incorrect data

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

//        print_r($response);

//            ->assertJsonStructure([
//                '*' => ['id', 'price', 'title', 'created_at', 'main_photo'],
//            ]);

    }

}
