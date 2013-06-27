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
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$fighters = array();

$sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        array_push($fighters, $row[id]);
}
$i = 0;
shuffle($fighters);
shuffle($fighters);
shuffle($fighters);
$key = $_POST[t_key];


if (!teams($key)) {

        $size = sizeof($fighters);
        while ($i <= $size) {
                if (!$fighters[$i + 1]) {
                        $fighters[$i + 1] = "UNEVEN";
                }
                $p1 = $fighters[$i];
                $p2 = $fighters[$i + 1];
                $sql = "INSERT INTO matches VALUES ('', '$key', '$p1', '$p2', 0, 0, NULL, 1, 'NO')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                $i = $i + 2;
        }

} else {

        $size = sizeof($fighters) - 1;
        $sql = "SELECT * FROM tournaments WHERE t_key = '$key'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $random = $row[random];
                $ppt = $row[ppt];
        }
        for ($team_maker = 1; $team_maker <= ($size / $ppt); $team_maker++) {
                $sql = "INSERT INTO teams VALUES ('', 'Team $team_maker', '$key')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
        }
        if ($random == "yes") {
                $j = 1;
                for ($i = 1;$i <= $size; $i++) {
                        if ($i / $ppt = intval($i / $ppt)) {
                                $j++;
                        }
                        $sql = "UPDATE squadmembers SET team_id = '$j' WHERE id = '$fighters[$i]'";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                }
        }

}

$i = 0;
while ($i <= sizeof($fighters) - 1) {
        if ($fighters[$i] != "UNEVEN") {
                $sql = "SELECT email FROM squadmembers WHERE id = '$fighters[$i]'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                $row = mysql_fetch_array($result);
                array_push($emails, $row[email]);
        }
        $i++;
}

$TAsubject = "The tournament has begun!";
$to_all_msg = "
The tournament is underway! Matches will begin ASAP. Players will
receive additional e-mails on their first opponent.

Judges do not recieve e-mails declaring who they are, but please
check your profile to see if you are a judge, or you can ask Ness.

Please check the BnG Wars page for more info on the tournament.

\t\tNessTheHero,
\tSquad BnG Tournament Coordinator and Administrator
";
$header = "From: Squad BnG";

$sql = "SELECT email FROM squadmembers";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        mail($row[email], $TAsubject, $to_all_msg, $header);
}

if (!teams($key)) {

$i = 0;
while ($i <= sizeof($fighters)) {
$player1 = $fighters[$i];
$player2 = $fighters[$i+1];
$email1 = $emails[$i];
if ($player2 != "UNEVEN") {
$email2 = $emails[$i+1];
}
$msgp1 = "
Greetings $player1!

You have chosen to participate in the current tournament!
Your opponent for the first round is $player2. You are required
to meet with them and schedule a match. If the tournament requires it,
please also have a judge and a timer available.

Thank you for participating, and good luck to you!

\t\tNessTheHero,
\tSquad BnG Tournament Coordinator and Administrator
";
if ($player2 != "UNEVEN") {
$msgp2 = "
Greetings $player2!

You have chosen to participate in the current tournament!
Your opponent for the first round is $player1. You are required
to meet with them and schedule a match. If the tournament requires it,
please also have a judge and a timer available.

Thank you for participating, and good luck to you!

\t\tNessTheHero,
\tSquad BnG Tournament Coordinator and Administrator
";
} else {
$msgp1 = "
Greetings $player1!\n\n

You have chosen to participate in the current tournament!
Unfortunately, as things turn out, there is an uneven number of players
for this first round. By random selection, you will not fight until round two.
We apologize for the inconvienence.

Thank you for participating, and good luck to you!

\t\tNessTheHero,
\tSquad BnG Tournament Coordinator and Administrator
";
}
$subject = "Welcome to BnG Wars!";
$headers = "From: BnG Wars Administration";
mail($email1, $subject, $msgp1, $headers);
if ($player2 != "UNEVEN") {
mail($email2, $subject, $msgp2, $headers);
}
$i++;
$i++;
}

} else {

$TAsubject = "Teams being constructed";
$to_all_msg = "Hello and welcome again to Bng Wars!

As you might already know, this tournament uses Teams instead of matches between individual players.

While it may be set that teams are chosen at random, the Administrators must first check the teams to make sure that there are no overpowered or underpowered teams that would upset the flow of the tournament.
When teams are finished, you will recieve an e-mail telling you what team you are in. You will be able to check who is on your team on the BnG Wars page, and in other player profiles.

Thanks for waiting!

\t\tNessTheHero,
\tSquad BnG Tournament Coordinator and Administrator
";
$header = "From: Squad BnG";

$sql = "SELECT email FROM squadmembers";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        mail($row[email], $TAsubject, $to_all_msg, $header);
}

}


$sql = "UPDATE tourneystats SET signups = 'OFF' WHERE signups = 'ON'";
@mysql_query($sql,$connection) or die(mysql_error());

if (teams($key)) {
        header("Location: ".$admin_dir."teams.php");
        exit;
} else {
        $sql = "UPDATE tournaments SET status = 'active' WHERE status = 'pending'";
        @mysql_query($sql,$connection) or die(mysql_error());
        header("Location: ".$admin_dir."tournament.php");
        exit;
}
?>
