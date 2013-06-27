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
if (rank($_SESSION[username]) == "squad") {
        header("Location: ".$site_dir."accountlogin.php");
        exit;
}

$page_topimg = "bwadmin";
$level = "admin";
$page_title = "Bracket Finalization";

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$sql = "SELECT status, t_key FROM tournaments";
$result = @mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        switch ($row[status]) {
                case "pending":
                        header("Location: ".$site_dir."start_tournament.php");
                        exit;
                break;
                case "teams":
                        header("Location: ".$site_dir."teams.php");
                        exit;
                break;
                case "active":
                        header("Location: ".$site_dir."tournament.php");
                        exit;
                break;
        }
}

if (isset($_POST[finalized])) {

        $size = sizeof($_POST[combatant]);
        while ($i <= $size) {
                $p1 = $_POST[combatant][$i];
                $p2 = $_POST[combatant][$i + 1];
                if ($p1 === $p2) {
                        header("Location: ".$site_dir."start.php?error=1");
                        exit;
                }
                $i = $i + 2;
        }

        $m = 1;
        $b = 1;
        $loop = 1;
        foreach ($_POST[combatant] as $fighter) {
                //id, t_key, match_id, contender, score, box_id, round, done
                $sql = "INSERT INTO matches VALUES ('', '$key', '$m', '$fighter', 0, $b, 1, 'NO')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                $b++;
                if (even($loop)) {
                        $m++;
                        $b = 1;
                }
                $loop++;
        }

}


$key = $_POST[t_key];
$fighters = array();

if (get_tourn_var($key, "teams") == "yes") {
        $sql = "SELECT * FROM teams WHERE t_key = '$key'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                array_push($fighters, $row[id]);
        }
} else {
        $sql = "SELECT * FROM squadmembers WHERE intourn = 'yes'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                array_push($fighters, $row[id]);
        }
}

$i = 0;
shuffle($fighters);
shuffle($fighters);
shuffle($fighters);

if (odd(sizeof($fighters))) {
        array_push($fighters, "UNEVEN");
}

$header = "";
include($root."inc/top.html");

$sql = "DELETE FROM matches WHERE t_key = '$key'";
@mysql_query($sql,$connection) or die(mysql_error());
$m = 1;
$b = 1;
$loop = 1;
foreach ($fighters as $f) {
        //id, t_key, match_id, contender, score, box_id, round, done
        $sql = "INSERT INTO matches VALUES ('', '$key', '$m', '$f', 0, $b, 1, 'NO')";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $b++;
        if (even($loop)) {
                $m++;
                $b = 1;
        }
        $loop++;
}
?>
                                        <center><font>Bracket Editing
                                        <br><br>
                                        Is this good?</font></center>

                                        <br>
                                        <div align="center">
                                                <table border="1" cellspacing="0" cellpadding="0">
                                                <?
                                                if (isset($_GET[edit_b])) {

                                                        $loop = 1;
                                                        echo "<tr>";
                                                        $sql = "SELECT * FROM matches WHERE t_key = '$key'";
                                                        $result = @mysql_query($sql, $connection) or die(mysql_error());
                                                        while ($row = mysql_fetch_array($result)) {
                                                                if ($row[match_id] == $_GET[edit_b]) {
                                                                        $sql_2 = "SELECT * FROM matches WHERE match_id >= '$_GET[edit_b]'";
                                                                        $result_2 = @mysql_query($sql_2, $connection) or die(mysql_error());
                                                                        while ($row_2 = mysql_fetch_array($result_2)) {
                                                                                if ($row_2[contender] == $row[contender]) {
                                                                                        $selections .= "<option selected>".$row_2[contender]."</option>";
                                                                                } else {
                                                                                        $selections .= "<option>".$row_2[contender]."</option>";
                                                                                }
                                                                        }
                                                                        if (odd($loop)) {
                                                                               echo "<td><center>vs</center></td>";
                                                                        } else {
                                                                                echo "<td><form name=\"match_edit\" method=\"get\" action=\"start.php\"><input type=\"hidden\" name=\"edit_b\" value=\"".$row[match_id]."\"><input type=\"submit\" value=\"<---Change this match\"></form>";
                                                                                echo "</tr><tr>";
                                                                        }
                                                                } elseif ($row[match_id] > $_GET[edit_b]) {

                                                                } else {
                                                                        $selections = team_name($row[contender]);
                                                                        echo "
                                                                        <td>
                                                                                <center>$selections</center>
                                                                        </td>
                                                                        ";
                                                                        if (odd($loop)) {
                                                                                echo "<td><center>vs</center></td>";
                                                                        } else {
                                                                                echo "<td><form name=\"match_edit\" method=\"post\" action=\"start.php\"><input type=\"hidden\" name=\"edit_b\" value=\"".$row[match_id]."\"><input type=\"submit\" value=\"<---Change this match\"></form>";
                                                                                echo "</tr><tr>";
                                                                        }
                                                                }
                                                                $loop++;
                                                        }

                                                } else {

                                                        $loop = 1;
                                                        echo "<tr>";
                                                        $sql = "SELECT * FROM matches WHERE t_key = '$key'";
                                                        $result = @mysql_query($sql, $connection) or die(mysql_error());
                                                        while ($row = mysql_fetch_array($result)) {
                                                                $selections = team_name($row[contender]);
                                                                echo "
                                                                        <td>
                                                                                <center>$selections</center>
                                                                        </td>
                                                                ";
                                                                if (odd($loop)) {
                                                                        echo "<td><center>vs</center></td>";
                                                                } else {
                                                                        echo "<td><br><form name=\"match_edit\" method=\"post\" action=\"start.php\"><input type=\"hidden\" name=\"edit_b\" value=\"".$row[match_id]."\"><input type=\"submit\" value=\"<---Change this match\"></form>";
                                                                        echo "</tr><tr>";
                                                                }
                                                                $loop++;
                                                        }
                                                        
                                                }

                                                ?>
                                                        </tr>
                                                        <tr>
                                                                <td colspan="4">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan="4">
                                                                <form method="post" action="start.php">
                                                                <input type="hidden" name="finalized" value="TRUE">
                                                                <center>
                                                                <input type="reset" value="Return to default match-ups">&nbsp;
                                                                <input type="submit" value="Finalize Bracket and Start Tournament"></center>
                                                                </form>
                                                                </td>
                                                                
                                                        </tr>
                                                </table>
                                        </div>
                                        
<?
$w3c = FALSE;
include($root."inc/bottom.html");


                   /*
if (!teams($key)) {



} else {



}

$i = 0;
while ($i <= sizeof($fighters) - 1) {
        if ($fighters[$i] != "UNEVEN") {
                $sql = "SELECT email FROM squadmembers WHERE username = '$fighters[$i]'";
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

if (get_tourn_var($key, "teams") == "yes") {

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
        $to_all_msg = "
Hello and welcome again to Bng Wars!

As you might already know, this tournament uses Teams instead of matches between individual players.

While it may be set that teams are chosen at random, the Administrators must first check the teams to make sure that there are no overpowered or underpowered teams that would upset the flow of the tournament.
When teams are finished, you will recieve an e-mail telling you what team you are in. You will be able to check who is on your team on the BnG Wars page, and in other player profiles.

Thanks for waiting!

NessTheHero,
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

$sql = "UPDATE tournaments SET status = 'active' WHERE status = 'pending'";
@mysql_query($sql,$connection) or die(mysql_error());
header("Location: ".$admin_dir."tournament.php");
exit;

?>                   */        ?>
