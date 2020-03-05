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
            'description' => 'Description of the announcement'
            ]);
    }

}
