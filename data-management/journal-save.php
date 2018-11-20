<?php
  require '../libs/rb.php';
  R::setup( 'mysql:host=localhost;dbname=12class',
          'root', '' );

  $dzs = $_POST['dzs'];
  if( isset($dzs) ) {
  	for ($i = 0 ; $i < count($dzs) ; $i++) {
  			// это объект - нужно переделать в массив
  			$dz_item = R::findOne('dz', 'id = ?', [$i+1]);
  			$dz_item->value = $dzs[$i];
  			R::store($dz_item);
  		}
    echo "success";
  } else {
    echo "not defined";
  }


?>
