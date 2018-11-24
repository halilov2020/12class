<?php
if (isset($_SESSION['logged_user']->id)) {
$sql_image = R::load('users', $_SESSION['logged_user']->id);
$path_avatar = $sql_image->avatar;
}

// Log in
$data = $_POST;
if(isset($data['do_login'])) {
	$errors = array();
	$user_auth = R::findOne('users', 'login = ?', array($data['login']));

	if ( $user_auth )
		{
			if( password_verify($data['password'], $user_auth->password))
				{
					// логинимся
					$_SESSION['logged_user'] = $user_auth;
				}
		else
		{
			$errors[] = 'Неверно введён пароль!';
		}
	}
	else
	{
		$errors[] = 'Пользователь с таким логином не найден!';
	}
}

// Register
if(isset($data['sign_up'])) {
	$errors = array();

	// Validate input data
	{
		if(	trim($data['login']) == '')
			{
				$errors[] = 'Введите логин';
			}
		if( !preg_match("/^[a-zA-Z0-9]+$/",$data['login']) )
	    {
	      $errors[] = "Логин может состоять только из букв английского алфавита и цифр";
	    }
		if(	trim($data['email']) == '')
			{
				$errors[] = 'Введите email';
			}
		if(	$data['password'] == '')
			{
				$errors[] = 'Введите пароль';
			}
		if(!preg_match("/^[a-zA-Z0-9]+$/",$data['password']))
	    {
	    	$errors[] = "Пароль может состоять только из букв английского алфавита и цифр";
	    }
		if(	$data['password_2'] != $data['password'])
			{
				$errors[] = 'Повторный пароль введён не верно!';
			}
		if( R::count('users',"login = ?",array($data['login'])) > 0 )
			{
				$errors[] = 'Пользователь с таким логином уже существует!';
			}
		if( R::count('users',"email = ?",array($data['email'])) > 0 )
			{
				$errors[] = 'Пользователь с таким Email уже существует!';
			}
	}

	// регистрируем
		if(empty($errors)){

			// Create a new row based on user schema
			$user_reg = R::dispense('users');

			// Populate the row
			$user_reg->login = $data['login'];
			$user_reg->email = $data['email'];
			$user_reg->password = password_hash($data['password'], PASSWORD_DEFAULT);
			$user_reg->real_name = NULL;
			$user_reg->join_date = time();

			// save new user to db
			R::store($user_reg);

			echo '<div style="color:green">Вы успешно зарегистрировались!<br><a href="/">Главная</a></div>';
	}
	if( !empty($errors) )
	{
		echo '<div style="color:red">' . array_shift($errors) . '</div><hr>';
	}
}

// Display errors

?>
