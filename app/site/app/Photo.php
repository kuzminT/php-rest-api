<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Announcement;

class Photo extends Model
{
    protected $fillable = ['url', 'announcement_id'];

    /**
     * Get the user that owns the phone.
     */
    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}
