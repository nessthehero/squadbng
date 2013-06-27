<?
session_start();

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "squad";
$level = "squad";
$page_title = "Change your password";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (!isset($_SESSION[username])) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

if (isset($_POST[change])) {
        $uname = trim($_POST[username]);
        $opass = md5($_POST[oldpass]);
        $pass = md5($_POST[newpass]);
        $pass2 = md5($_POST[newpass2]);

        if ($uname != $_SESSION[username]) {
                header("Location: ".$site_dir."profile.php");
                exit;
        }

        if ($pass != $pass2) {
                header("Location: ".$site_dir."changepass.php");
                exit;
        }

        $sql = "SELECT * FROM squadmembers WHERE username = '$uname'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $row = mysql_fetch_array($result);
        if (mysql_num_rows($result) == 1) {
                if ($opass != $row[password]) {
                        $header = "Password not changed!";
                        $msg = "Original Password incorrect. Please go back and try again.<br><br>
                        <a href=\"".$site_dir."changepass.php\">Back</a>";
                } else {
                        $sql = "UPDATE squadmembers SET password = '$pass' WHERE username = '$uname'";
                        $update = @mysql_query($sql,$connection) or die(mysql_error());
                        if ($update) {
                                $msg = "Password changed successfully! You can now return to the log-in area.<br><br>
                                <a href=\"".$site_dir."accountlogin.php\">Login</a>";
                                $header = "Password changed!";
                        }
                }
        } else {
                        $header = "Password not changed!";
                        $msg = "Could not find username in our databases.
                        Please create a name in order to access site features<br>
                        <a href=\"".$site_dir."createaccount.php\">Create an Account</a>";
        }
        $page = "
<div align=\"center\">
<center>
<table border=\"0\" width=\"70%\">
        <tr>
                <td width=\"100%\">
                        <center>
                        <font>
                        $header
                        <hr>
                        $msg
                        </font>
                        </center>
                </td>
        </tr>
</table>
</center>
</div>
        ";
} else {
        $page = "
<div align=\"center\">
<center>
<table border=\"0\" width=\"75%\">
        <tr>
                <td width=\"100%\">
                        <form method=\"POST\" action=\"changepass.php\">
                                <input type=\"hidden\" name=\"change\" value=\"yes\">
                                <center>
                                <font>
                                Change your Password
                                </font>
                                </center>
                                <hr>
                                <div align=\"center\">
                                <table border=\"0\" width=\"77%\">
                                        <tr>
                                                <td width=\"50%\" align=\"right\">
                                                        <font>
                                                        Enter your username:
                                                        </font>
                                                </td>
                                                <td width=\"50%\">
                                                        <input type=\"text\" name=\"username\" size=\"25\">
                                                </td>
                                        </tr>
                                        <tr>
                                                <td width=\"50%\" align=\"right\">
                                                        <font>
                                                        Enter your current password:
                                                        </font>
                                                </td>
                                                <td width=\"50%\">
                                                        <input type=\"password\" name=\"oldpass\" size=\"25\">
                                                </td>
                                        </tr>
                                        <tr>
                                                <td width=\"50%\" align=\"right\">
                                                        <font>
                                                        Enter new password:
                                                        </font>
                                                </td>
                                                <td width=\"50%\">
                                                        <input type=\"password\" name=\"newpass\" size=\"25\">
                                                </td>
                                        </tr>
                                        <tr>
                                                <td width=\"50%\" align=\"right\">
                                                        <font>
                                                        Enter password again:
                                                        </font>
                                                </td>
                                                <td width=\"50%\">
                                                        <input type=\"password\" name=\"newpass2\" size=\"25\">
                                                </td>
                                        </tr>
                                </table>
                                </div>
                                <center>
                                <input type=\"submit\" value=\"Change Password\">
                                <input type=\"reset\" value=\"Reset\">
                                </center>
                        </form>
                </td>
        </tr>
</table>
</center>
</div>
        ";
}

$header = "";
include($root."inc/top.html");
echo $page;
$w3c = FALSE;
include($root."inc/bottom.html");
?>
