<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");

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

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (!isset($_GET[t_key])) {
        header("Location: ".$admin_dir."start_tournament.php");
        exit;
}

$sql[] = "DELETE FROM tournaments WHERE t_key = '$_GET[t_key]'";
$sql[] = "DELETE FROM t_stats WHERE t_key = '$_GET[t_key]'";
$sql[] = "DELETE FROM t_options WHERE t_key = '$_GET[t_key]'";
$sql[] = "DELETE FROM teammates WHERE t_key = '$_GET[t_key]'";
$sql[] = "DELETE FROM teams WHERE t_key = '$_GET[t_key]'";
$sql[] = "UPDATE squadmembers SET intourn = 'no'";
$sql[] = "UPDATE squadmembers SET rank = 'squad' WHERE rank != 'admin'";

foreach ($sql as $s) {
        @mysql_query($s,$connection) or die(mysql_error());
}

header("Location: ".$admin_dir."create_tournament.php");
exit;
?>
