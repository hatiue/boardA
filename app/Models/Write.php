<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Write extends Model
{
    use HasFactory;

    public function threads()
    {
        return $this->belongsTo(Thread::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'write_images')->using(WriteImage::class);
    }
}
