<?php
require "./includes/db.php";
require "./includes/auth-reg.php";
if(isset($_GET['vals'])) {
	$dzs = $_GET['vals'];
	$p = explode(',',$dzs);
	for ($i = 0 ; $i < count($p) ; $i++) {
			$dz_item = R::findOne('dz', 'id = ?', [$i+1]); // это объект- нужно переделать в массив
			$dz_item->value = $p[$i];
			R::store($dz_item);
		}


};

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache">
	<title>12 КЛАСС</title>
	<link type="text/css" rel="stylesheet" href="./css/main.css?v1">
	<link type="text/css" rel="stylesheet" href="./css/popup.css?v1">
	<link type="text/css" rel="stylesheet" href="./css/journal.css?v1">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

	<script>
    $(document).ready(function(){
        PopUpHide_auth();
    });
    function PopUpShow_auth(){
        $("#auth").show();
	}
	function PopUpHide_auth(){
        $("#auth").hide();
    }
    $(document).ready(function(){
        PopUpHide_reg();
    });
    function PopUpShow_reg(){
		$("#reg").show();
	}
	function PopUpHide_reg(){
	    $("#reg").hide();
	}
	 </script>
</head>

<body>
	<div class="nav-menu">
		<div class="logo_menu">
			<a class="logo" href="/">12 КЛАСС</a>
			<div class="nav-menu-middle">
				<a class="nav-page" href="index.php">
					<img class="menu_img home_img" src="./img/home_n.png" alt="home">
					<span>Главная</span>
				</a>
				<a class="nav-page" href="schedule.php">
					<img class="menu_img multiple_img" src="./img/multiple-line_n.png" alt="multiple-line">
					<span>Расписание</span>
				</a>
				<a class="nav-page-active" href="journal.php">
					<img class="menu_img document_img" src="./img/document.png" alt="document">
					<span>Дневник</span>
				</a>
				<a class="nav-page" href="calendar.php">
					<img class="menu_img calendar_img" src="./img/calendar_n.png" alt="calendar">
					<span>Календарь</span>
				</a>
				<a class="nav-page" href="settings.php">
					<img class="menu_img settings_img" src="./img/settings_n.png" alt="settings">
					<span>Настройки</span>
					</a>
				<a class="nav-page" href="profile.php">
					<img class="menu_img profile_img" src="./img/profile_n.png" alt="profile">
					<span>Профиль</span>
				</a>
			</div>
		</div>
	</div>
	<div class="page">
		<div class="header">
			<?php if (isset($_SESSION['logged_user'])): ?>
				<a href="profile.php"><img src="<?php if($path_avatar != '') echo $path_avatar; else echo "avatars/no_avatar.jpg";?>" class="header_avatar" alt="avatar"></a><strong><?php echo $_SESSION['logged_user']->login  ?></strong>
					<a href="logout.php" class="btn-popup logout">Выйти</a>
			<?php else : ?>
			<div class="authorization" align="right">
		 		<a href="javascript:PopUpShow_auth()" class="btn-popup login">Войти</a>
		 		<a href="javascript:PopUpShow_reg()" class="btn-popup register">Регистрация</a>
			</div>
			<?php endif; ?>
		</div>

		<div class="content">
			<div class="auth-page" id="auth">
				<div class="h-auth">
					<a href="javascript:PopUpHide_auth()" class="close">X</a>
					<form method="GET" class="auth">
						<ul>
							<h3>Авторизация</h3>
							<li>
								<label for="login"><strong>Введите логин:</strong></label>
								<input type="text" name="login" value="<?php echo @$data_auth['login'] ?>">
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

				</div>
			</div>
			<div class="reg-page" id="reg">
				<div class="h-reg">
					<a href="javascript:PopUpHide_reg()" class="close">X</a>
					<form method="POST" class="reg">
						<ul>
							<h3>Регистрация</h3>
							<li>
								<label for="login"><strong>Введите логин:</strong></label>
								<input type="text" name="login" minlength="5" value="<?php echo @$data_reg['login'] ?>">
								<span>* Пример: login123, jora12, kol9n</span>
							</li>
							<li>
								<label for="email"><strong>Введите Email:</strong></label>
								<input type="email" name="email"  value="<?php echo @$data_reg['email'] ?>">
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
				</div>
			</div>
			<div class="day-page">
					<?php if($_SESSION['logged_user']) : ?>
					<script src='./stories/journal.js'></script>

					<?php endif; ?>
			</div>
		</div>


		<div class="footer">
			 © 2018
		</div>
	</div>
</body>
</html>
