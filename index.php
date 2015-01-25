<?php
include 'src/main.php';
init ();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/org.css">
<link rel="stylesheet" type="text/css" href="css/sub-form.css">
<script type="text/javascript" src="script/script.js"></script>
<title>main page</title>
</head>
<body onload="ChangeCity()">
<div id="black-layer"> </div>
<iframe id="singl-org" src="oneOrg.php"> </iframe>
<iframe id="add-org" src="add.html"> </iframe>
	<div id="header-container">
		<div>
			<div id="logo">логотип</div>
			<div id="search-form-container">
				<div>
					<form id="search-form" method="GET" action="org.php" target="content-frame">
						<input style="display: none;" name="metro" type="text">
						<input style="display: none;" name="cat" type="text"> 
						<input placeholder="Что ищем" name="text" type="text" /> 
						<span style="font-size: 1.4em; color: black; padding: 5px;">Где?</span>
						<select onchange="ChangeCity()" id="city_select" name="city">
							<?php
								generateCityOptions ();
							?>
						</select> 
						<input value="Найти" type="submit" onclick="addSubData()"/>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="content-container">
		<div>
			<iframe overflow-x="hidden" name="content-frame" src="org.php"> </iframe>
		</div>
		<div>
			<form id="sub-form">
			<span>Метро: </span>	
			<?php
				generateMetroSelect();
			?>
			<br>
			<br>
			<span>Рубрика: </span>
			<select name="cat" id="cat_select">
			<?php
				generateCatOptions ();
			?>
			</select>
			</form>
			<div onclick="displayAddForm()">
			Добавить
			</div>
		</div>
	</div>
	<div id="footer-container">
		<div></div>
	</div>
</body>
</html>
