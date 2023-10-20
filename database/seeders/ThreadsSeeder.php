<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Thread;
use App\Models\Write;

class ThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Thread::factory()->count(1)->create();
        Write::factory()->count(5)->create();
        // 画像のシーディングは行わない
        // ->each(fn($write) => Image::factory()->count(4)->create()->each(fn($image => $write->images()->attach($image->id)));
    }
}
