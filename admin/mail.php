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

$page_topimg = "admin";
$level = rank($_SESSION[username]);
$page_title = "Send a message to Squadmembers";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$message = "";
if (isset($_POST[op])) {
        switch ($_POST[to]) {
        case "all":
                $sql = "SELECT email FROM squadmembers";
                break;
        case "bngwars":
                $sql = "SELECT email FROM squadmembers WHERE intourn = 'yes'";
                break;
        case "non_bngwars":
                $sql = "SELECT email FROM squadmembers WHERE intourn = 'no'";
                break;
        case "admin":
                $sql = "SELECT email FROM squadmembers WHERE rank != 'squad'";
                break;
        }
        $result = mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                mail($row[email],stripslashes($_POST[subject]),stripslashes($_POST[msg]),"From: BnG Squad Administration");
        }
        $message = "<center>Message sent successfully</center>";
}
$header = "";
include($root."inc/top.html");
?>
<? echo $message; ?>

<center>
<form method="POST" action="mail.php">
        <input type="hidden" value="ds" name="op">
        <select size="1" name="to">
        <option selected value="all">All Squadmembers</option>
        <option value="bngwars">Members in Tournament</option>
        <option value="non_bngwars">Members not in tournament</option>
        <option value="admin">Judges and Administrators Only</option>
        </select><br>
        Subject: <input type="text" name="subject" size="41"><br>
        <textarea rows="12" name="msg" cols="56"></textarea><br>
        <input type="submit" value="Send the newsletter">
</form>
</center>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
