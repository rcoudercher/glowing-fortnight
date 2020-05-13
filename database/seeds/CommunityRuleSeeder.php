<?php

use Illuminate\Database\Seeder;

class CommunityRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\CommunityRule::class, 60)->create()->each(function($rule) {
        $rule->creator()->associate(App\User::all()->random());
        $rule->community()->associate(App\Community::all()->random());
        $rule->save();
      });
    }
}
