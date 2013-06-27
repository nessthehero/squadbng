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

$page_topimg = "admin";
$level = rank($_SESSION[username]);
$page_title = "Squad BnG Site Administration - Welcome!";

$username = $_SESSION[username];

$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

$members        = 0;
$admins         = 0;
$judges         = 0;
$buttons        = 0;
$sign_ups       = 0;
$admin_b        = 0;
$judge_b        = 0;
$squad_b        = 0;
$games          = 0;
$tournament_msg = "There are no active tournaments.";
$news           = 0;
$comments       = 0;
$avatars        = 0;
$applications   = 0;

$sql = "SELECT * FROM squadmembers";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $members++;
        if (rank($row[username]) == "admin") {
                $admins++;
        }
        if (rank($row[username]) == "judge") {
                $judges++;
        }
        if ($row[intourn] == "yes") {
                $sign_ups++;
        }
}

$sql = "SELECT * FROM buttons";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $buttons++;
        if ($row[type] == "admin") {
                $admin_b++;
        }
        if ($row[type] == "judge") {
                $judge_b++;
        }
        if ($row[type] == "squad") {
                $squad_b++;
        }
}

$sql = "SELECT * FROM games";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $games++;
}

$sql = "SELECT * FROM tournaments";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        if ($row[status] == "active") {
                $tournament_msg = "There is an active tournament played on ".ucwords($row[game]).".";
        }
        if ($row[status] == "pending") {
                $tournament_msg = "There is a pending tournament (Game: ".ucwords($row[game]).").";
        }
}

$sql = "SELECT * FROM news";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $news++;
        $latest_by_msg = "Last post by: ".get_user_from_id($row[poster]);
}

$sql = "SELECT * FROM comments WHERE type = 'news'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $comments++;
}

$sql = "SELECT * FROM avatars WHERE user = '$username'";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $avatars++;
}

$sql = "SELECT * FROM applications";
$result = mysql_query($sql,$connection) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
        $applications++;
}

if ($avatars == 1) {
        $avatars_msg = "You have $avatars avatar";
} else {
        $avatars_msg = "You have $avatars avatars";
}

if ($members == 1) {
$members_msg = "There is $members member in Squad BnG";
} else {
$members_msg = "There are $members members in Squad BnG";
}
if ($admins == 1) {
$admins_msg = "$admins of them is an admin";
} else {
$admins_msg = "$admins of them are admins";
}
if ($judges == 1) {
$judge_msg = "$judges of them is an judge";
} else {
$judge_msg = "$judges of them are judges";
}
$sign_ups_msg = "Participants: $sign_ups";
$buttons_msg = "Number of site buttons: $buttons (Admin: $admin_b/Judge: $judge_b/Squad: $squad_b)";
$games_msg = "Number of documented games we play: $games";
$news_posts_msg = "Archived number of news posts: $news";
$comments_msg = "Number of comments made on news items: $comments";
$applications_msg = "Number of pending applications: $applications";

$header = "";
include($root."inc/top.html");
?>
                <div align="center">
                <font>
                Welcome <? echo $username."!"; ?>
                <br><br>
                </font>
                <?
                  echo "

                  <font>
                  <u>Site Statistics</u>
                  <br>
                  $members_msg                 <br>
                  $admins_msg                  <br>
                  $judge_msg                   <br>
                  <br>
                  $applications_msg            <br>
                  <br>
                  $tournament_msg              <br>
                  $sign_ups_msg                <br>
                  <br>
                  $buttons_msg                 <br>
                  <br>
                  $games_msg                   <br>
                  <br>
                  $news_posts_msg              <br>
                  $latest_by_msg               <br>
                  $comments_msg
                  </font>
                  </div>
                  ";
                ?>
<?
$w3c = TRUE;
include($root."inc/bottom.html");
?>
