<?php
class YellowPage {
	var $con; // connlect to DB
	function connect() {
		$this->con = mysqli_connect ( "localhost", "root", "qwe123", "ypage" );
		if (mysqli_connect_errno ()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error ();
			return;
		}
		if (! $this->con->set_charset ( "utf8" )) {
			printf ( "utf8 load error: %s\n", $this->con->error );
		} else {
			// printf ( "Current charset is: %s\n", $this->con->character_set_name () );
		}
	}
	function generateOneOrg($orgName) {
		echo "<ul type=\"disc\">
			  <li>Название <br> <span>
			  $orgName
			  </span></li>";
		
		echo "<li>Адрес <br> <span>";
		
		$adr_query = "select   city.name, borough.name, postcode.number, metro.name, 
	 			address.street, address.house, address.apartment   
				from organization
					join addressorg on organization.id_organization = addressorg.id_organization
					join address    on addressorg.id_address = address.id_address
					join postcode   on address.id_postcode = postcode.id_postcode
					join borough    on postcode.id_borough = borough.id_borough
					join city       on borough.id_city = city.id_city
					join metro ON city.id_city = metro.id_city
				where organization.name = \"$orgName\";";
		$c = 0;
		$adr_res = mysqli_query ( $this->con, $adr_query );
		while ( $row = mysqli_fetch_array ( $adr_res ) ) {
 			if($c > 3)
 				break;
			echo "$row[0] ";
			echo "$row[1] ";
			echo "$row[2] ";
			echo "$row[3] ";
			echo "$row[4] ";
			echo "$row[5] ";
			echo "$row[6] ";
			echo "<br>";
			$c++;
		}
		echo "</span></li>";
		mysql_free_result ( $adr_res );
		
		$meta_org_query = "select  organization.phones, organization.e_mail, organization.site, organization.operationTime,
						organization.additionalInf
						from organization
						where organization.name = \"$orgName\";";
		
		$meta_org_res = mysqli_query ( $this->con, $meta_org_query );
		$row = mysqli_fetch_array ( $meta_org_res ); 
			echo "<li>Телефон <br> <span> $row[0] </span></li>";
			echo "<li>Емейл <br> <span> $row[1] </span></li>";
			echo "<li>Сайт <br> <span> $row[2] </span></li>";
			echo "<li>Время работы <br> <span> $row[3] </span></li>";
			echo "<li>Дополнительная информация <br> <span> $row[4] </span></li>";
		mysql_free_result ( $meta_org_res );
		
		$cat_query = "select categorie.name
			from organization
				join categorieorg on organization.id_organization = categorieorg.id_organization
				join categorie    on categorieorg.id_categorie = categorie.id_categorie
			where organization.name = \"$orgName\";";
		
		echo "<ul type=\"disc\">
		<li>Категории <br> <span>";
		
		$cat_res = mysqli_query ( $this->con, $cat_query );
		while ( $row = mysqli_fetch_array ( $cat_res ) ) {
			echo "$row[0]<br>";
			
		}
		mysql_free_result ( $cat_res );
		echo "</span></li>";
		
		echo "</ul>";
	}
	function createContext($city, $metro, $cat, $text) {
		$query = "
		SELECT organization.name, city.name, borough.name, postcode.number, metro.name, 
	    address.street, address.house, address.apartment, categorie.name 
		FROM organization
		JOIN categorieorg ON organization.id_organization = categorieorg.id_organization
		JOIN categorie 	ON categorie.id_categorie = categorieorg.id_categorie
		JOIN addressorg ON addressorg.id_organization = organization.id_organization
		JOIN address 	ON address.id_address = addressorg.id_address
		JOIN postcode   ON address.id_postcode = postcode.id_postcode
		JOIN borough    ON postcode.id_borough = borough.id_borough
		JOIN city       ON borough.id_city = city.id_city
		JOIN metro 		ON city.id_city = metro.id_city
		WHERE city.name = '$city' and organization.name like \"%$text%\"";
		
		if ($metro != "-- не выбранно --")
			$query .= "AND metro.name = '$metro' ";
		
		if ($cat != "-- не выбранно --")
			$query .= "AND categorie.name = '$cat' ";
		
		$query .= " GROUP BY organization.id_organization;";
		
		//echo $query;
		
		$result = mysqli_query ( $this->con, $query );
				
		echo "
		<!DOCTYPE html>
		<html>
		<head>
		<meta charset=\"UTF-8\">
		<link rel=\"stylesheet\" type=\"text/css\" href=\"css/org.css\">
		<script type=\"text/javascript\" src=\"script/script.js\"></script>
		<title>Insert title here</title>
		</head>
		<body>";
		$i = 1;
		$sub_class = "chet";
		while ( $row = mysqli_fetch_array ( $result ) ) {
			if ($i % 2)
				$sub_class = "chet";
			else
				$sub_class = "nchet";
			echo "<div class=\"org $sub_class\" id=\"org1\" onclick=\"openOrg(this)\" ondblclick=\"closeOrg()\">";
			echo "<span style=\"color: blue;\">" . $row[0] . "</span>";
			echo "<p>";
			echo "<i>Адрес: </i>";
			echo "<span>$row[3], $row[1], район $row[2], улица $row[5], дом $row[6], квартира $row[7]</span>";
			echo "<br>";
			echo "<i>Рубрика: </i>";
			
			$cat_query = "select categorie.name
			from organization
			join categorieorg on organization.id_organization = categorieorg.id_organization
			join categorie    on categorieorg.id_categorie = categorie.id_categorie
			where organization.name = \"$row[0]\";";
			
			echo "<span>";
			
			$cat_res = mysqli_query ( $this->con, $cat_query );
			while ( $row1 = mysqli_fetch_array ( $cat_res ) ) {
				echo "$row1[0] ";
					
			}
			mysql_free_result ( $cat_res );
			echo "</span></p>";
			echo "</div>";
			$i ++;
		}
		echo "</body>";
		mysql_free_result ( $result );
	}
	function generateCityOptions() {
		$result = mysqli_query ( $this->con, "SELECT * FROM city;" );
		
		// echo "<option>qwe</option>";
		
		while ( $row = mysqli_fetch_array ( $result ) ) {
			// echo $row ['id_city'] . " " . $row ['name'];
			// echo "<br>";
			echo "<option>" . $row ['name'] . "</option>";
		}
		mysql_free_result ( $result );
	}
	function generateMetroSelect() {
		$result = mysqli_query ( $this->con, "SELECT metro.name, city.name FROM metro
				JOIN city ON metro.id_city = city.id_city;" );
		
		while ( $row = mysqli_fetch_array ( $result ) ) {
			$data [$row [1]] [] = $row [0];
		}
		
		mysql_free_result ( $result );
		
		foreach ( $data as $k => $v ) {
			
			echo "<select style=\"display:none;\" id = \"" . $k . "\" name=\"metro " . $k . " \">";
			echo "<option>-- не выбранно --</option>";
			for($i = 0; $i < count ( $v ); $i ++) {
				echo "<option>" . $v [$i] . "</option>";
			}
			echo "</select>";
		}
	}
	function generateCatOptions() {
		$result = mysqli_query ( $this->con, " SELECT * FROM categorie;" );
		echo "<option>-- не выбранно --</option>";
		while ( $row = mysqli_fetch_array ( $result ) ) {
			// echo $row ['id_city'] . " " . $row ['name'];
			// echo "<br>";
			echo "<option>" . $row ['name'] . "</option>";
		}
		mysql_free_result ( $result );
	}
	function close() {
		mysql_close ( $this->con );
	}
}
function init() {
	session_start ();
	$_SESSION ['ypage'] = new YellowPage ();
	$_SESSION ['ypage']->connect ();
}
function generateCityOptions() {
	$_SESSION ['ypage']->generateCityOptions ();
}
function generateCatOptions() {
	$_SESSION ['ypage']->generateCatOptions ();
}
function generateMetroSelect() {
	$_SESSION ['ypage']->generateMetroSelect ();
}
function generateContext($city, $metro, $cat, $text) {
	session_start ();
	$_SESSION ['ypage']->connect ();
	$_SESSION ['ypage']->createContext ( $city, $metro, $cat, $text );
	$_SESSION ['ypage']->close ();
}
function close() {
	$_SESSION ['ypage']->close ();
}
function generateOneOrg($orgName) {
	session_start ();
	$_SESSION ['ypage']->connect ();
	$_SESSION ['ypage']->generateOneOrg ( $orgName );
	$_SESSION ['ypage']->close ();
}