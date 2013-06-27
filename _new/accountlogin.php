<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "squad";
$level = "squad";
$page_title = "Login to Squad BnG";
$header = "";
include($root."inc/top.html");
?>
<div align="center">
<br><br>
<form method="post" action="login.php">
        <table border="0" width="50%" cellspacing="4">
                <tr>
                        <td width="100%" colspan="2">
                                <center>
                                <font>
                                Account Login<br><br>
                                Type in your username and password<br><br>
                                </font>
                                </center>
                        </td>
                </tr>
                <tr>
                        <td width="35%" align="right">
                                <font>
                                Username:
                                </font>
                        </td>
                        <td width="65%">
                                <font>
                                <input type="text" name="username" size="25">
                                </font>
                        </td>
                </tr>
                <tr>
                        <td width="35%" align="right">
                                <font>
                                Password:
                                </font>
                        </td>
                        <td width="65%">
                                <font>
                                <input type="password" name="password" size="25">
                                </font>
                        </td>
                </tr>
        </table>
        <input type="submit" value="Log-in" name="login">
        <input type="reset" value="Try again" name="reset">
</form>
</div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
