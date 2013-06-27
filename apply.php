<?
include_once("inc/includes.php");

if ($_POST[a]) {
        $appl = array();
        $appl['username'] =          $_POST['username'];
        $appl['pass'] =              stripslashes(md5($_POST['password']));
        $appl['pass2'] =             stripslashes(md5($_POST['pass2']));
        $appl['email'] =             stripslashes($_POST['email']);
        $appl['inbng'] =             stripslashes($_POST['inbng']);
        $appl['timeinbng'] =         stripslashes($_POST['timeinbng']);
        $appl['bngusername'] =       stripslashes($_POST['bngusername']);
        $appl['learn_about_squad'] = stripslashes($_POST['learn_about_squad']);
        $appl['gender'] =            stripslashes($_POST['gender']);
        $appl['how_they_know_us'] =  stripslashes($_POST['how_they_know_us']);
        $appl['know_ness'] =         stripslashes($_POST['know_ness']);
        $appl['know_gb'] =           stripslashes($_POST['know_gb']);
        $inq = array();
        $inq[1] = "username";
        $inq[2] = "email";
        $inq[4] = "inbng";
        $inq[5] = "timeinbng";
        $inq[6] = "bngusername";
        $inq[7] = "learn_about_squad";
        $inq[8] = "gender";

        if (strlen($_POST['told_to_join_by']) < 1) {
                $appl['told_to_join_by'] = "N/A";
        } else {
                $appl['told_to_join_by'] = $_POST['told_to_join_by'];
        }

        if ($appl[inbng] == "FALSE") {
                $appl['timeinbng'] =   "Not in BnG";
                $appl['bngusername'] = "Not in BnG";
        }

        if ((!$appl['know_ness']) && (!$appl['know_gb'])) {
                $appl['how_they_know_us'] = "I don't";
        }


        $sql = "SELECT * FROM squadmembers WHERE username = '$appl[username]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 0) {
                $error_msg .= "<br>That username is already taken. Please choose another.<br>";
        }
        $sql = "SELECT * FROM applications WHERE username = '$appl[username]'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 0) {
                $error_msg .= "<br>That username is already taken. Please choose another.<br>";
        }
        if ($null_error) {
                $error_msg .= "<br>There are one or more fields missing. Please check over the application and resubmit it.<br>";
        } else {
                if ($appl['pass'] != $appl['pass2']) {
                        $error_msg .= "<br>Your password does not match in both boxes. Please retype it.<br>";
                } else {
                        $sql = "INSERT INTO applications VALUES ('', '$appl[username]', '$appl[pass]', '$appl[email]', '$appl[inbng]', '$appl[timeinbng]', '$appl[bngusername]', '$appl[learn_about_squad]', '$appl[told_to_join_by]', '$appl[know_ness]', '$appl[know_gb]', '$appl[how_they_know_us]', '$appl[gender]')";
                        $result = @mysql_query($sql,$connection) or die(mysql_error());
                        $error_msg = "<br>Your application has been recieved!<br>
                        <br>If there was an error, please let Ness know beforehand so he can delete the faulty application.<br>
                        <br>Please note that certain answers may prohibit you from being in the squad.<br>
                        <br>You will be notified if you are accepted or not.<br>";
                }
        }
}

$header = "";
pageHeader("squad", "squad", "Apply to join the squad!", $header);
?>
<div id="form">
	Apply to join Squad BnG!
	<div id="error">
		<? echo $error_msg; ?>
	</div>
</div>

<hr width="25%">

<form method="POST" name="application" action="apply.php">
	<input type="hidden" name="a" value="TRUE">
	<div id="form">
		Desired username:
		<input type="text" name="username" size="20" maxlength="50" value="<? echo $_POST['username']; ?>">
	</div><br />
	<div id="form">
		Desired password:
		<input type="password" name="password" size="20" maxlength="50">
	</div><br />
	<div id="form">
		Repeat Password:
		<input type="password" name="pass2" size="20" maxlength="50">
	</div><br />
	<div id="form">
		E-mail Address:
		<input type="text" name="email" size="20" maxlength="100" value="<? echo $_POST['email']; ?>">
	</div>
	<br /><br />
	You will be asked a few questions on why you want to join and other things. All these questions are required.
	<br /><br /><br />
	<div id="form">
		Are you part of the webcommunity Bob and George?
		Yes <input type="radio" value="TRUE" checked name="inbng">
		No <input type="radio" name="inbng" value="FALSE">
	</div><br />
	<div id="form">
		If so, how long have you been in BnG?
		<input type="text" name="timeinbng" size="20" value="<? echo $_POST['timeinbng']; ?>">
	</div><br />
	<div id="form">
		What is your username at BnG, if you have one.
		<input type="text" name="bngusername" size="20" value="<? echo $_POST['bngusername']; ?>">
	</div><br />
	<div id="form">
		How did you learn about Squad BnG?
		<select size="1" name="learn_about_squad">
			<option selected value="referred">Referral by friend</option>
			<option value="thread">Came across a thread</option>
			<option value="game">Learned about it on a game</option>
			<option value="websurf">Mindless websurfing</option>
		</select>
	</div><br />
	<div id="form">
		If referred, who told you about it? (Or, what game?)
		<input type="text" name="told_to_join_by" size="20" value="<? echo $_POST['told_to_join_by']; ?>">
	</div><br />
	<div id="form">
		Do you know NessTheHero?
		
		Yes <input type="radio" name="know_ness" value="TRUE" checked>
		No <input type="radio" name="know_ness" value="FALSE">
	</div><br />
	<div id="form">
		Do you know GB330033?
		
		Yes <input type="radio" name="know_gb" value="TRUE" checked>
		No <input type="radio" name="know_gb" value="FALSE">
	</div><br />
	<div id="form">
		If you know either one, how do you know them?
		<textarea rows="2" name="how_they_know_us" cols="24"></textarea>
	</div><br />
	<div id="form">
		Male or Female?
		
		Male: <input type="radio" name="gender" value="Male" checked>
		Female: <input type="radio" name="gender" value="Female">
	</div><br />
	<div id="form">
		<input type="submit" value="Apply">
		<input type="reset" value="Reset">
	</div>
</form>
<?
$w3c = FALSE;
pageFooter(FALSE, TRUE);
?>