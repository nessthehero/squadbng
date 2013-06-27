<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "members";
$level = "squad";
$page_title = "Members";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

include($root."inc/top.html");
?>
<center>
<font>
The following is a list of all <U>active</U> squad members.
</font>
<br>
<br>
</center>

<div align="center">
<center>
<table border="0" width="24%">
                      <!-- PHP controlled list -->
<?
$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT * FROM squadmembers ORDER BY username";
$result = @mysql_query($sql,$connection) or die(mysql_error());
if ($result) {
        while($row = mysql_fetch_array($result)) {
                $uname = $row[username];
                $rank = $row[rank];
                if (isset($_SESSION[username])) {
                        $profile_link = "
                        <font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">
                        [<a href=\"".$site_dir."profile.php?user=$uname\">P</a>]
                        </font>
                        ";
                } else {
                        $profile_link = "";
                }
                if ($rank == "admin") {
                        $color = "#FF0000";
                        $adminblock .= "
                        <tr>
                        <td width=\"100%\">
                        <font face=\"Verdana\" size=\"1\" color=\"$color\">
                        $uname
                        </font>
                        $profile_link
                        </td>
                        </tr>
                        ";
                }
                if ($rank == "judge") {
                        $color = "#008000";
                        $judgeblock .= "
                        <tr>
                        <td width=\"100%\">
                        <font face=\"Verdana\" size=\"1\" color=\"$color\">
                        $uname
                        </font>
                        $profile_link
                        </td>
                        </tr>
                        ";
                }
                if ($rank == "squad") {
                        $color = "#E0B95B";
                        $userblock .= "
                        <tr>
                        <td width=\"100%\">
                        <font face=\"Verdana\" size=\"1\" color=\"$color\">
                        $uname
                        </font>
                        $profile_link
                        </td>
                        </tr>
                        ";
                }
}
}
echo $adminblock;
echo $judgeblock;
echo $userblock;

?>
        <tr>
                <td width="100%">
                </td>
        </tr>
</table>
</center>
</div>
<p align="center">
<br>
<br>
<font>
[
</font>
<font face="Verdana" size="1" color="#FF0000">
Site Administrator
</font>
<font>
][
</font>
<font face="Verdana" size="1" color="#008000">
Tournament Judge
</font>
<font>
*] [Squadmember]
</font>
</p>
<br>
<br>
<center>
* (Only during Active Tournaments)
</center>
<?
$w3c = TRUE;
include($root."inc/bottom.html");
?>
