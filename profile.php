<?php
include_once("inc/includes.php");

if (!$_SESSION['username']) {
	header("Location: ".SITE_DIR."accountlogin.php");
	exit;
}

if ($_POST['upload_av']) {
        if ($_POST['title'] != "") {
                $user_id = get_user_id($_SESSION['username']);
                $location = $admin_folder."avatars/".$_FILES['avatar']['name'];
                $from = $_FILES['avatar']['tmp_name'];
                if (!file_exists($uploaddir.$admin_folder."avatars/")) {
                        mkdir($uploaddir.$admin_folder."avatars/");
                }
                $to = $uploaddir.$admin_folder."avatars/".$_FILES['avatar']['name'];
                if ($_POST[def] == 1) {
                        $def = 1;
                } else {
                        $def = 0;
                }
                if (rank($_SESSION['username']) != "admin") {
                        $def = 1;
                }
                if ($def == 1) {
                        $sql = "UPDATE avatars SET def = '0' WHERE user = '$user_id'";
                        @mysql_query($sql) or die(mysql_error());
                }
                @move_uploaded_file($from,$to) or die("Could not copy file");
                $sql = "INSERT INTO avatars VALUES ('', '$user_id', '$_POST[title]', '$location', '$def')";
                $result = mysql_query($sql) or die(mysql_error());
                if (rank($_SESSION['username']) != "admin") {
                        $sql = "DELETE FROM avatars WHERE def = '0' AND user = '$user_id'";
                        mysql_query($sql) or die(mysql_error());
                }
        } else {
                $a_error = "<font color=\"red\">You must specify a title</font>";
        }
}

if ($_POST['change_def']) {

        $user_id = get_user_id($_SESSION['username']);
        $sql = "UPDATE avatars SET def = '0' WHERE user = '$user_id'";
        @mysql_query($sql) or die(mysql_error());
        
        $a_id = $_POST['av_list'];
        $sql = "UPDATE avatars SET def = '1' WHERE id = '$a_id'";
        @mysql_query($sql) or die(mysql_error());

}

if ($_POST['delete_av']) {
        $sql = "SELECT * FROM avatars WHERE id = ".$_POST[avatar];
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $location = $row[file];
        }
        $sql = "DELETE FROM avatars WHERE id = ".$_POST[avatar];
        $result = @mysql_query($sql) or die(mysql_error());
        @unlink($location);
        
        $user_id = get_user_id($_SESSION[username]);
        $sql = "SELECT id FROM avatars WHERE user = '$user_id'";
        $result = @mysql_query($sql) or die(mysql_error());;
        $first = mysql_result($result, 0);
        $sql = "UPDATE avatars SET def = '1' WHERE id = '$first'";
        @mysql_query($sql) or die(mysql_error());
}

if (!isset($_GET['user'])) {
	$user = new User($_SESSION['id']);     
	$you = TRUE; 
} else {
	$user = new User($_GET['user']);
	$you = FALSE;
}
	
$awards = $user->getAwards();

$trophies = $awards['trophy'];
$medals = $awards['award'];

/*$trophies_won = "
<div>
	<h4>Trophies</h4>
";*/
		
switch ($user->getRank()) {
	case "admin":
		if ($you) { $rankmsg = "You are an <a href=\"".ADMIN_FOLDER."main.php\">Administrator</a><br><br>\n"; } else { $rankmsg = "$uname is an Administrator<br><br>\n"; }
		break;
	case "judge":
		if ($you) { $rankmsg = "You are a <a href=\"".ADMIN_FOLDER."tournament.php\">Tournament Judge</a><br><br>\n"; } else { $rankmsg = "$uname is a Tournament Judge<br><br>\n"; }
		break;
	case "squad":
	default:
		$rankmsg = "";
		break;				
}		

if ($you) {

	$banmsg = "You are ";
	$wontourn = "You have ";
	$ptourn = "You have ";
	$tournmsg = "<br />You are ";

} else {

	$banmsg = $user->getName()." is ";
	$wontourn = $user->getName()." has ";
	$ptourn = $user->getName()." has ";
	$tournmsg = "<br />".$user->getName()." is ";		

}

if ($user->getInTourn() == "yes") {
	$key = get_key();
	$tournmsg .= "participating in the current tournament.<br />\n";
	if (get_tourn_var($key, "teams") == "yes") {
			$tournmsg .= "Team: ".team_name($team_id);
	}
} else {
	$tournmsg = "";
}

switch ($user->getBan()) {
	case 0:
		$banmsg .= "not banned from any tournaments.<br />\n";
		break;
	case 1:
		$banmsg .= "banned from 1 tournament.<br />\n";
		break;
	case "I":
		$banmsg .= "banned indefinitely from all tournaments.<br />\n";
		break;
	default:
		$banmsg .= "banned from ".$user->getBan()." tournaments.<br />\n";
		break;
}       

if ($user->getWins() == 1) {
		$wontourn .= "won ".$user->getWins()." tournament.<br />\n";
} else {
		$wontourn .= "won ".$user->getWins()." tournaments.<br />\n";
}

if ($user->getParticipation() == 1) {
		$ptourn .= "participated in ".$user->getParticipation()." tournament.<br>\n";
} else {
		$ptourn .= "participated in ".$user->getParticipation()." tournaments.<br>\n";
}        

$statistics = $banmsg.$wontourn.$ptourn.$tournmsg;

if ($you) {

	$edit = array(
		"username"    => "<a href=\"".$site_dir."editprofile.php?e=username\">[Edit]</a>",
		"email"       => "<a href=\"".$site_dir."editprofile.php?e=email\">[Edit]</a>",
	);
	
	$bottom_links = "
	[<a href=\"changepass.php\">Change Password</a>]
	[<a href=\"".$site_dir."home.php\">Home</a>]
	[<a href=\"logout.php\">Log out</a>]
	";
	
	$avatar_form = "
	<br />
	<form method='POST' action='profile.php'  enctype='multipart/form-data'>
		<input type='hidden' name='upload_av' value='yes'>
		<input type='file' name='avatar' size='12'><br />
		$a_error
		Title: <input type='text' name='title' size='15'><br />
	";
	if ($user->getRank() == "admin") {
		$avatar_form .= "Default: <input type='checkbox' name='def' value='1'><br />";
	}
	$avatar_form .= "
		<input type='submit' value='Upload Avatar'>
	</form>
	<form method='POST' action='profile.php'>
		<input type='hidden' name='delete_av' value='yes'>
		<select size='1' name='avatar'>
	";

	$sql = "SELECT * FROM avatars WHERE user = '$user_id'";
	$result = @mysql_query($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {
		if ($row[def] == 1) {
			$avatar_form .= "<option value='$row[id]' selected>$row[name]</option>\n";
		} else {
			$avatar_form .= "<option value='$row[id]'>$row[name]</option>\n";
		}
	}

	$avatar_form .= "
		</select>
		<input type='submit' value='Delete Avatar'>
	</form>
	";

	if ($user->getRank() == "admin") {
		$avatar_form .= "
		<form method='POST' action='profile.php'>
			<input type='hidden' name='change_def' value='yes'>
			<select size='1' name='av_list'>
		";

		$sql = "SELECT * FROM avatars WHERE user = '$user_id'";
		$result = @mysql_query($sql) or die(mysql_error());
		while ($row = mysql_fetch_array($result)) {
				if ($row[def] == 1) {
						$avatar_form .= "<option value='$row[id]' selected>$row[name]</option>\n";
				} else {
						$avatar_form .= "<option value='$row[id]'>$row[name]</option>\n";
				}
		}

		$avatar_form .= "
			</select><br />
			<input type='submit' value='Change Default'>
		</form>
		";
	}
	
} else {

	$edit = array(
		"username"    => "",
		"email"       => "",
	);
	
	$bottom_links = "
	[<a href=\"profile.php\">Your profile</a>]
	[<a href=\"$site_dir"."home.php\">Home</a>]
	";

}       

if ($you) { $prof_msg = "your profile,"; } else { $prof_msg = "the profile of"; }
		
$header = "
<script type='text/javascript'>
	var viewAwardX = (screen.width/2)-175;
	var viewAwardY = (screen.height/2)-150;
	var loc = 'left='+viewAwardX+',top='+viewAwardY;
	function viewAward(id){
		var site = 'award_info.php?id='+id;
		viewAwardWindow = window.open(site,'award_view','width=290,height=210,'+loc);
	}
</script>
";
pageHeader("squad", "squad", "User Profile", $header);
?><?php echo $user->getAvatar('profile'); ?>
<div class="profile">

Welcome to <?php echo $prof_msg; ?> <?php echo $user->getName(); ?>!
<br /><br />
<?php echo $rankmsg; ?>
User Statistics                                                
<br /><br />                                                
<?php echo $statistics; ?>                                                
<br />
<?php echo $trophies_won; ?>
<br />
<?php echo $awards_won; ?>
<br />

<u><b>Profile Options</b></u>
<br /><br />
Username (Login): <?php echo $user->getName(); ?> <?php echo $edit["username"]; ?><br />
E-mail: <?php echo $user->getEmail(); ?> <?php echo $edit["email"]; ?>
<br /><br />
<?php echo $bottom_links; ?>
</div>
<?php
pageFooter(FALSE, FALSE);
?>
