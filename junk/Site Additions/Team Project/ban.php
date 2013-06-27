<?
session_start();

include("vars.php");
include("functions.php");
include("images.php");

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

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$message = "";


if ($_GET[act] == "add") {
        $uname = $_POST[user];
        $ban = $_POST[bannum];
        $forever = $_POST[iban];
        if ($forever) {
                $setto = "I";
        } else {
                $setto = $ban;
        }
        $sql = array();
        if (!tourny_status("active")) {
                $sql[1] = "UPDATE squadmembers SET ban = '$setto' WHERE username = '$uname'";
                $sql[2] = "UPDATE squadmembers SET intourn = 'no' WHERE username = '$uname'";
                $sql[3] = "UPDATE tournaments SET peeps = peeps-1 WHERE status = 'active'";
                $sql[4] = "UPDATE tournaments SET peeps = peeps-1 WHERE status = 'pending'";
                $result = mysql_query($sql[1],$connection) or die(mysql_error());
                $result = mysql_query($sql[2],$connection) or die(mysql_error());
                $result = mysql_query($sql[3],$connection) or die(mysql_error());
                $result = mysql_query($sql[4],$connection) or die(mysql_error());
        } else {
                $sql[1] = "UPDATE squadmembers SET ban = '$setto' WHERE username = '$uname'";
                $result = mysql_query($sql[1],$connection) or die(mysql_error());
        }
        $message = "<center>User banned successfully!</center>";
}
if ($_GET[act] == "rem") {
        $uname = $_POST[user];
        $lowerban = $_POST[lower];
        $repeal = $_POST[repeal];
        if ($repeal) {
                $sql = "UPDATE squadmembers SET ban = 0 WHERE username = '$uname'";
        } else {
                $sql = "UPDATE squadmembers SET ban = ban - $lowerban WHERE username = '$uname'";
        }

        $result = mysql_query($sql,$connection) or die(mysql_error());
        $message = "<center>Ban changed successfully!</center>";
}
$header = "";
include($site_dir."top.html");
?>
                <? echo $message; ?>
<form method="POST" action="ban.php?act=add">
                    <div align="center">
                      <center>
                      <table border="0" width="70%">
                        <tr>
                          <td width="39%" align="right"><font face="Verdana" size="1">Squad member:</font></td>
                          <td width="61%">
                            <p align="center">
                            <select size="1" name="user">
                            <?
                            $sql = "SELECT username FROM squadmembers WHERE ban != 'I' AND ban = '0'";
                            $result = mysql_query($sql,$connection) or die(mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                echo "<option>$row[username]</option>\n";
                            }
                            ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td width="39%" align="right"><font face="Verdana" size="1">How many tournaments?:</font></td>
                          <td width="61%">
                            <p align="center"><input type="text" name="bannum" size="5"></td>
                        </tr>
                        <tr>
                          <td width="39%" align="right"><font face="Verdana" size="1">Indefinitely?:</font></td>
                      </center>
                        </center>
                        </center>
                        </center>
                          <td width="61%">
                            <p align="center"><input type="checkbox" name="iban" value="TRUE"></td>
                        </tr>
                      </table>
                    </div>


                        <center>
                        <center>

                        <center>
                    <p align="center"><input type="submit" value="Submit" name="B1"><input type="reset" value="Reset" name="B2"></p>
                  </form>
<form method="post" action="ban.php?act=rem">

<div align="center">
  <center>
  <table border="0" width="69%" height="1">
    <tr>
      <td width="39%" height="1" align="right"><font face="Verdana" size="1">Squad
        member:</font></td>
      <td width="61%" align="center" height="1">
      <select size="1" name="user">
        <?
                            $sql = "SELECT * FROM squadmembers WHERE ban = 'I' OR ban > 0";
                            $result = mysql_query($sql,$connection) or die(mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                echo "<option value=\"$row[username]\">$row[username] ($row[ban])</option>\n";
                            }
        ?>
        </select></td>
    </tr>
    <tr>
      <td width="39%" height="1" align="right"><font face="Verdana" size="1">Lower
        ban by:</font></td>
      <td width="61%" align="center" height="1"><input type="text" name="lower" size="5"></td>
    </tr>
    <tr>
      <td width="39%" height="16" align="right"><font face="Verdana" size="1">Repeal
        ban?:</font></td>
      <td width="61%" align="center" height="16"><input type="checkbox" name="repeal" value="TRUE"></td>
    </tr>
  </table>
  </center>
</div>
<p><input type="submit" value="Submit" name="B1"><input type="reset" value="Reset" name="B2"></p>

</form>
</center></center></center>
<? include($site_dir."bottom.html"); ?>
