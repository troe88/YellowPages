<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/oneOrg.css">
<script type="text/javascript" src="script/script.js"></script>
<title>Insert title here</title>
</head>
<body>
	<div id="first">
		<div id="header">
			<span>Просмотр организации</span>
		</div>
		<div id="content">
			<?php
			include 'src/main.php';
			generateOneOrg ( $_COOKIE ["org"] );
			?>
<!-- 			<ul type="disc">
				<li>Название <br> <span>
				OOO - Organizstion
				</span>
				</li>
				<li>Адрес <br> <span> Россия, Москва, улица стоителей дом 25
						квартира 12 </span>
				</li>
				<li>Телефон <br> <span> 777-777-777 </span>
				</li>
				<li>Емейл <br> <span> mail@mail.com </span>
				</li>
				<li>Сайт <br> <span> <a href="http://google.com">site.com</a></span>
				</li>
				<li>Время работы <br> <span> Круглосуточно </span>
				</li>
				<li>Дополнительная информация <br> <span> Шла Саша по шоссе и сосала
						сушку. </span>
				</li>
			</ul> -->
		</div>
		<div id="footer">
			<button onclick="closeOrg()">Закрыть</button>
		</div>
	</div>
</body>
</html>