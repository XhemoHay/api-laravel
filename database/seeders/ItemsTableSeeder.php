<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Item;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Create 10 items for each user
        foreach ($users as $user) {
            Item::factory()->count(10)->create([
                'user_id' => $user->id,
            ]); 
    }
}
}
