<?php

use Illuminate\Database\Seeder;
use App\Announcement;

class AnnouncementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Announcement::class, 50)->create();

    }
}
