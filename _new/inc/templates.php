<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) != "admin") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "";
$level = "";
$page_title = "";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
?>

<?
$sql = "";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {

}
?>
<?
$header = "";
include($root."inc/top.html");
?>
<?
$w3c = TRUE/FALSE;
include($root."inc/bottom.html");
?>
