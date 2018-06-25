<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // factory(App\User::class, 10)->create()->each(function($user){
        // 	$user->posts()->save(factory(App\Post::class)->make());
        // });
        // factory(App\User::class, 10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // DB::table('users')->truncate();
        DB::table('posts')->truncate();
       	factory(App\User::class, 10)->create()->each(function($user) {
       		$user->posts()->save(factory(App\Post::class)->make());
       	});
    }
}
