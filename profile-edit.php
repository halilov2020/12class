<?php
require "./includes/db.php";
require "./includes/auth-reg.php";

$sql_image = R::load('users', $_SESSION['logged_user']->id);
$path_avatar = $sql_image->avatar;

$data = $_POST;
$user_edit_edit = R::load('users', $_SESSION['logged_user']->id);
$id_mysqli = $_SESSION['logged_user']->id;
if(isset($data['confirm'])) {
	$errors = array();
	if(trim($data['login']) == '') {
		$user_edit['login'] = $user_edit['login'];
	}
	if(trim($data['real_name']) == '') {
		$errors[] = 'Введите имя';
	}
	if($data['age'] == '' or ' ') {
		$errors[] = 'Выберите возраст';
	}
	if($data['gender'] == '') {
		$errors[] = 'Выберите ваш пол';
	}
	if( !empty($_FILES['avatar_img']) ) {
		$avatar_img = $_FILES['avatar_img']['name'];
		if($avatar_img == '' or empty($avatar_img)){
			unset($avatar_img);
		}
		if(!isset($avatar_img) or empty($avatar_img) or $avatar_img == ''){
			$avatar = "avatars/no_avatar.jpg";
            if($path_avatar != "avatars/no_avatar.jpg"){
            	unlink($path_avatar);
            }
		} else {
			$path_to_90_directory = 'avatars/';
				if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['avatar_img']['name'])) {
				$filename = $_FILES['avatar_img']['name'];
                $source = $_FILES['avatar_img']['tmp_name'];
                $target = $path_to_90_directory.$filename;
                move_uploaded_file($source,$target);
                if(preg_match('/[.](GIF)|(gif)$/', $filename)){
                	$im = imagecreatefromgif($path_to_90_directory.$filename);
                }
                if(preg_match('/[.](PNG)|(png)$/', $filename)) {
                	$im = imagecreatefrompng($path_to_90_directory.$filename);
                }
                if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
                	$im = imagecreatefromjpeg($path_to_90_directory.$filename);
                }

                $w = 160;
                $w_src = imagesx($im);
             	$h_src = imagesy($im);
             	$dest = imagecreatetruecolor($w, $w);
             	if($w_src > $h_src) {
             		imagecopyresampled($dest, $im, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), 0, $w, $w, min($w_src,$h_src), min($w_src,$h_src));

             	}
             	if($w_src < $h_src) {
             		imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, min($w_src,$h_src), min($w_src,$h_src));

             	}
             	if($w_src == $h_src) {
             		imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
                   	}
                else {
             		$errors[] = 'Формат изображения должен быть GIF,PNG или JPG';
             	}
             	$id = $_SESSION['logged_user']->id;
              $date = time();
             	imagejpeg($dest, $path_to_90_directory.$id."_".$date.".jpg");
             	$avatar = $path_to_90_directory.$id."_".$date.".jpg";
             	$delfull = $path_to_90_directory.$filename;
             	unlink($delfull);
             	if($path_avatar != "avatars/no_avatar.jpg"){
             			unlink($path_avatar);
             	}
            }
		}
	}
   if (!empty($errors)) {
		$match = $data;
		if ($user_edit->login !== $match['login'] ) {
			$user_edit->login = $data['login'];
		} else {
			echo 'Вы не можете зарегистрировать ещё одного пользователя с таким логином';
		}
		$user_edit->age = $data['age'];
		$user_edit->avatar = $avatar;
		$user_edit->gender = $data['gender'];
		R::store($user_edit);
		echo 'Изменения сохранены!';
		unset($_SESSION['logged_user']);
    }
		else {
			echo "Возникли некоторые неполадки:" . array_shift($errors) . " пожалуйста исправьте их!";
		}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache">
	<title>12 КЛАСС</title>
	<link type="text/css" rel="stylesheet" href="./css/main.css?v1">
	<link type="text/css" rel="stylesheet" href="./css/popup.css?v1">
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
				<a class="nav-page" href="journal.php">
					<img class="menu_img document_img" src="./img/document_n.png" alt="document">
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
				<a class="nav-page-active" href="profile.php">
					<img class="menu_img profile_img" src="./img/profile.png" alt="profile">
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
			<div class="profile-page">
				<?php if(isset($_SESSION['logged_user'])) : ?>
				<div class="profile-user-container">
					<div class="profile-page-title"><h3>Профиль пользователя</h3></div>
						<div class="profile-user-block">

							<img class="profile-page-avatar" src="<?php if($path_avatar != '') echo $path_avatar; else echo "avatars/no_avatar.jpg";?>">

							<div class="profile-user-info">
								<form enctype="multipart/form-data" method="POST" class="edit-profile-form">
									<ul>
									<li>
										<strong>Логин: <input type="text" name="login" value="<?php echo @$user_edit['login'] ?>"></strong>
									</li>
									<li>
										<strong>Имя:   <input type="text" name="real_name" value="<?php echo @$user_edit['real_name'] ?>"></strong>
									</li>
									<li>
										<strong>Возраст:

									<select name="age" id="age">
									 <option value="<?php echo @$user_edit['age']?>"></option>
									 <option value="1">1</option>
									 <option value="2">2</option>
									 <option value="3">3</option>
									 <option value="4">4</option>
									 <option value="5">5</option>
									 <option value="6">6</option>
									 <option value="7">7</option>
									 <option value="8">8</option>
									 <option value="9">9</option>
									 <option value="10">10</option>
									 <option value="11">11</option>
									 <option value="12">12</option>
									 <option value="13">13</option>
									 <option value="14">14</option>
									 <option value="15">15</option>
									 <option value="16">16</option>
									 <option value="17">17</option>
									 <option value="18">18</option>
									 <option value="19">19</option>
									 <option value="20">20</option>
									 <option value="21">21</option>
									 <option value="22">22</option>
									 <option value="23">23</option>
									 <option value="24">24</option>
									 <option value="25">25</option>
									 <option value="26">26</option>
									 <option value="27">27</option>
									</select>

								</strong>
									</li>
									<li>
									<strong>Пол: <select name="gender" id="gender">
									<option value="<?php echo @$user_edit['gender'] ?>"></option>
									<option value="Male">Мужской</option>
									<option value="Female">Женский</option>
								</select></strong>
									</li>
									<li><label>Выберите аватар. Изображение должно быть формата jpg, gif или png:<br></label></li>
              						<li>
              							<div class="file-upload">
									     	<label>
									          	<input type="file" name="avatar_img">
									         	<span>Выберите аватар</span>
											</label>
										</div>
              						</li>
									<li>
										<input type="submit" name="confirm" value="Сохранить" class="settings-btn profile-edit-submit">
										<a href="profile.php" class="settings-btn profile-edit-escape">Отмена</a>
									</li>
									</ul>
								</form>
							</div>
						</div>
				</div>
			</div>
			<?php else: ?>
				<p><strong>Для того,чтобы увидеть эту страницу необходимо авторизоваться!</strong></p>
			<?php endif; ?>
		</div>


		<div class="footer">
			 C SRL "DIY"
		</div>
	</div>
</body>
</html>
