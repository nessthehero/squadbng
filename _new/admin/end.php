<?
session_start();

$root = $_SERVER["DOCUMENT_ROOT"]."/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");

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

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$key          = get_key();
$award        = get_tourn_var($key, "award");
$name         = get_tourn_var($key, "name");
$game         = get_tourn_var($key, "game");
$peeps        = peeps();

$sql = "SELECT tourneys FROM games WHERE game = '$game'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $t = $row[tourneys];
}
$t++;

$sql = "SELECT * FROM matches WHERE round = '$_GET[round]' AND t_key = '$_GET[key]'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[box_id] == 1) {
                $p1 = $row[contender];
                $p1s = $row[score];
        } else {
                $p2 = $row[contender];
                $p2s = $row[score];
        }
}
if ($p1s > $p2s) {
        $winner = $p1;
} else {
        $winner = $p2;
}

$message = "
Congratulations everyone! This has been a wonderful tournament!

The battles were fierce, but it turns out the winner of this tournament is ".team_name($winner)."!
Good job ".team_name($winner)."! Your new trophy is visible in your profile!
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
$sql[] = "UPDATE tournaments SET status = 'finished'";
$sql[] = "UPDATE games SET tourneys = '$t' WHERE game = '$game'";
if (get_tourn_var($key, "teams") == "yes") {

        $sql2 = "SELECT * FROM teammates WHERE team_id = '$winner' AND t_key = '$key'";
        $result2 = mysql_query($sql2, $connection) or die(mysql_error());
        while ($row2 = mysql_fetch_array($result2)) {
                $sql[] = "UPDATE squadmembers SET twon = twon+1 WHERE id = '".$row2[user_id]."'";
        }

        
} else {

        $sql[] = "UPDATE squadmembers SET twon = twon+1 WHERE id = '$winner'";
        
}

$sql[] = "UPDATE squadmembers SET tpart = tpart+1 WHERE intourn = 'yes'";
$sql[] = "UPDATE squadmembers SET intourn = 'no'";
$sql[] = "UPDATE squadmembers SET ban = ban-1 WHERE ban != 0 AND ban != 'I'";

if (get_tourn_var($key, "teams") == "no") {

        if (is_numeric(get_tourn_var($key, "award"))) {
                $sql[] = "INSERT INTO awards VALUES ('', '$award', '$winner', 1, 'Won by $winner on $win_date.')";
        }
        $sql[] = "UPDATE squadmembers SET rank = 'squad' WHERE rank != 'admin'";
        foreach($sql as $s) {
                $result = @mysql_query($s,$connection) or die(mysql_error());
        }

} else {

        if (is_numeric(get_tourn_var($key, "award"))) {
                $sql_2 = "SELECT * FROM teammates WHERE team_id = '$winner' AND t_key = '$key'";
                $result = @mysql_query($sql_2,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        array_push($sql, "INSERT INTO awards VALUES ('', '$award', '".$row[user_id]."', 1, 'Won by ".team_name($winner)." on $win_date.')");
                }
        }
        $sql[] = "UPDATE squadmembers SET rank = 'squad' WHERE rank != 'admin'";
        foreach($sql as $s) {
                $result = @mysql_query($s,$connection) or die(mysql_error());
        }

}




$header = "";
include($root."inc/top.html");
?>
                <p align="center">Tournament has ended!</p>
                  <p align="center">Game winner: <? echo team_name($winner); ?><br>
                  <br>
                  <a href="<? echo $admin_dir.'main.php'; ?>">Back to main</a><br>
                  <a href="<? echo $admin_dir.'create_tournament.php'; ?>">Create another tournament</a>
<?
$w3c = FALSE;
include($root."inc/bottom.html");
?>
