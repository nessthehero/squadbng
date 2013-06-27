<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "bwadmin";
$level = rank($_SESSION[username]);
$page_title = "Ban a squadmember from BnG Wars";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$message = "";

if ($_GET[act] == "add") {
        $u_id = $_POST[user];
        $ban = $_POST[bannum];
        $_POST[iban] = TRUE ? $setto = "I" : $setto = $ban;
        $sql = array();
        if (!tourny_status("active")) {
                $sql[1] = "UPDATE squadmembers SET ban = '$setto' WHERE id = '$u_id'";
                $sql[2] = "UPDATE squadmembers SET intourn = 'no' WHERE id = '$u_id'";
                $sql[3] = "UPDATE squadmembers SET team_id = '0' WHERE id = '$u_id'";
                $sql[4] = "UPDATE squadmembers SET rank = 'squad' WHERE id = '$u_id''";
                $result = mysql_query($sql[1],$connection) or die(mysql_error());
                $result = mysql_query($sql[2],$connection) or die(mysql_error());
                $result = mysql_query($sql[3],$connection) or die(mysql_error());
                $result = mysql_query($sql[4],$connection) or die(mysql_error());
        } else {
                $sql[1] = "UPDATE squadmembers SET ban = '$setto' WHERE id = '$u_id'";
                $result = mysql_query($sql[1],$connection) or die(mysql_error());
        }
        $message = "<center>User banned successfully!</center>";
}
if ($_GET[act] == "rem") {
        $u_id = $_POST[user];
        $lowerban = $_POST[lower];
        $_POST[repeal] = TRUE ? $sql = "UPDATE squadmembers SET ban = 0 WHERE id = '$u_id'" : $sql = "UPDATE squadmembers SET ban = ban - $lowerban WHERE id = '$u_id'";

        $result = mysql_query($sql,$connection) or die(mysql_error());
        $message = "<center>Ban changed successfully!</center>";
}
$header = "";
include($root."inc/top.html");
?>

<? echo $message; ?>
<form method="POST" action="ban.php?act=add">
        <div align="center">
        <center>
        <table border="0" width="70%">
                <tr>
                        <td width="39%" align="right">
                                <font>
                                Squad member:
                                </font>
                        </td>
                        <td width="61%">
                                <center>
                                <select size="1" name="user">
                                <?
                                        $sql = "SELECT username FROM squadmembers WHERE ban != 'I' AND ban = '0'";
                                        $result = mysql_query($sql,$connection) or die(mysql_error());
                                        while ($row = mysql_fetch_array($result)) {
                                                echo "<option value=\"$row[id]\">$row[username]</option>\n";
                                        }
                                ?>
                                </select>
                                </center>
                        </td>
                </tr>
                <tr>
                        <td width="39%" align="right">
                                <font>
                                How many tournaments?:
                                </font>
                        </td>
                        <td width="61%">
                                <center>
                                <input type="text" name="bannum" size="5">
                                </center>
                        </td>
                </tr>
                <tr>
                        <td width="39%" align="right">
                                <font>
                                Indefinitely?:
                                </font>
                        </td>
                        <td width="61%">
                                <center>
                                <input type="checkbox" name="iban" value="TRUE">
                                </center>
                        </td>
                </tr>
        </table>
        </div>
        <center>
        <input type="submit" value="Submit" name="B1">
        <input type="reset" value="Reset" name="B2">
        </center>
</form>
<form method="post" action="ban.php?act=rem">
        <div align="center">
        <center>
        <table border="0" width="69%" height="1">
                <tr>
                        <td width="39%" height="1" align="right">
                                <font>
                                Squadmember:
                                </font>
                        </td>
                        <td width="61%" align="center" height="1">
                                <select size="1" name="user">
                                <?
                                $sql = "SELECT * FROM squadmembers WHERE ban = 'I' OR ban > 0";
                                $result = mysql_query($sql,$connection) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                        echo "<option value=\"$row[id]\">$row[username] ($row[ban])</option>\n";
                                }
                                ?>
                                </select>
                        </td>
                </tr>
                <tr>
                        <td width="39%" height="1" align="right">
                                <font>
                                Lower ban by:
                                </font>
                        </td>
                        <td width="61%" align="center" height="1">
                                <input type="text" name="lower" size="5">
                        </td>
                </tr>
                <tr>
                        <td width="39%" height="16" align="right">
                                <font>
                                Repeal ban?:
                                </font>
                        </td>
                        <td width="61%" align="center" height="16">
                                <input type="checkbox" name="repeal" value="TRUE">
                        </td>
                </tr>
        </table>
        </center>
        </div>
        <br>
        <center>
        <input type="submit" value="Submit" name="B1">
        <input type="reset" value="Reset" name="B2">
        </center>
</form>

<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
