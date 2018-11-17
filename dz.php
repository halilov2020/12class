<?php
require "./includes/db.php";

$dz_items = R::findAll('dz');

$arr = [];
for($i = 1; $i <= count($dz_items); $i++ ) {
  $arr[$i] = $dz_items[$i]->value;
}
$obj = (object) $arr;
       $json_arr = json_encode($obj);
       echo $json_arr;

       ?>
