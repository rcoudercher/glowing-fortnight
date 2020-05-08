<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScoreController extends Controller
{
  public function wilsonScore($pos, $n)
  {
    // $pos = positive votes
    // $n = total votes
    // $phat ou p̂ is the observed fraction of positive votes
    // $z = confidence
    // see https://www.evanmiller.org/how-not-to-sort-by-average-rating.html
    
    if ($n == 0) {
      return 0;
    }
    
    $z = 1.959964; // 1.959964 = 95.0% confidence, 2.241403 = 97.5% confidence
    $phat = $pos/$n;
    
    return ($phat + $z*$z/(2*$n) - $z * sqrt(($phat*(1-$phat) + $z*$z/(4*$n))/$n))/(1 + $z*$z/$n);
  }
}
