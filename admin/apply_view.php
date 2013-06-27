<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");

check_login();

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) != "admin") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT * FROM applications WHERE id = '$_GET[id]'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $id           = $row[id];
        $uname        = $row[username];
        $email        = $row[email];        
        $gender       = ucfirst($row[gender]);
        $inbng        = $row[inbng];
        $bng_username = $row[bng_username];
        $time         = $row[timeinbng];
        $learned      = $row[learn_about];
        $told_by      = $row[referred_by];
        $know_ness    = $row[ness];
        $know_gb      = $row[gb];
        $how_know     = $row[know_staff];
}

if (!$inbng) {
        $bng_username = "*Not in BnG*";
        $time = "*Not in BnG*";
}

$know = "They do not know staff.";
if ($know_ness == "TRUE") {
        $know = "They know Ness";
        $n++;
}
if ($know_gb == "TRUE") {
        $know = "They know GB";
        $n++;
}
if ($n == 2) {
        $know = "They know both GB and Ness";
}

switch ($learned) {
case "referred":
        $learned_msg = "Was referred by squadmember";
        break;
case "thread":
        $learned_msg = "Read about it in a thread on a forum";
        break;
case "game":
        $learned_msg = "Learned about it in a game the squad plays";
        break;
case "websurf":
        $learned_msg = "Found it on a search engine";
        break;
}

?>
<html>
<head>
<title>
<? echo "$uname's Application"; ?>
</title>
<script language="javascript">
function TimedClose()
{
        timerID = setTimeout("finish()",1000)
}
function finish()
{
        clearTimeout(timerID)
        window.close()
}
</script>
<style type="text/css">
body {
        color: #E0B95B;
        background-image: url('<? echo $site_dir."/images/space.png"; ?>');
        font-size: 8pt;
        font-family: Verdana, sans-serif
}
a:link {color: #FFFFFF; text-decoration: none;}
a:visited {color: #E2C022; text-decoration: none;}
a:active {color: #4A92CD; text-decoration: underline;}
a:hover {color: #FFFFFF; text-decoration: underline;}
</style>
</head>
<body>

<table border="0" width="100%" cellspacing="0" cellpadding="0" height="257">
        <tr>
                <td width="100%" height="215">
                        <div align="center">
                        <center>
                        <table border="0" width="95%" height="14">
                                <tr>
                                        <td width="78%" colspan="2" height="19">
                                                <p align="center">
                                                <font size="6" face="Verdana">
                                                <? echo $uname; ?>
                                                </font>
                                        </td>
                                </tr>                                
                                <tr>
                                        <td width="29%" align="right" height="19">
                                                <p align="right">
                                                <font face="Verdana" size="1">
                                                Email:
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="19">
                                                <font face="Verdana" size="1">
                                                <? echo $email; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="29%" align="right" height="19">
                                                <font face="Verdana" size="1">
                                                Gender:
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="19">
                                                <font face="Verdana" size="1">
                                                <? echo $gender; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="29%" align="right" height="19">
                                                <font face="Verdana" size="1">
                                                BnG Username:
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="19">
                                                <font face="Verdana" size="1">
                                                <? echo $bng_username; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="29%" align="right" height="19">
                                                <font face="Verdana" size="1">
                                                Time in BnG:
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="19">
                                                <font face="Verdana" size="1">
                                                <? echo $time; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="29%" align="right" height="19">
                                                <font face="Verdana" size="1">
                                                Learned about squad:
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="19">
                                                <font face="Verdana" size="1">
                                                <? echo $learned_msg; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="29%" align="right" height="19">
                                                <font face="Verdana" size="1">
                                                Told to join by:
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="19">
                                                <font face="Verdana" size="1">
                                                <? echo $told_by; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="29%" align="right" height="19">
                                                <font face="Verdana" size="1">
                                                Do they know staff?
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="19">
                                                <font face="Verdana" size="1">
                                                <? echo $know; ?>
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="29%" align="right" height="1">
                                                <font face="Verdana" size="1">
                                                How?
                                                </font>
                                        </td>
                                        <td width="107%" align="center" height="1">
                                                <font face="Verdana" size="1">
                                                "<? echo $how_know; ?>"
                                                </font>
                                        </td>
                                </tr>
                                <tr>
                                        <td width="147%" align="right" height="1" colspan="3">
                                                <table border="0" width="100%">
                                                        <tr>
                                                                <td width="33%">
                                                                        <center>
                                                                        <? echo "<a href=\"".$admin_dir."applications.php?appl_id=$id&c=YES\" target=\"apply_admin\" onClick=\"TimedClose()\">ACCEPT</a>"; ?>
                                                                        </center>
                                                                </td>
                                                                <td width="33%">
                                                                        <center>
                                                                        <? echo "<a href=\"".$admin_dir."applications.php?appl_id=$id&c=DEL\" target=\"apply_admin\" onClick=\"TimedClose()\">DELETE</a>"; ?>
                                                                        </center>
                                                                </td>
                                                                <td width="33%">
                                                                        <center>
                                                                        <? echo "<a href=\"".$admin_dir."applications.php?appl_id=$id&c=NO\" target=\"apply_admin\" onClick=\"TimedClose()\">DECLINE</a>"; ?>
                                                                        </center>
                                                                </td>
                                                        </tr>
                                                </table>
                                        </td>
                                </tr>
                        </table>
                        </center>
                        </div>
                </td>
        </tr>
</table>
</body>
</html>
