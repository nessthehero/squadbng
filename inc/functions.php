<?
$db = dbConnect();
define("CURRENT_USER", getLoggedInUser());

function dbConnect()
{
	$db = mysql_connect(DB_HOST,DB_USER,DB_PASS);
	if (!$db) {
		echo 'Error: Could not connect to the database.  Please try again later.';
		exit;
	} else {
		$dbb = mysql_select_db("moffitt_squadbng");
	}
	return $dbb;
}

if (!function_exists("htmlspecialchars_decode")) {
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT) {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}

function format($var, $mysql_escape=FALSE) {
	if (is_array($var)) {
		$out = array();
		foreach ($var as $key => $v) {
			$out[$key] = format($v);
		}
	} else {
		$out = htmlspecialchars_decode($var);
		$out = htmlspecialchars(stripslashes(trim($out)), ENT_QUOTES);
		if ($mysql_escape) {
			$out = mysql_real_escape_string($out);
		}
	}
   
	return $out;
}

function getLoggedInUser() {

	$CURRENT_USER = 0;
	if (isset($_REQUEST['SQUADBNG_LOGIN'])) {
		$CURRENT_USER = $_REQUEST['SQUADBNG_LOGIN'];
	} 
	
	return $CURRENT_USER;

}

function pageHeader($img, $level, $title, $header) {

	$page_topimg = $img;
	$level = $level;
	$page_title = $title;
	$header = $header;
	
	echo "
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta charset='utf-8'>
	<title>Squad BnG - $page_title</title>
	<link rel='Favorites' href='".SITE_DIR."favicon.ico' />
	<link rel='stylesheet' href='".SITE_DIR."inc/style.css' type='text/css' />
	$header
	<script src='".SITE_DIR."js/prototype.js' type='text/javascript'></script>
	<script src='".SITE_DIR."js/scriptaculous.js' type='text/javascript'></script>
</head>
<body>
<div id='container'>
	<div id='navigation'>
		<span id='logo'><img border='0' src='".LOGO."' alt='' /></span>		
		<div id='buttons'>
			<img border='0' src='".MENU_TOP."' alt=''><br />
			".buttons($level)."
			<br /><img border='0' src='".MENU_BOTTOM."' alt=''>
		</div>		
	</div>
	<div id='content'>
		<img border='0' src='".TABLE_TOP."' alt=''>
	";

}

function pageFooter($w3c, $css=true) {

	if ($css) {
		$cssblock = "<a href='http://jigsaw.w3.org/css-validator/'><img src='".SITE_DIR."images/css.PNG' alt='Valid CSS' /></a>";
	}
	if ($w3c) {
		$w3cblock = "<a href='http://validator.w3.org/check?uri=referer'><img src='".SITE_DIR."images/valid-html401.png' alt='Valid HTML 4.01 Transitional' /></a>";
	}
	
	echo "
		<img src='".SITE_DIR."CSS/tableBOTTOM.PNG' ALT=''>
	</div>
	<div id='footer'>
	<!-- old
		Squad BnG was created by <a href='mailto:nessthehero@gmail.com'>NessTheHero</a>, <a href='mailto:GB330033@houston.rr.com'>GB330033</a>, and contributed
		help from others. Everything in this site was made by us.<br />
		&quot;BnG&quot;, <a href='http://www.bobandgeorge.com/'> &quot;Bob and George&quot;</a>, and all things	related to the comic of that name are owned by David Anez. 
		All games we play are owned by their creators and we take no credit in making the actual game.<br />
		No profit is accumulated from any item on this site.<br /><br />
		Any questions regarding the website may be directed to NessTheHero. 
	-->
		Squad BnG was a gaming group consisting of members of a webcomic community known as Bob and George. This site was resurrected by NessTheHero for use as a demonstration
		of his abilities in an online portfolio. None of the content, opinions, or dialogue in this site is relevant since 2007 unless dated otherwise.<br /><br />
		<a href='http://www.nessthehero.com/'>Return to the blog</a><br />
		$cssblock
		$w3cblock
	</div>
</div>
</body>
</html>
	";

}

function check_login() {
        
        $sql = "SELECT * FROM squadmembers";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if ((isset($_COOKIE['SQUADBNG_LOGIN'])) && ($_COOKIE['SQUADBNG_LOGIN'] === strtoupper($row[username]))) {
                        $_SESSION[username] = $row[username];
                        $_SESSION[rank] = $row[rank];
                }
        }
		
}

function in_tourn($id) {        
        $sql = "SELECT * FROM squadmembers WHERE id = '$id'";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $intourn = $row[intourn];
        }
        switch ($intourn) {
                case "yes":
                        return TRUE;
                        break;
                case "no":
                        return FALSE;
                        break;
                default:
                        return FALSE;
                        break;
        }
}

function check_purge() {       
        
        $sql = "SELECT * FROM `purge`";
        $result = @mysql_query($sql) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        if($num > 0) {
                return TRUE;
        } else {
                return FALSE;
        }
}

function get_purge_for_user($id) {      

        $sql = "SELECT * FROM `purge` WHERE user_id = ".$id;
        $result = @mysql_query($sql) or die(mysql_error());

	if (mysql_num_rows($result) == 0) {
		return "new";
	}
        
        while ($row = mysql_fetch_array($result)) {
                $purge = $row[to_delete];
        }
        
        return $purge;
}

function buttons($page) {

        $buttonblock = "";
        switch ($page) {
                case "admin":
                        $sql = "SELECT * FROM buttons WHERE type != 'squad' ORDER BY type, type_id";
                        break;
                case "judge":
                        $sql = "SELECT * FROM buttons WHERE type = 'judge' ORDER BY type_id";
                        break;
                case "squad":
                        $sql = "SELECT * FROM buttons WHERE type = 'squad' ORDER BY type_id";
                        break;
                default:
                        break;
        }
        $result = @mysql_query($sql) or die(mysql_error());
        if (isset($_SESSION[username])) {
                $user_status = "<a href=\"".$site_dir."profile.php\"><img border=\"0\" src=\"".$site_dir."CSS/menuPROFILE.PNG\" ALT=\"\"></a><br>";
        } else {
                $user_status = "<a href=\"".$site_dir."accountlogin.php\"><img border=\"0\" src=\"".$site_dir."CSS/menuLOGIN.PNG\" ALT=\"\"></a><br>";
        }
        if ($result) {
                while ($row = mysql_fetch_array($result)) {
                        if ($buttonblock != "") {
                                $buttonblock .= "<br>\n";
                        }
                        if ($row[type_id] == 2) {
                                if (!$status_set) {
                                        $buttonblock .= $user_status;
                                        $status_set = TRUE;
                                }
                        }
                        $path = $site_dir."CSS/".$row[path];
                        if (($page == "admin") || ($page == "judge")) {
							if (!preg_match("/http:\/\//",$row[dest])) {
								$dest = $admin_dir.$row[dest];
							} else {
                                $dest = $row[dest];
							}
                        } else {
							if (!preg_match("/http:\/\//",$row[dest])) {
								$dest = $site_dir.$row[dest];
							} else {
                                $dest = $row[dest];
							}                                
                        }
                        $active = $row[active];
                        if ($active == "no") {
                                $dest = $site_dir."underconstruction.php";
                        }
                        $buttonblock .= "<a href=\"$dest\"><img src=\"$path\" ALT=\"\"></a>";
                }
        }
        return $buttonblock;
}

function even($num) {
        if (($num % 2) == 0) {
                return TRUE;
        } else {
                return FALSE;
        }
}

function odd($num) {
        if (($num % 2) == 0) {
                return FALSE;
        } else {
                return TRUE;
        }
}

function tourny_status($status) {
        
        $sql = "SELECT status FROM tournaments";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if ($row[status] == $status) {
                        return TRUE;
                }
        }
        return FALSE;
}

function get_tourn_var($key, $var) {
        switch ($var) {
        case "award":
        case "time":
        case "signups":
				$sql = "SELECT * FROM t_stats WHERE t_key = '$key'";                
                break;
        case "name":
        case "description":
        case "game":
        case "status":
				$sql = "SELECT * FROM tournaments WHERE t_key = '$key'";  
                break;
        case "teams":
        case "random":
        case "ppt":
        case "bracket":
        case "match_type":
				$sql = "SELECT * FROM t_options WHERE t_key = '$key'";  
                break;        
		case "game":
		case "g_key":
		case "description":
		case "rec_method":
		case "method_name":
		case "site":
		case "banner":
		case "tourneys":
				$sql = "SELECT * FROM games AS g, tournaments AS t WHERE t.t_key = '$key' AND g.g_key = t.game";  
                break;
		}
		
       
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                return $row[$var];
        }
}

function insert_matches($fighters, $key) {
        
        $m = 1;
        $b = 1;
        $loop = 1;
        
        if (odd(sizeof($fighters))) {
                array_push($fighters, 'UNEVEN');
        }
        
        foreach ($fighters as $f) {
                //id, t_key, match_id, contender, score, box_id, round, done
                $sql = "INSERT INTO matches VALUES ('', '$key', '$m', '$f', 0, $b, 1, 'NO')";
                $result = @mysql_query($sql) or die(mysql_error());
                $b++;
                if (even($loop)) {
                        $m++;
                        $b = 1;
                }
                $loop++;
        }
}

function logs($game) {

        

        $sql = "SELECT rec_method, method_name FROM games WHERE game = '$game'";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if (($row[rec_method] != null) || ($row[rec_method] != "")) {
                        return "yes";
                } else {
                        return "no";
                }
        }

}

function peeps() {
       
        $sql = "SELECT Count(*) AS count FROM squadmembers WHERE intourn = 'yes'";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                return $row[count];
        }
}

function on_team($id, $key) {

        
        $sql = "SELECT * FROM teammates WHERE user_id = '".$id."' AND t_key = '".$key."'";
        $result = @mysql_query($sql) or die(mysql_error());
        if (mysql_num_rows($result) > 0) {
                return TRUE;
        } else {
                return FALSE;
        }

}

function team_name($id) {

        if ($id == "UNEVEN") { return $id; }
        
        $teams = get_tourn_var(get_key(), "teams");
        if ($teams == "yes") {
                $sql = "SELECT * FROM teams WHERE id = '$id'";
                $result = @mysql_query($sql) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        return $row[name];
                }
        } else {
                return get_user_from_id($id);
        }
        
}

function highest_id($table) {
        
        $highest_id = 0;
        $sql = "SELECT id FROM $table";
        $find_id = @mysql_query($sql) or die(mysql_error());
        $search = mysql_num_rows($find_id);
        if ($search == 0) {
                $highest_id = 0;
        } else {
                while($row = mysql_fetch_array($find_id)) {
                        if ($row[id] > $highest_id) {
                                $highest_id = $row[id];
                        }
                }
        }
        return $highest_id;
}

function highest($table, $column, $param) {
        if ($param == "") {
                $param = 1;
        }
        
        $sql = "SELECT MAX(".$column.") AS maxnum FROM ".$table." WHERE ".$param;
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $max = $row[maxnum];
        }

        return $max;
}

function renumber($table) {
       
        $sql = "SELECT id FROM $table";
        $result = mysql_query($sql) or die(mysql_error());
        $num = 1;
        while ($row = mysql_fetch_array($result)) {
                $sql2 = "UPDATE $table SET id = $num WHERE id = '$row[id]'";
                @mysql_query($sql2) or die(mysql_error());
                $num++;
        }
}

function tourny_exists() {       

        $t = FALSE;
        $sql = "SELECT status FROM tournaments";
        $result = @mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if ($row[status] != "finished") {
                        $t = TRUE;
                }
        }
        
        return $t;
}

function get_key() {
        
        $sql = "SELECT t_key FROM tournaments WHERE status != 'finished'";
        $result = @mysql_query($sql) or die(mysql_error());
        if (mysql_num_rows($result) != 0) {
                $key = mysql_result($result, 0);
        }
        return $key;
}

function get_round($key) {
        
        $sql = "SELECT round FROM matches WHERE t_key = '$key' ORDER BY round DESC";
        $result = @mysql_query($sql) or die(mysql_error());
        if (mysql_num_rows($result) != 0) {
                $round = mysql_result($result,0);
        }
        return $round;
}

?>