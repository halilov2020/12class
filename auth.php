<?php
require "./includes/db.php";

$data = $_POST;
if(isset($data['do_login'])) {
	$errors = array();
	$user = R::findOne('users','login = ?',array($data['login']));

	if ( $user ) {
		if( password_verify($data['password'], $user->password))
		{
			//логинимся
			$_SESSION['logged_user'] = $user;
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


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
	<link type="text/css" rel="stylesheet" href="css/auth.css?v1">
</head>
<body>
	<form method="POST" class="auth">
		<ul>
			<h3>Авторизация</h3>
			<li>
				<label for="login"><strong>Введите логин:</strong></label>
				<input type="text" name="login" value="<?php echo @$data['login'] ?>">
				<span>*</span>
			</li>
			<li>
				<label for="password"><strong>Введите пароль: </strong></label>
				<input type="password" name="password">
				<span>*</span>
			</li>
			<li>	
				<button type="submit" name="do_login" class="submit">Войти</button>
				<a href="register.php"><input type="button" value="Зарегистрироваться"></a>
				<a href="/"><input type="button" value="На главную"></a>
			</li>
		</ul>
	</form>
</body>
</html>