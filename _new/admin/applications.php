<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

if (!$_SESSION[username]) {
//print "No username";
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) != "admin") {
//print "Not admin\n";
//print rank($_SESSION[username])."\n";
//print $_SESSION[username]."\n";
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "admin";
$level = rank($_SESSION[username]);
$page_title = "Applications to join the Squad";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (isset($_GET[appl_id])) {
        $sql = "SELECT * FROM applications WHERE id = '$_GET[appl_id]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 1) {
                header("Location: ".$admin_dir."applications.php");
                exit;
        }
        if ($_GET[c] == "YES") {
                while ($row = mysql_fetch_array($result)) {
                $id = $row[id];
                $s_user = htmlspecialchars($row[username], ENT_QUOTES);
                $s_pass = $row[password];
                $s_email = $row[email];                
                $s_gender = $row[gender];
                }
                $subject = "Squad BnG Application accepted!";
$msg = "
Congratulations!
                
You have been accepted to Squad BnG! You are now able to sign up for tournaments and recieve
messages that other squadmembers recieve. Plus, you can access any portion of the site that only squadmembers
would be able to view.
                
Please note, that upon acceptance, attendance is expected in squad events. If you simply dissapear
after being accepted, you are most likely to be deleted after a certain period of time.
                
We thank you for your interest! See you in the games!
                
-NessTheHero and GB330033
\tSquad BnG Administrators
";
                $header = "From: Squad BnG";
                $sql = "INSERT INTO squadmembers VALUES ('', '$s_user', '$s_email', '$s_pass', '$s_gender', 0, 0, 0, 'no', 'squad')";
                @mysql_query($sql,$connection) or die(mysql_error());
                mail($s_email, stripslashes($subject), stripslashes($msg), $header);
                $sql = "DELETE FROM applications WHERE id = '$id'";
                @mysql_query($sql,$connection) or die(mysql_error());
                if (check_purge()) {
                        $sql = "INSERT INTO purge VALUES ('', '".get_user_id($s_user)."', 'no')";
                        @mysql_query($sql,$connection) or die(mysql_error());
                }
                header("Location: ".$admin_dir."applications.php");
                exit;
        }
        if ($_GET[c] == "NO") {
                while ($row = mysql_fetch_array($result)) {
                $id = $row[id];
                $s_email = $row[email];
                }
                $subject = "Squad BnG Application declined";
$msg = "
We're sorry!
                
Unfortunately, your application to join Squad BnG was declined. If you have any
questions as to why, please contact NessTheHero on the forums.
                
We hope that someday you might be able to join us! Maybe next time!

-NessTheHero and GB330033
\tSquad BnG Administrators
";
                $header = "From: Squad BnG";
                mail($s_email, stripslashes($subject), stripslashes($msg), $header);
                $sql = "DELETE FROM applications WHERE id = '$id'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                header("Location: ".$admin_dir."applications.php");
                exit;
        }
        if ($_GET[c] == "DEL") {
                while ($row = mysql_fetch_array($result)) {
                        $id = $row[id];
                }
                $sql = "DELETE FROM applications WHERE id = '$id'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                header("Location: ".$admin_dir."applications.php");
                exit;
        }
        if (($_GET[c] != "YES") && ($_GET[c] != "NO") && ($_GET[c] != "DEL")) {
                header("Location: ".$admin_dir."applications.php");
                exit;
        }
}

$sql = "SELECT * FROM applications ORDER BY id";
$result = @mysql_query($sql,$connection) or die(mysql_error());
if (mysql_num_rows($result) != 0) {
        $appl_table = "
                <div align=\"center\">
                <center>
                <table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
        ";
        while ($row = mysql_fetch_array($result)) {
                $appl_table .= "
                        <tr>
                          <td width=\"100%\">
                            <p align=\"center\">
                            <form>
                            <input type=\"button\" value=\"$row[username] -- $row[email]\" onClick=\"OpenApplication($row[id])\">
                            </form>
                            </a>
                          </td>
                        </tr>
                ";
        }
        $appl_table .= "
                </table>
              </center>
            </div>
        ";
} else {
        $appl_table = "<center>No applications are pending at the moment</center>";
}
$header = "
<script language=\"javascript\">
<!-- Hiding Javascript
function OpenApplication(id)
        {
var site = 'apply_view.php?id='+id
self.name='apply_admin'
Application=window.open (site, 'application', config='height=300, width=325, toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, directories=no, status=no');
        }
// End Hiding -->
</script>
";
include($root."inc/top.html");
echo $appl_table;
$w3c = FALSE;
include($root."inc/bottom.html");
?>
