<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");

if (!$_SESSION[username]) {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

if (!isset($_POST[t_name])) {
        header("Location: ".$admin_dir."tournament.php");
        exit;
}
$t_name = $_POST[t_name];
$key = get_key();

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = array();
$sql[] = "DELETE FROM tournaments WHERE t_key = '$key'";
$sql[] = "DELETE FROM t_stats WHERE t_key = '$key'";
$sql[] = "DELETE FROM t_options WHERE t_key = '$key'";
$sql[] = "DELETE FROM matches WHERE t_key = '$key'";
$sql[] = "DELETE FROM logs WHERE t_key = '$key'";
$sql[] = "UPDATE squadmembers SET intourn = 'no'";
if (get_tourn_var($key, "teams") == "yes") {
        $sql[] = "DELETE FROM teams WHERE t_key = '$key'";
        $sql[] = "DELETE FROM teammates WHERE t_key = '$key'";
}

if (isset($t_name)) {
        $apology = "
We're sorry, but $t_name has been cancelled.

Any matches you performed in will not count toward any wins or anything.

Please check the forums for more details.

Thanks!


\tNessTheHero
";
        $subject = "$t_name Cancelled";
        $header = "From: BnG Wars Administration";

        $sql_2 = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
        $result_2 = @mysql_query($sql_2,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result_2)) {
                mail($row[email], $subject, $apology, $header);
        }
}

$sql_3 = "SELECT location FROM logs WHERE t_key = '$key'";
$result_3 = @mysql_query($sql_3, $connection) or die(mysql_error());
while ($row = mysql_fetch_array($result_3)) {
        @unlink($uploaddir.$row[location]) or die("Couldn't delete file.");
}

foreach ($sql as $s) {
        @mysql_query($s,$connection) or die(mysql_error());
}

header("Location: ".$admin_dir."create_tournament.php");
exit;
?>
