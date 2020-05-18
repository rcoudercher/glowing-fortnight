<?php

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
  public function run()
  {
    factory(App\Message::class, 200)->create();
  }
}
