<?php
include_once("inc/includes.php");

$header = "";
pageHeader("members", "squad", "Members", $header);
?>
<h1>The following is a list of all squad members.</h1>

<?php

$sql = "SELECT * FROM squadmembers ORDER BY username";
$result = @mysql_query($sql) or die(mysql_error());
if ($result) {
        while($row = mysql_fetch_array($result)) {
                $user = new User($row['id']);
				
                if (isset($_SESSION[username])) {
                        $profile_link = "[<a href=\"".$site_dir."profile.php?user=".$user->getName()."\">P</a>]";
                } else {
                        $profile_link = "";
                }
                if ($user->getRank() == "admin") {                        
                        $adminblock .= "<div class='admin'>".$user->getName()."</div>&nbsp;$profile_link<br />
";
                }
                if ($user->getRank() == "judge") {
                        $judgeblock .= "<div class='judge'>".$user->getName()."</div>&nbsp;$profile_link<br />
";
                }
                if ($user->getRank() == "squad") {
                        $userblock .= $user->getName()."&nbsp;$profile_link<br />
";
                }
}
}
echo $adminblock;
echo $judgeblock;
echo $userblock;

?>
<br>
[<div class="admin">Site Administrator</div>][<div class="judge">Tournament Judge</div>*] [Squadmember]
<br>
<center>
* (Only during Active Tournaments)
</center>
<?
pageFooter(FALSE, TRUE);
?>