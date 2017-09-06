<?php

use Illuminate\Database\Seeder;
use App\Model\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = "admin@takemitsu.net";
        $user = User::where('email', $email)->first();
        if($user == null) {
            $user = new User;
            $user->name = "admin";
            $user->email = $email;
            $user->password = bcrypt('secret');
            $user->is_admin = true;
            $user->save();
        }

        // 50 件ほど Dummy Data を追加
        if(config('app.debug'))
            factory(App\Model\User::class, 50)->create();
    }
}
