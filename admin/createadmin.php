<?

session_start();



$root = $_SERVER["DOCUMENT_ROOT"]."/squadbng/";
include($root."inc/vars.php");
include($root."inc/functions.php");
include($root."inc/images.php");



$page_topimg = "admin";

$level = "squad";

$page_title = "Create an Admin username -- YOU MUST HAVE THE ADMIN PASSWORD TO CREATE A NAME";



$connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());

$db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());



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

        <table border="0" width="53%">

                <tr>

                        <td width="100%">

                                <hr>

                                <form method="POST" action="createadmin2.php">

                                        <table border="0" width="100%" height="196" cellspacing="3">

                                                <tr>

                                                        <td width="29%" height="23"><font size="1">Desired Username:</font></td>

                                                        <td width="71%" height="23"><font size="1">

                                                        <? echo "<input type=\"text\" name=\"username\" size=\"20\" value=\"$_POST[username]\">" ?>

                                                        </font></td>

                                                </tr>

                                                <tr>

                                                        <td width="29%" height="23"><font size="1">Password:</font></td>

                                                        <td width="71%" height="23"><font size="1"><input type="password" name="password" size="20"></font>

                                                        </td>

                                                </tr>

                                                <tr>

                                                        <td width="29%" height="23"><font size="1">Password again:</font></td>

                                                        <td width="71%" height="23"><font size="1"><input type="password" name="passver" size="20"></font>

                                                        <?

                                                        if ($_SESSION[valid2] == "no") {

                                                        echo "<font color=\"#FF0000\" size=\"1\"><b> -- Passwords not equal</b></font>";

                                                        } else { echo ""; }

                                                        ?>

                                                        </td>

                                                </tr>

                                                <tr>

                                                        <td width="29%" height="19"><font size="1">E-mail address:</font></td>

                                                        <td width="71%" height="19"><font size="1">

                                                        <? echo "<input type=\"text\" name=\"emailaddy\" value=\"$_POST[emailaddy]\" size=\"20\">" ?>

                                                        </font></td>

                                                </tr>

                                                <tr>

                                                        <td width="29%" height="78"><font size="1">Administrator Password**</font></td>

                                                        <td width="71%" height="78"><input type="password" name="adminpass" size="20">

                                                        <?

                                                        if ($_SESSION[valid] == "no") {

                                                        echo "<font color=\"#FF0000\" size=\"1\"><b> -- Invalid password</b></font>";

                                                        } else { echo ""; }

                                                        ?>

                                                        </td>

                                                </tr>

                                        </table>

                                        <p align="center"><font size="1"><input type="submit" value="Create Administrator Username" name="submit"></font></p>

                                </form>

                                <p><font size="1">

                                All fields required<br>

                                **Required to prevent unauthorized administrator personnel.

                                </font></td>

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

