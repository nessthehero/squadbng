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
$title = "Are you sure?";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if ($_POST[action] == "round") {
        $key = $_POST[t_key];
        $i = 1;
        $sql = "SELECT * FROM matches WHERE t_round = '$_POST[round]' AND t_key = '$key'";
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        $count = mysql_num_rows($result);
        if ($count == 1) {
                header("Location: ".$admin_dir."end.php?key=$key&round=$_POST[round]");
                exit;
        }
        $winners = array();
        while ($row = mysql_fetch_array($result)) {
                if ($row[play_2] != "UNEVEN") {
                        if ($row[p1score] > $row[p2score]) {
                                array_push($winners, $row[play_1]);
                        } else {
                                array_push($winners, $row[play_2]);
                        }
                } else {
                        array_push($winners, $row[play_1]);
                        $last_loser=$row[play_1];
                }
        $i++;
        }
        shuffle($winners);
        $size = sizeof($winners);
        if ($winners[$size-1] == $last_loser) {
                shuffle($winners);
        }
        if (odd($size)) {
                array_push($winners, "UNEVEN");
        }
        $size = sizeof($winners);
        $round = get_round($key) + 1;
        $i = 0;
        while ($i <= $size-1) {
                $p1 = $winners[$i];
                $p2 = $winners[$i + 1];
                $sql = "INSERT INTO matches VALUES ('', '$key', '$p1', '$p2', 0, 0, NULL, $round, 'NO')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                $i = $i + 2;
        }
        header("Location: ".$admin_dir."tournament.php");
        exit;
}
if ($_POST[action] == "delete") {
        $key = $_POST[t_key];
        $t_name = $_POST[t_name];
        $form = "
        <div align=\"center\">
        <center>
        <table border=\"0\" width=\"71%\">
                <tr>
                        <td width=\"100%\">
                          <p align=\"center\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Are you sure you want to delete this
                          tournament?</font><br>
                          </p>
                          <p align=\"center\">
                          <form method=\"POST\" action=\"delete.php\">
                            <input type=\"hidden\" value=\"$t_name\" name=\"tname\">
                            <input type=\"hidden\" value=\"$key\" name=\"t_key\">
                            <input type=\"submit\" value=\"Yes\" name=\"yes\">
                          </form>
                          <form method=\"POST\" action=\"tournament.php\">
                            <input type=\"submit\" value=\"No, I changed my mind! Keep the tournament!\" name=\"no\">
                            </p>
                          </form>
                        </td>
                </tr>
        </table>
        </center>
        </div>
        ";
}
?>
<html>
<head>
<title>
Squad BnG - <? echo $page_title; ?>
</title>
</head>
<body background="<? echo $img_BG; ?>" link="#FFFFFF" vlink="#E2C022" alink="#4A92CD" text="#E0B95B">

<center>
<font color="#E0B95B" size="1" face="Verdana">

<div align="center"><center>

<table border="0" width="548" bgcolor="#000000" height="98">
    <tr>
        <td valign="top" width="103" height="90"><table
        border="0" cellpadding="0" cellspacing="0" width="100%"
        height="1">
        <td height="72"><img border="0" src="<? echo $img_logo; ?>">
            <tr>
                <td width="100%" height="3"><img border="0" src="<? echo $img_menuTOP; ?>"></td>
                                </tr>
                                <tr>
                                        <td width="100%" background="<? echo $img_menuBG; ?>" height="1">
                                                <p align="center">
                                                <? echo buttons($level); ?>
                                                </p>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="100%" height="1"><img border="0" src="<? echo $img_menuBOTTOM; ?>"></td>
                                </tr>
</table>
        </td>
        <td width="681" height="94"><div align="center"><center><table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="100%"><img border="0" src="<? echo $img_TOP[$page_topimg]; ?>"></td>
            </tr>
            <tr>
                <td width="100%" background="<? echo $img_tableBG; ?>">
                <? echo "$form"; ?>
                </td>
            </tr>
            <tr>
                <td width="100%"><img src="<? echo $img_tableBOTTOM; ?>"></td>
            </tr>
        </table>
          </div></td>
    </tr>
</table>
  </div>

<font color="#E0B95B" size="1" face="Verdana">


<hr width="33%">
<div align="center"><center>

<table border="0">
   <tr>
        <td width="600" border="0">
        <p align="center">
        <font face="Verdana" size="1" color="#E0B95B">
        BnG Squad was created by <a href="mailto:nessthehero@boundforearth.com">NessTheHero</a>, <a href="mailto:GB330033@houston.rr.com">GB330033</a>, and contributed
        help from others. Everything in this site is fan-made. &quot;BnG&quot;, <a href="http://www.bobandgeorge.com/"> &quot;Bob and George&quot;</a>, and all things
        related to the comic of that name are copyright to Dave Anez. <a href="http://www.trenchwars.org/">Trench Wars</a> is copyrighted by Priitk. <a href="http://www.subspacehq.com/">Subspace</a> is owned by the
        fans and gamers who operate it, and was created by Virgin Interactive Entertainment. <br>
        This is a non profit site.</font></p>
        </td>
    </tr>
</table>
</center></div>
</body>
</html>
