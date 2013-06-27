<?php
include_once("inc/includes.php");

if (($_POST[username] == "") || ($_POST[password] == "")) {
        header("Location: ".SITE_DIR."accountlogin.php");
        exit;
}

$uname = $_POST[username];
$pass = md5($_POST[password]);

$dummy = new User();

$search = $dummy->search($uname);

if ($search == 0) {
	$_SESSION['error'] = "noname";
	header("Location: ".SITE_DIR."loginerror.php");
	exit;
} else {

	if ($dummy->getPassword() != $pass) {
		$_SESSION['error'] = "badpass";
		header("Location: ".SITE_DIR."loginerror.php");
		exit;
	} else {
		$_SESSION['rank'] = strtoupper($dummy->getRank());
		$_SESSION['username'] = $dummy->getName();
		$_SESSION['id'] = $dummy->getID();

		$cookie_name = "SQUADBNG_LOGIN";
		$cookie_value = $dummy->getID();
		
		setcookie($cookie_name, $cookie_value, mktime()+60*60*24*365, "/sites/squadbng/", "www.nessthehero.com", FALSE);

		header("Location: ".SITE_DIR."profile.php");
		exit;
	}
		
}
?>