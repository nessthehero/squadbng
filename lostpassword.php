<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

if (isset($_SESSION[username])) {
        header("Location: ".$site_dir."profile.php");
        exit;
}

$page_topimg = "squad";
$level = "squad";
$page_title = "Password Recovery System";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (!$_POST[user_id]) {
        $page = "
<div align=\"center\">
<center>
<table border=\"0\" width=\"70%\">
        <tr>
                <td width=\"100%\">
                        <center>
                        <font>
                        Lost Password
                        </font>
                        </center>
                        <hr>
                        <center>
                        <p>
                        <font>
                        Please enter your username
                        </font>
                        </p>
                        <form method=\"POST\" action=\"lostpassword.php\">
                                <center>
                                <input type=\"text\" name=\"user_id\" size=\"30\">
                                <br><br>
                                <input type=\"submit\" value=\"Get New Password\">
                                </center>
                        </form>
                        </center>
                </td>
        </tr>
</table>
</center>
</div>
        ";
} else {

        $u_id = get_user_id($_POST[user_id]);

        $sql = "SELECT * FROM squadmembers WHERE id = '$u_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                $msg = "
                That account does not exist in our database.<br>
                Please create a name in order to access site features.<br><br>
                <a href=\"".$site_dir."createaccount.php\">Create a username<\a>
                ";
        } else {
                while ($row = mysql_fetch_array($result)) {
                        $id = $row[id];
                        $uname = $row[username];
                        $pass = $row[password];
                        $email = $row[email];
                }
                $pass = uniqid($username);

                $subject = "New password from Squad BnG";
                $header = "From: Squad BnG Administration";
                $mail = "
                Your new password has arrived!
                Please change it to something you will remember.

                Password = $pass

                <a href=\"".$site_dir."/changepass.php\">Change your password</a>
                If you cannot click the above link, goto this address:
                ".$site_dir."changepass.php

                \t-Squad BnG Administration";

                $pass = md5($pass);
                $sql = "UPDATE squadmembers SET password = '$pass' WHERE id = '$id'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                if ($result) {
                        $msg = "
                        Your new password has been sent to you.<br><br>
                        <a href=\"".$site_dir."accountlogin.php\">Back to Login</a>
                        ";
                        mail($email, $subject, $mail, $header);
                }
        }
        $page = "
<div align=\"center\">
<center>
<table border=\"0\" width=\"70%\">
        <tr>
                <td width=\"100%\">
                        <center>
                        <font>
                        Password Sent to $email
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
}

$header = "";
include($root."inc/top.html");
echo $page;
$w3c = FALSE;
include($root."inc/bottom.html");
?>
