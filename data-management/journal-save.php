<?php
  require "../config.php";

  $dzs = $_POST['dzs'];
  $week = $_POST['week'];
  if ( !isset($week) )
  {
    $week = '';
  }
  if ( isset($dzs) )
  {
  	for ($i = 0 ; $i < count($dzs) ; $i++)
      {
  			// это объект - нужно переделать в массив
  			$dz_item = R::findOne('dz'.$week, 'id = ?', [$i+1]);
          if ( isset($dz_item) ) {
      			$dz_item->value = $dzs[$i];
      			R::store($dz_item);
          } else {
            $row = R::dispense('dz'.$week);
            $row->value = $dzs[$i];
            R::store($row);
          }
  		}
    echo "success";
  } else {
    echo "not defined";
  }
?>
