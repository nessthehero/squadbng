<?

session_start();



$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");



$page_topimg = "admin";

$level = "squad";

$page_title = "Administrator created!!";



$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());

$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());



if (($_POST[username] == "") || ($_POST[password] == "") || ($_POST[emailaddy] == "")) {

        header("Location: ".$admin_dir."createadmin.php");

        exit;

}



$uname = $_POST[username];

$pass = $_POST[password];

$pass2 = $_POST[passver];

$email = $_POST[emailaddy];



if ($pass2 != $pass) {

        $_SESSION[valid2] = "no";

        header("Location: ".$admin_dir."createadmin.php");

        exit;

}



if (md5($_POST[adminpass]) != $adminpassword) {

        $_SESSION[valid] = "no";

        header("Location: ".$admin_dir."createadmin.php");

        exit;

} else {

        $_SESSION[valid] = "yup";

}



$table = "squadmembers";



$sql = "SELECT * FROM $table WHERE username = '$uname'";

$result = @mysql_query($sql,$connection) or die(mysql_error());

$check = mysql_num_rows($result);



if ($check > 0) {

        $msg = "$uname already exists as an administrator.<br><br>\n";

        $msg .= "Please return to the create admin screen and select another name.<br><br>\n";

        $msg .= "<a href=\"createadmin.php\">Create a different admin account</a><br>\n";

        $msg .= "<a href=\"".$site_dir."accountlogin.php\">Return to login area</a>";

} else {

$md5pass = md5($pass);

//                               id,    username,  email,    password, bracketname, volunteer, twon, tpart, ban, intourn, rank

$sql = "INSERT INTO $table VALUES ('', '$uname', '$email', '$md5pass', '$uname', 'both', 0, 0, 0, 'no', 'admin')";

$result = @mysql_query($sql,$connection) or die(mysql_error());



if ($result) {

        $msg = "Administrator $uname created successfully!<br><br>";

        $msg .= "Your password has been emailed to you for safe keeping.<br><br>";

        $msg .= "<a href=\"".$site_dir."accountlogin.php\">Click to return to login</a>";

        $subject = "Your Password";

        $sender = "From: BnG Wars Administration";

        $mail = "Congratulations! \n\n";

        $mail .= "You have created an administrator profile at BnG Squad.\n\n";

        $mail .= "Username:\t$uname\n";

        $mail .= "Password:\t$pass\n\n";

        $mail .= "Please keep this password in a safe area, as it is encrypted in our databases and cannot be retrieved.

        However, you can always use the Lost Password function of the website to obtain a new password. Thank you for

        signing up with us!\n\n\n";

        $mail .= "\t- The BnG Wars Administration";

        mail($email, $subject, $mail, $sender);

              }

}

?>

<html>

<head>

<title>

Squad BnG - <? echo $page_title; ?>

</title>

</head>

<body background="<? echo $img_BG; ?>" link="#FFFFFF" vlink="#E2C022" alink="#4A92CD" text="#E0B95B">



<center>

<font color="#E0B95B" size="1" face="Verdana">



<div align="center"><center>



<table border="0" width="548" bgcolor="#000000" height="98">

    <tr>

        <td valign="top" width="103" height="90"><table

        border="0" cellpadding="0" cellspacing="0" width="100%"

        height="1">

        <td height="72"><img border="0" src="<? echo $img_logo; ?>">

            <tr>

                <td width="100%" height="3"><img border="0" src="<? echo $img_menuTOP; ?>"></td>

                                </tr>

                                <tr>

                                        <td width="100%" background="<? echo $img_menuBG; ?>" height="1">

                                                <p align="center">

                                                <? echo buttons($level); ?>

                                                </p>

                                        </td>

                                </tr>

                                <tr>

                                        <td width="100%" height="1"><img border="0" src="<? echo $img_menuBOTTOM; ?>"></td>

                                </tr>

</table>

        </td>

        <td width="681" height="94"><div align="center"><center><table border="0" cellpadding="0" cellspacing="0" width="100%">

            <tr>

                <td width="100%"><img border="0" src="<? echo $img_TOP[$page_topimg]; ?>"></td>

            </tr>

            <tr>

                <td width="100%" background="<? echo $img_tableBG; ?>">

        <div align="center">

          <center>

          <table border="0" width="70%">

            <tr>

              <td width="100%">

              <center>

              <?

              echo "$msg";

              ?>

              </center>

              </td>

            </tr>

          </table>

          </center>

        </div>

</td>

            </tr>

            <tr>

                <td width="100%"><img src="<? echo $img_tableBOTTOM; ?>"></td>

            </tr>

        </table>

          </div></td>

    </tr>

</table>

  </div>



<font color="#E0B95B" size="1" face="Verdana">





<hr width="33%">

<div align="center"><center>



<table border="0">

   <tr>

        <td width="600" border="0">

        <p align="center">

        <font face="Verdana" size="1" color="#E0B95B">

        BnG Squad was created by <a href="mailto:nessthehero@boundforearth.com">NessTheHero</a>, <a href="mailto:GB330033@houston.rr.com">GB330033</a>, and contributed

        help from others. Everything in this site is fan-made. &quot;BnG&quot;, <a href="http://www.bobandgeorge.com/"> &quot;Bob and George&quot;</a>, and all things

        related to the comic of that name are copyright to Dave Anez. <a href="http://www.trenchwars.org/">Trench Wars</a> is copyrighted by Priitk. <a href="http://www.subspacehq.com/">Subspace</a> is owned by the

        fans and gamers who operate it, and was created by Virgin Interactive Entertainment. <br>

        This is a non profit site.</font></p>

        </td>

    </tr>

</table>

</center></div>

</body>

</html>

