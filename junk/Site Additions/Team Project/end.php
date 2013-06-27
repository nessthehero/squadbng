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
if (rank($_SESSION[username]) != "admin") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "bwadmin";
$level = rank($_SESSION[username]);
$page_title = "Tournament is now officially over!";

$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT * FROM tournaments WHERE t_key = '$_GET[key]'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $game = $row[game];
        $name = $row[t_name];
        $key = $row[t_key];
        $peeps = $row[peeps];
}

$sql = "SELECT * FROM tourneystats WHERE t_key = '$_GET[key]'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $award = $row[award];
}

$sql = "SELECT tourneys FROM games WHERE game = '$game'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $t = $row[tourneys];
}
$t++;

$sql = "SELECT * FROM matches WHERE t_round = '$_GET[round]' AND t_key = '$_GET[key]'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $p1s = $row[p1score];
        $p2s = $row[p2score];
        $p1 = $row[play_1];
        $p2 = $row[play_2];
}
if ($p1s > $p2s) {
        $winner = $p1;
} else {
        $winner = $p2;
}

$message = "
Congratulations everyone! This has been a wonderful tournament!

The battles were fierce, but it turns out the winner of this tournament is $winner!
Good job $winner! Your new trophy is visible in your profile!
I would personally like to thank all the participants in the tourney. You all fought
your best, and tried your hardest! Good work!

The next tournament could be underway soon! Please vote for the game you want to play in
on the forums! Thanks for playing!

\tNessTheHero,
\t\tSquad BnG Tournament Coordinator

Squad BnG forums: ".$site_dir."forum/

See you next game!

--
This message is scripted and is delivered to all squadmembers.
Please do not ask why you recieved it, or to unsubscribe.
--
";
$subject = "Congratulations! The games are over!";
$header = "From: BnG Wars Administration";
$sql = "SELECT email FROM squadmembers";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $email = $row[email];
        mail($email, $subject, $message, $header);
}

$win_date = date("F jS, Y");

$sql = array();
$sql[1] = "UPDATE tournaments SET status = 'complete'";
$sql[2] = "UPDATE games SET tourneys = '$t' WHERE game = '$game'";
$sql[3] = "UPDATE squadmembers SET twon = twon+1 WHERE intourn = 'yes'";
$sql[4] = "UPDATE squadmembers SET tpart = tpart+1 WHERE intourn = 'yes'";
$sql[5] = "UPDATE squadmembers SET intourn = 'no'";
$sql[6] = "UPDATE squadmembers SET ban = ban-1 WHERE ban != 0 AND ban != 'I'";
$sql[7] = "INSERT INTO awards VALUES ('', '$award', '$winner', 1, 'Won by $winner on $win_date.')";
$sql[8] = "UPDATE squadmembers SET rank = 'squad' WHERE rank == 'judge'";

for ($i = 1; $i <= 8; $i++) {
        $result = @mysql_query($sql[$i],$connection) or die(mysql_error());
}
$header = "";
include($site_dir."top.html");
?>
                <p align="center">Tournament has ended!</p>
                  <p align="center">Game winner: <? echo $winner; ?><br>
                  <br>
                  <a href="<? echo $admin_dir.'main.php'; ?>">Back to main</a><br>
                  <a href="<? echo $admin_dir.'create_tournament.php'; ?>">Create another tournament</a>
<? include($site_dir."bottom.html"); ?>
