<?php
  require '../libs/rb.php';
  R::setup( 'mysql:host=localhost;dbname=12class',
          'root', '' );

  $user_data = array();
  $index = (int)$_GET['index'];
  $batch = (int)$_GET['batch'];

  class User {
    public function __construct($l, $a, $i) {
        $this->login = $l;
        $this->avatar = $a;
        $this->id = $i;
    }
  }

  function openCollection($ind, $bat) {

    $default = 'avatars/no_avatar.jpg';
    $u_d = array();
    $u = array();
    $u = R::exportAll(R::findAll( 'users', 'ORDER BY id' ));
    for ($i = 0; $i < $bat; $i++) {
      if ($i + $ind >= count($u)) {
        return $u_d;
      }
      $j = $i + $ind;
      $u_d[$i]['login'] = $u[$j]['login'];
      $u_d[$i]['avatar'] = $u[$j]['avatar'] != "" ? $u[$j]['avatar'] : $default;
      $u_d[$i]['id'] = $u[$j]['id'];
    }
    return $u_d;
  }

  $user_data = openCollection($index, $batch);
  echo json_encode($user_data);

?>
