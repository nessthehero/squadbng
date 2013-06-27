<?php
include_once("inc/includes.php");

$header = "";
pageHeader("squad", "squad", "Login to Squad BnG", $header);
?>
<form method="post" action="login.php">
	<h3>Type in your username and password</h3>
	<label for="username">Username</label>
	<input type="text" name="username" size="25">
	<br />
	<label for="password">Password</label>
	<input type="password" name="password" size="25">
	<br />
	<br />
	<input type="submit" value="Log-in" name="login">
	<input type="reset" value="Try again" name="reset">
</form>
<?php
pageFooter(FALSE, TRUE);
?>