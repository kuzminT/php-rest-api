<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'description', 'price'];

    public function photos() {
        return $this->hasMany(Photo::class);
    }
}
