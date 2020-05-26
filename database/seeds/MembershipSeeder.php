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
              
      // create an empty array of already picked communities to avoid duplicate attachments
      $picked = [];
      
      for ($i=0; $i < 6; $i++) {
        
        // pick a random community that hasn't been picked already
        $community = Community::all()->except($picked)->random();
        
        
        $status = random_int(0,3);
        
        $data = [
          'admin' => random_int(0,1),
          'status' => $status,
        ];
        
        if ($status != 0) {
          $data['moderated_at'] = now();
          $data['moderated_by'] = User::all()->random()->id;
        }
        
        // add the freshly picked community to the array of picked communities
        $picked[] = $community->id;
        
        $user->communities()->attach($community, $data);
        
      }
    });
    
    
  }
}
