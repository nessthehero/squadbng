<?
session_start();

include("vars.php");
include("functions.php");

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$t_name = $_POST[t_name];
$key = $_POST[t_key];

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql[1] = "DELETE FROM tournaments WHERE t_key = '$key'";
$sql[2] = "DELETE FROM tourneystats WHERE t_key = '$key'";
$sql[3] = "DELETE FROM matches WHERE t_key = '$key'";
$sql[4] = "UPDATE squadmembers SET intourn = 'no'";
$sql_total = 4;
if (teams($key)) {
$sql[5] = "DELETE FROM teams";
$sql[6] = "UPDATE squadmembers SET team_id = '0'";
$sql_total = 6;
}

if (isset($t_name)) {
$apology = "
We're sorry, but $t_name has been cancelled.

Any matches you performed in will not count toward any wins or anything.

Please check the forums for more details.

Thanks!


\tNessTheHero
";
$subject = "$t_name Cancelled";
$header = "From: BnG Wars Administration";
$i = 1;
$sql_2 = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
$result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result_2)) {
        mail($row[email], $subject, $apology, $header);
}
}

for ($i = 1; $i <= $sql_total; $i++) {
@mysql_query($sql[$i],$connection) or die(mysql_error());
}

header("Location: ".$admin_dir."create_tournament.php");
exit;
?>
