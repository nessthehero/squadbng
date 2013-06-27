<?
session_start();

include("vars.php");
include("functions.php");
include("images.php");

check_login();

$page_topimg = "bngwars";
$level = "squad";
$page_title = "Sign up for the tournament!";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$msg = "
Thank you for signing up!<p>\n
We will contact you when the tournament starts.<p>\n
Start practicing! The tournament starts when we get enough people!<p>\n
<a href=\"$site_dir/bngwars.php\">BnG Wars page</a>\n
";

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."bngwars.php");
        exit;
}

$signed_up = TRUE;

$sql = "SELECT signups FROM tourneystats WHERE t_key = '$_POST[key]'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $signups = $row[signups];
}
if ($signups == "OFF") {
        header("Location: ".$site_dir."bngwars.php");
        exit;
}

$sql = "SELECT * FROM squadmembers WHERE username = '$_SESSION[username]'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[intourn] == "yes") {
                $msg = "
                You have already signed up for this tournament.<p>\n
                We will notify you when the matches start.<p>\n
                Watch your inboxes! We'll be sending out e-mails!<p>\n
                <a href=\"".$site_dir."bngwars.php\">BnG Wars page</a>\n
                ";
                $signed_up = FALSE;
        }
        if ($row[ban] == "I") {
                $msg = "
                You are banned forever from all tournaments.<p>\n
                Dunno what you did, but it was probably really bad.<p>\n
                If you think you recieved this in error, please contact Ness.<p>\n
                <a href=\"".$site_dir."bngwars.php\">BnG Wars page</a>\n
                ";
                $signed_up = FALSE;
        } elseif ($row[ban] > 0) {
                $msg = "
                You are banned for $row[ban] tournament/s.<p>\n
                Please wait out your ban before deciding to participate.<p>\n
                If you think you were banned in error, please contact Ness.<p>\n
                <a href=\"".$site_dir."bngwars.php\">BnG Wars page</a>\n
                ";
                $signed_up = FALSE;
        }
}

if ($signed_up) {
        $sql = "UPDATE squadmembers SET intourn = 'yes' WHERE username = '$_SESSION[username]'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        $sql = "UPDATE tournaments SET peeps = peeps+1 WHERE status = 'pending'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
}

include($site_dir."top.html");
?>
                  <center>
                  <font face="Verdana" size="1">
                  <? echo $msg; ?>
                  </font>
                  </center>
<? include($site_dir."bottom.html"); ?>
