<?php
// echo $_POST ["orgName"] . "<br>";
// echo $_POST ["orgPhone"] . "<br>";
// echo $_POST ["orgEmail"] . "<br>";
// echo $_POST ["orgSite"] . "<br>";
// echo $_POST ["orgOpertime"] . "<br>";
// echo $_POST ["orgAddinf"] . "<br>";
// echo $_POST ["city"] . "<br>";
// echo $_POST ["brough"] . "<br>";
// echo $_POST ["metro"] . "<br>";
// echo $_POST ["adrStreet"] . "<br>";
// echo $_POST ["adrHouse"] . "<br>";
// echo $_POST ["adrAprt"] . "<br>";
// echo $_POST ["adrAddinf"] . "<br>";
$id_metro = 5;
$id_postcode = 0; // DONE
$id_newOrg = 0;
$id_newAddress = 0;

$new_org = 1;
$new_address = 1;

$name = $_POST ["orgName"];
$phone = $_POST ["orgPhone"];
$email = $_POST ["orgEmail"];
$site = $_POST ["orgSite"];
$oper_time = $_POST ["orgOpertime"];
$info = $_POST ["orgAddinf"];

$street = $_POST ["adrStreet"];
$house = $_POST ["adrHouse"];
$flat = $_POST ["adrAprt"];
$info_adr = $_POST ["adrAddinf"];

// connect
$cnt = mysqli_connect ( "localhost", "root", "qwe123", "ypage" );
if (mysqli_connect_errno ()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error ();
	return;
}
if (! $cnt->set_charset ( "utf8" )) {
	printf ( "utf8 load error: %s\n", $cnt->error );
} else {
	// printf ( "Current charset is: %s\n", $cnt->character_set_name () );
}
// !connect

// ID_POSTCODE
$city = $_POST ["city"];
$borough = $_POST ["brough"];
$query_pst = "select 
		postcode.id_postcode from postcode
			join borough on postcode.id_borough = borough.id_borough
			join city on borough.id_city = city.id_city
		where city.name = \"$city\" and borough.name = \"$borough\";";
$result = mysqli_query ( $cnt, $query_pst );
while ( $row = mysqli_fetch_array ( $result ) )
	$id_postcode = $row [0];
echo "Вычисляю ид почтового кода для $city - $borough" . "<br>";
echo $query_pst . "<br>";
echo "postcode.id_postcode = " . $id_postcode . "<br> <br>";
// !ID_POSTODE

$query_org = "
	INSERT INTO organization (
		name, phones, e_mail, site,	operationTime,	additionalInf,	id_user
		) VALUES (
		\"$name\", \"$phone\",	\"$email\",	\"$site\", \"$oper_time\", \"$info\", 1 );";
$result = mysqli_query ( $cnt, $query_org );
echo "добавляю организаицю в базу данных" . "<br>";
echo $query_org . "<br> <br>";


$query_adr = "
	INSERT INTO address (
		street, house, apartment, id_metro, id_postcode, additionalInf
		) VALUES (
		\"$street\", $house, $flat, $id_metro, $id_postcode, \"$info_adr\");";
$result = mysqli_query ( $cnt, $query_adr );
echo "добавляю новый адрес в базу данных" . "<br>";
echo $query_adr . "<br> <br>";

// ID_ORG
$query_idOrg = "SELECT MAX(organization.id_organization) FROM organization";
$result = mysqli_query ( $cnt, $query_idOrg );
while ( $row = mysqli_fetch_array ( $result ) )
	$new_org = $row [0];
echo "Вычисляю ид новой организации" . "<br>";
echo "id_new_org=" . $new_org . "<br><br>";
// !ID_ORG

// ID_ADR
$query_idAdr = "SELECT MAX(address.id_address) FROM address";
$result = mysqli_query ( $cnt, $query_idAdr );
while ( $row = mysqli_fetch_array ( $result ) )
	$new_address = $row [0];
echo "Вычисляю ид нового адреса" . "<br>";
echo "id_new_adr=" . $new_address . "<br><br>";
// !ID_ADR

$query_res = "
	INSERT INTO addressorg (
		id_organization, id_address
		) VALUES (
 		$new_org, $new_address);";
$result = mysqli_query ( $cnt, $query_res );
echo "Свожу все вместе" . "<br>";
echo $query_res . "<br>";

mysql_free_result ( $result );