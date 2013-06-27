<?
$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT username, bracketname, email FROM squadmembers WHERE username = '".$_GET['user']."' LIMIT 1";
$result = mysql_query($sql);
if (mysql_num_rows($result) == 0) { 
	$user_array = "error";
} else {

	$row = mysql_fetch_row($result);
	$user_array = implode(",",$row);

}

echo $user_array;
?>
