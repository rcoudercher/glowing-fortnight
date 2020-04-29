<?php

use Illuminate\Database\Seeder;
use App\Community;
use App\User;

class MembershipSeeder extends Seeder
{
    public function run()
    {
      // attach communities to users
      User::all()->each(function($user) {
        $communities = Community::all(); // retrieve all communities
        $picked = []; // create an empty array of already picked communities to avoid duplicate attachments
        for ($i=0; $i < 3; $i++) {
          $community = $communities->except($picked)->random(); // pick a random community that hasn't been picked already
          $picked[] = $community->id; // add the freshly picked community to the array of picked communities
          $user->communities()->attach($community); // attach the community to the user
        }
      });
    }
}
