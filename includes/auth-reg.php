<?php
if (isset($_SESSION['logged_user']->id)) {
$sql_image = R::load('users', $_SESSION['logged_user']->id);
$path_avatar = $sql_image->avatar;
}

$data_auth = $_GET;
if(isset($data_auth['do_login'])) {
	$errors = array();
	$user_auth = R::findOne('users', 'login = ?', array($data_auth['login']));

	if ( $user_auth ) {
		if( password_verify($data_auth['password'], $user_auth->password))
		{
			//логинимся
			$_SESSION['logged_user'] = $user_auth;
			//echo '<div style="color:green">Вы успешно авторизованы!<br>Можете перейти на <a href="/">главную</a>страницу!</div><hr>';
			header('Location:/');
		} else {
			$errors[] = 'Неверно введён пароль!';
		}
	} else {
		$errors[] = 'Пользователь с таким логином не найден!';
	}

	if( ! empty($errors)){
		echo '<div style="color:red">' . array_shift($errors) . '</div><hr>';
	}

}

$data_reg = $_POST;
if(isset($data_reg['sign_up'])) {
	$errors = array();
	if(	trim($data_reg['login']) == '') {
		$errors[] = 'Введите логин';
	}
	if(!preg_match("/^[a-zA-Z0-9]+$/",$data_reg['login']))
    {
        $errors[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

	if(	trim($data_reg['email']) == '') {
		$errors[] = 'Введите email';
	}

	if(	$data_reg['password'] == '') {

		$errors[] = 'Введите пароль';
	}
	if(!preg_match("/^[a-zA-Z0-9]+$/",$data_reg['password']))
    {
        $errors[] = "Пароль может состоять только из букв английского алфавита и цифр";
    }

	if(	$data_reg['password_2'] != $data_reg['password']) {
		$errors[] = 'Повторный пароль введён не верно!';
	}

	if( R::count('users',"login = ?",array($data_reg['login'])) > 0 ) {
		$errors[] = 'Пользователь с таким логином уже существует!';
	}
	if( R::count('users',"email = ?",array($data_reg['email'])) > 0 ) {
		$errors[] = 'Пользователь с таким Email уже существует!';
	}


	if(empty($errors)){
		//регистрируем
		$user_reg = R::dispense('users');
		$user_reg->login = $data_reg['login'];
		$user_reg->email = $data_reg['email'];
		$user_reg->password = password_hash($data_reg['password'], PASSWORD_DEFAULT);
		$user_reg->real_name = NULL;
		$user_reg->join_date = time();
		R::store($user_reg);
		echo '<div style="color:green">Вы успешно зарегистрировались!<br><a href="/">Главная</a></div>';

	} else {
		echo '<div style="color:red">' . array_shift($errors) . '</div><hr>';
	}
}

?>
