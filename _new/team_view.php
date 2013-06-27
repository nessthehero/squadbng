<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
?>
<html>
<head>
<title>View Teammates</title>
</head>
<body bgcolor="#000080" text="#E0B95B">
<center>
<b>
<u>
<? echo team_name($_GET[id]); ?>
</u>
</b>
</center>
<br>
<br>
<div align="center">
<table border="0" width="auto" cellspacing="0" cellpadding="0">
<?

        $sql = "SELECT username FROM squadmembers WHERE team_id = '$_GET[id]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $teammate_block .= "
                        <tr>
                                <td>
                                $row[username]
                                </td>
                        </tr>
                ";
        }
        echo $teammate_block;

?>
</table>
</div>
<br>
<center><form><input type="button" value="Close this window" onClick="window.close()"></form></center>
</body>
</html>
