<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (($_POST[username] == "") || ($_POST[password] == "")) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$destination = "Location: ".$site_dir."profile.php";

$uname = $_POST[username];
$pass = md5($_POST[password]);

$sql = "SELECT * FROM squadmembers WHERE username = '$uname'";
$result = @mysql_query($sql,$connection) or die(mysql_error());

if (mysql_num_rows($result) == 0) {
        $_SESSION[error] = "noname";
        header("Location: ".$site_dir."loginerror.php");
        exit;
} else {

        while ($row = mysql_fetch_array($result)) {
                $idunam = $row[username];
                $idpass = trim($row[password]);
                $rank = $row[rank];
        }
        if ($pass != $idpass) {
                $_SESSION[error] = "badpass";
                header("Location: ".$site_dir."loginerror.php");
                exit;
        } else {
                if ($rank == "admin") {
                        $_SESSION[rank] = "ADMIN";
                }
                if ($rank == "judge") {
                        $_SESSION[rank] = "JUDGE";
                }
                if ($rank == "squad") {
                        $_SESSION[rank] = "SQUAD";
                }
                $_SESSION[username] = $uname;

                $cookie_name = "SQUADBNG_LOGIN";
                $cookie_value = strtoupper($uname);

                
                setcookie($cookie_name, $cookie_value, mktime()+60*60*24*365, "/", "", 0);

                header($destination);
                exit;
        }
}
?>
