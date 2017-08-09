<?php
define("HOST","localhost");
define("USER", "user");
define("PASSWORD", "password");
define("DB","publications");


$mysqli = new mysqli(HOST,USER,PASSWORD,DB);
if ($mysqli->connect_errno) {
	echo 'can not connect'.$mysqli->connect_error;
	exit();
}


$fromdate = "2017-10-01";
$todate = "2017-10-10";
$id='53';


$query = "	SELECT dates.date,
			COALESCE(day_price.price, default_price.price) AS price,
		    IF (day_price.price IS NULL,'обычная цена','особая цена') AS typePrice

		    FROM dates
			LEFT JOIN default_price ON default_price.id = $id
			LEFT JOIN day_price ON day_price.date = dates.date

			WHERE dates.date >= '$fromdate ' AND dates.date <='$todate'
			ORDER BY  dates.date";




$result = $mysqli->query($query);

if (!$result){
	echo "error query" . $mysqli->error .' '. $mysqli->errno;
	exit();
}


//вывод через ассоциативный массив
$row = $result->fetch_array(MYSQLI_ASSOC);
echo $row['date'] . "  " . $row['price'] . ' ' . $row['typePrice'];
echo '<br>';

while($row = mysqli_fetch_assoc($result))
{
	echo $row['date'] . "  " . $row['price'] . ' ' . $row['typePrice'];
	echo '<br>';

}
$result->close();



echo '<br> <br> <br>';

//вывод через индексный массив
$result = $mysqli->query($query);

if (!$result){
	echo "error query" . $mysqli->error .' '. $mysqli->errno;
	exit();
}

$row = $result->fetch_array(MYSQLI_NUM);
echo $row[0] . "  " . $row[1]. " " . $row[2];
echo '<br>';

while($row = mysqli_fetch_array($result))
{
	echo $row[0] . "  " . $row[1] . " " . $row[2];
	echo '<br>';

}

$result->close();
$mysqli->close();

?>