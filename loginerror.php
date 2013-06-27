<?php
include_once("inc/includes.php");

$header = "";
pageHeader("squad", "squad", "Login error!", $header);
?>
<div>
Login Error!
<hr />
<?
switch ($_SESSION['error']) {
	case "noname":
		$msg = "That username does not exist in our database.<br /><br />\n";
		$msg .= "Either return to the log in screen to try again or create an admin screenname.<br /><br />\n";		
		$msg .= "<a href='$createpage'>Create a username</a><br />";
	break;
	case "badpass":
		$msg = "The password you entered is incorrect.<br /><br />\n";
		$msg .= "Either return to the log in screen to try again or use the Lost Password function.<br /><br />\n";
		$msg .= "<a href='lostpassword.php'>Lost Password</a>";
	break;
	default:
		$msg = "There is no determinable error. Please return to the login area.<br /><br />\n";
		$msg .= "<a href='$createpage'>Create a username</a>";
	break;
}

echo $msg."<a href=\"$loginpage\">Return to log in area</a><br />\n";

?>
</div>
<?php
pageFooter(FALSE, TRUE);
?>