<?php

use App\Photo;
use App\User;
use App\Announcement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Photo::query()->delete();
        Announcement::query()->delete();
        User::query()->delete();

        $this->call(UsersTableSeeder::class);
        $this->call(AnnouncementsTableSeeder::class);
        $this->call(PhotosTableSeeder::class);
    }
}
