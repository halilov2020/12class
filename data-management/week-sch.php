<?php
require "../config.php";

header('Content-Type: text/html; charset=utf-8');
$current_time = time();
$saturday = strtotime('next Saturday');

if ($current_time == $saturday) {
  $dz_curr = R::find('dz');
  $array_dz_curr = [];
  for($i=1; $i<=49; $i++){
    $array_dz_curr[$i] = $dz_curr[$i]->value;
  }
  for($u=1; $u<=49; $u++){
    $dz_prev = R::load('dzprev', $u);
    $dz_prev->value = $array_dz_curr[$u];
    R::store($dz_prev);
  }

  $array_dz_next = [];
  $dz_next = R::find('dznext');
  for($k=1; $k<=49; $k++) {
    $array_dz_next[$k] = $dz_next[$k]->value;
    $next_clean = R::load('dznext',$k);
    $next_clean->value = '-';
    R::store($next_clean);
  }

  for ($l=1; $l<=49; $l++) {
    $dz_curr_from_next = R::load('dz',$l);
    $dz_curr_from_next->value = $array_dz_next[$l];
    R::store($dz_curr_from_next);
  }
}
?>
