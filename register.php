<?php
require "./includes/db.php";

$data = $_POST;
if(isset($data['sign_up'])) {
	$errors = array();
	if(	trim($data['login']) == '') {
		$errors[] = 'Введите логин';
	}
	if(!preg_match("/^[a-zA-Z0-9]+$/",$data['login']))
    {
        $errors[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

	if(	trim($data['email']) == '') {
		$errors[] = 'Введите email';
	}

	if(	$data['password'] == '') {     

		$errors[] = 'Введите пароль';
	}
	if(!preg_match("/^[a-zA-Z0-9]+$/",$data['password']))
    {
        $errors[] = "Пароль может состоять только из букв английского алфавита и цифр";
    }

	if(	$data['password_2'] != $data['password']) {
		$errors[] = 'Повторный пароль введён не верно!';
	}

	if( R::count('users',"login = ?",array($data['login'])) > 0 ) {
		$errors[] = 'Пользователь с таким логином уже существует!';
	}
	if( R::count('users',"email = ?",array($data['email'])) > 0 ) {
		$errors[] = 'Пользователь с таким Email уже существует!';
	}


	if(empty($errors)){
		//регистрируем
		$user = R::dispense('users');
		$user->login = $data['login'];
		$user->email = $data['email'];
		$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
		$user->name = NULL;
		$user->join_date = time();
		R::store($user);
		echo '<div style="color:green">Вы успешно зарегистрировались!<br><a href="/">Главная</a></div>';

	} else {
		echo '<div style="color:red">' . array_shift($errors) . '</div><hr>';
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Регистрация</title>
	<link type="text/css" rel="stylesheet" href="css/reg.css?v1">
</head>
<body>
	<form method="POST" action="register.php" class="reg">
		<ul>
			<h3>Регистрация</h3>
			<li>
				<label for="login"><strong>Введите логин:</strong></label>
				<input type="text" name="login" minlength="5" value="<?php echo @$data['login'] ?>">
				<span>* Пример: login123, jora12, kol9n</span>
			</li>
			<li>
				<label for="email"><strong>Введите Email:</strong></label>
				<input type="email" name="email"  value="<?php echo @$data['email'] ?>">
				<span>* Пример: ivan81@mail.ru, gerald@gmail.com</span>
			</li>
			<li>
				<label for="password"><strong>Введите пароль:</strong></label>
				<input type="password" name="password" minlength="6">
				<span>* Пароль не должен содержать такие символы как : [!@#^%&*(<)>/'}"{,.]</span>
			</li>
			<li>
				<label for="password_2"><strong>Подтвердите пароль:</strong></label>
				<input type="password" name="password_2" minlength="6">
				<span>* Введите пароль повторно,пароли должны совпадать!</span>
			</li>
			<li>
				<button type="submit" name="sign_up">Зарегистрироваться</button>
			</li>
		</ul>
	</form>
</body>
</html>