<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;

class Announcement extends Model
{
    protected $fillable = ['title', 'description'];

    public function photos() {
        return $this->hasMany(Photo::class);
    }
}
