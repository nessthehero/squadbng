<?
session_start();

include("vars.php");
include("functions.php");

check_login();

// This is for deleting tournaments that have been created,
// but not started.

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) != "admin") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql[1] = "DELETE FROM tournaments WHERE t_key = '$_GET[t_key]'";
$sql[2] = "DELETE FROM tourneystats WHERE t_key = '$_GET[t_key]'";
$sql[3] = "UPDATE squadmembers SET intourn = 'no'";

for ($i = 1; $i <= 3; $i++) {
        @mysql_query($sql[$i],$connection) or die(mysql_error());
}

header("Location: ".$admin_dir."tournament.php");
exit;
?>
