<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(AdminSeeder::class);
      $this->call(UserSeeder::class);
      $this->call(CommunitySeeder::class);
      $this->call(PostSeeder::class);
      $this->call(TrophySeeder::class);
      $this->call(CommentSeeder::class);
      $this->call(VoteSeeder::class);
      $this->call(CommunityRuleSeeder::class);
      $this->call(MessageSeeder::class);
      $this->call(MembershipSeeder::class);
      
    }
}
