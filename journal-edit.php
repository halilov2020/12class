<?php
require "./config.php";
require "./includes/auth-reg.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache">
	<title>12 КЛАСС</title>
	<link type="text/css" rel="stylesheet" href="./css/sch.css">
	<link type="text/css" rel="stylesheet" href="./css/main.css?v1">
	<link type="text/css" rel="stylesheet" href="./css/popup.css?v1">
	<link type="text/css" rel="stylesheet" href="./css/journal.css?v1">
	<link type="text/css" rel="stylesheet" href="./css/media.css?v1">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

	<script src="./stories/popups.js"></script>
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
	<div id="m-menu" hidden>
		<ul>
			<li><a class="mobile-menu-li" href="javascript:HideMobileMenu()">
				<img src="./img/cancel-m.png">
				<span>Закрыть</span>
			</a>
		</li>
			<li><a class="mobile-menu-li" href="index.php">
				<img src="./img/home-m.png">
				<span>Главная</span>
			</a></li>
			<li><a class="mobile-menu-li" href="schedule.php">
			<img src="./img/list-m.png">
				<span>Расписание</span>
			</a></li>
			<li><a class="mobile-menu-li" href="journal.php">
				<img src="./img/book-m.png">
				<span>Дневник</span>
			</a></li>
			<li><a class="mobile-menu-li" href="calendar.php">
			<img src="./img/calendar-m.png">
				<span>Календарь</span>
			</a></li>
			<li><a class="mobile-menu-li" href="settings.php">
			<img src="./img/settings-m.png">
				<span>Настройки</span>
			</a></li>
			<li><a class="mobile-menu-li" href="profile.php">
			<img src="./img/profile-m.png">
				<span>Профиль</span>
			</a></li>

		</ul>
	</div>
	<div class="page">
		<div class="header">
			<div class="hamburger-ico" onclick="javascript:ShowMobileMenu()">
					<div class="hamburger-icon"></div>
					<div class="hamburger-icon"></div>
					<div class="hamburger-icon"></div>
				</div>
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
					<form method="POST" class="auth">
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
								<button type="submit" name="do_login" class="settings-btn">Войти</button>
								<a href="javascript:PopUpHide_auth(), PopUpShow_reg()"><input type="button" value="Зарегистрироваться" class="settings-btn"></a>

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
								<button type="submit" name="sign_up" class="settings-btn">Зарегистрироваться</button> <a href="javascript:PopUpHide_reg(), PopUpShow_auth()" class="settings-btn">Войти</a>
							</li>
						</ul>
					</form>
				</div>
			</div>
			<div class="day-page">
					<?php if($_SESSION['logged_user']) : ?>
					<script src='./stories/journal.js'></script>
					<script src="./scripts/journal-respond.js"></script>
					<?php endif; ?>
			</div>
		</div>


		<div class="footer">
			 © 2018
		</div>
	</div>

</body>
</html>
