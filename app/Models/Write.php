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
}
