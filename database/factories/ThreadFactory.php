<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => "Test Title",
            'flg_not_writable' => 0, // 書き込み可（1で不可）
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
