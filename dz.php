<?php
require "./config.php";
$week = $_GET['index'];
if (isset($week)) {
    //get the requested table
    $dz_items = R::findAll('dz'.$week);

    $arr = [];
    for($i = 1; $i <= 49; $i++ ) {
      if (isset($dz_items[$i])) {
        $arr[$i] = $dz_items[$i]->value;
      } else {
        $arr[$i] = '';
      }
    }
    $obj = (object) $arr;
    $json_arr = json_encode($obj);
    echo $json_arr;
}

?>
