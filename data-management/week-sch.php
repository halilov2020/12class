<?php
require "../config.php";
require (ROOT_DIR."/includes/db.php");

header('Content-Type: text/html; charset=utf-8');
$d = time() + date(2*24*60*60);

if ($d == 6 or 7) {
  $load_table = R::find('dz');
  $array_dz = [];
  for($i=1;$i<=49;$i++){
    $array_dz[$i] = $load_table[$i]->value;
  }
  $string_dz = json_encode($array_dz);
  echo $string_dz;
}
?>
