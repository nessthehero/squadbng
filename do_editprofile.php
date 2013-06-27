<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$uname = $_SESSION[username];

if ((isset($_GET[e])) && ($_POST[form] == "yes")) {
        if ($_GET[e] == "username") {
                if (strlen("$_POST[new]") < 1) {
                        header("Location: ".$site_dir."editprofile.php?error=TRUE&type=BLANK&e=$_GET[e]");
                        exit;
                }
                $sql = "SELECT username FROM squadmembers WHERE username = '$_POST[new]'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                if (mysql_num_rows($result) == 0) {
                        $_SESSION[username] = "$_POST[new]";
                        setcookie('SQUADBNG_LOGIN', FALSE);
                        $cookie_name = "SQUADBNG_LOGIN";
                        $cookie_value = strtoupper($_SESSION[username]);
                        setcookie($cookie_name, $cookie_value, mktime()+60*60*24*365, "/", "", 0);
                        $sql = "UPDATE awards SET username = '$_POST[new]' WHERE username = '$uname'";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                } else {
                        header("Location: ".$site_dir."editprofile.php?error=TRUE&type=TAKEN&e=$_GET[e]");
                        exit;
                }
        }        
        $sql = "UPDATE squadmembers SET $_GET[e] = '$_POST[new]' WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if ($result) {
                header("Location: ".$site_dir."profile.php");
                exit;
        }
} else {
        header("Location: ".$site_dir."profile.php");
        exit;
}
?>
