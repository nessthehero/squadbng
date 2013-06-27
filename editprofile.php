<?
session_start();

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

check_login();

$page_topimg = "squad";
$level = "squad";
$page_title = "Edit your profile";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

if (!$_GET[e]) {
        header("Location: ".$site_dir."/profile.php");
        exit;
}
$edit = $_GET[e];

$error = "";

if ($_GET[error] == TRUE) {
        if ($_GET[type] == "BLANK") {
                $error = "<br><br><center>You must type in a name for it to work!</center>";
        }
        if ($_GET[type] == "TAKEN") {
                $error = "<br><br><center>That name is already taken. Please choose another.</center>";
        }
}

$uname = $_SESSION[username];


$sql = "SELECT * FROM squadmembers WHERE username = '$uname'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while($row = mysql_fetch_array($result)) {
$bname = $row[bracketname];
$email = $row[email];
$intourn = $row[intourn];
}

if ($edit == "username") {
        $formblock = "
<form method=\"POST\" action=\"do_editprofile.php?e=$edit\">\n
<input type=\"hidden\" name=\"form\" value=\"yes\">\n
<div align=\"center\">\n
  <center>\n
<table border=\"0\" width=\"67%\" height=\"1\" cellpadding=\"0\" cellspacing=\"3\">\n
  <tr>\n
    <td width=\"50%\" height=\"19\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Old Username:</font></td>\n
    <td width=\"50%\" height=\"19\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">$uname</td>\n
  </tr>\n
  <tr>\n
    <td width=\"50%\" height=\"1\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Desired Username:</font></td>\n
    <td width=\"50%\" height=\"1\"><input type=\"text\" name=\"new\" size=\"20\"></td>\n
  </tr>\n
</table>\n
  </center>\n
</div>\n
<br>\n
<input type=\"submit\" value=\"Submit\"><input type=\"reset\" value=\"Reset\">\n
</form>\n
        ";
} elseif ($edit == "email") {
        $formblock = "
<form method=\"POST\" action=\"do_editprofile.php?e=$edit\">\n
<input type=\"hidden\" name=\"form\" value=\"yes\">\n
<div align=\"center\">\n
  <center>\n
<table border=\"0\" width=\"79%\" height=\"1\" cellpadding=\"0\" cellspacing=\"3\">\n
  <tr>\n
    <td width=\"50%\" height=\"19\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">Old E-mail:</font></td>\n
    <td width=\"50%\" height=\"19\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">$email</td>\n
  </tr>\n
  <tr>\n
    <td width=\"50%\" height=\"1\" align=\"right\"><font face=\"Verdana\" size=\"1\" color=\"#E0B95B\">New E-mail:</font></td>\n
    <td width=\"50%\" height=\"1\"><input type=\"text\" name=\"new\" size=\"30\"></td>\n
  </tr>\n
</table>\n
  </center>\n
</div>\n
<br>\n
<input type=\"submit\" value=\"Submit\"><input type=\"reset\" value=\"Reset\">\n
</form>\n
        ";
} else {
        header("Location: ".$site_dir."profile.php");
        exit;
}

switch($edit) {
	case "username":
        $header = "Username".$error;
        break;
	case "email":
        $header = "E-Mail Address";
        break;
}
include($root."inc/top.html");
?>
<div align="center">
<font face="Verdana" size="1" color="#E0B95B">
          <center>
          <table border="0" width="70%">
            <tr>
              <td width="100%">
              <center>
              <font face="Verdana" size="1" color="#E0B95B">
Editing your <? echo "$header"; ?>
              </font
              ></center>
              <hr>
              <center>
<? echo "$formblock"; ?>
              </center>
              </td>
            </tr>
          </table>
          </center>
          </font>
        </div>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
