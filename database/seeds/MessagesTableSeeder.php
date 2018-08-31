<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::all()->shuffle()->each(function (User $user) {
            factory(Message::class, random_int(0, 2))->create([
                'user_id' => $user->id,
            ])->shuffle()->each(function (Message $message) {
                factory(Message::class, random_int(0, 3))->create([
                    'parent_id' => $message->id,
                    'user_id' => User::inRandomOrder()->first()->id,
                ]);
            });
        });
    }
}
