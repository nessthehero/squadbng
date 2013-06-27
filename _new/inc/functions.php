<?
function debug($var, $name) {
        echo "$".$name." holds the value(s): ";
        print_r($var);
        echo "<br>";
}



function check_login() {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM squadmembers";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if ((isset($_COOKIE['SQUADBNG_LOGIN'])) && ($_COOKIE['SQUADBNG_LOGIN'] === strtoupper($row[username]))) {
                        $_SESSION[username] = $row[username];
                        $_SESSION[rank] = $row[rank];
                }
        }
        return;
}

function dbConnect()
	{
		$db = mysql_connect('mysql.squadbng.com', 'nessie_squadbng', 'weroxxor');
		if (!$db) {
			echo 'Error: Could not connect to the database.  Please try again later.';
			exit;
		} else {
			mysql_select_db('nessie_squadbng');
		}
		return $db;
	}

function get_user_id($username) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM squadmembers WHERE username = '$username'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                return;
        }
        while ($row = mysql_fetch_array($result)) {
                $id = $row[id];
        }
        return $id;
}

function get_user_from_id($id) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM squadmembers WHERE id = '$id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                $sql = "SELECT * FROM old_members WHERE user_id = '$id'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                if (mysql_num_rows($result) == 0) {
                        $username = "Ghost";
                } else {
                        while ($row = mysql_fetch_array($result)) {
                                $username = $row[username];
                        }
                }
        } else {
                while ($row = mysql_fetch_array($result)) {
                        $username = $row[username];
                }
        }
        return $username;
}

function get_gender($id) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM squadmembers WHERE id = '$id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                return;
        }
        while ($row = mysql_fetch_array($result)) {
                $gender = $row[gender];
        }
        return $gender;
}

function get_default_avatar($id) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM avatars WHERE user = '$id' AND def = '1'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                return "NONE";
        }
        while ($row = mysql_fetch_array($result)) {
                $avatar = $row['file'];
        }
        return $avatar;
}

function in_tourn($id) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM squadmembers WHERE id = '$id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
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

function rank($username) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT rank FROM squadmembers WHERE username = '$username'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $rank = $row[rank];
        }
        return $rank;
}

function check_purge() {

        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        
        $sql = "SELECT * FROM `purge`";
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        if($num > 0) {
                return TRUE;
        } else {
                return FALSE;
        }
}

function get_purge_for_user($id) {

        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

        $sql = "SELECT * FROM `purge` WHERE user_id = ".$id;
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        
        while ($row = mysql_fetch_array($result)) {
                $purge = $row[to_delete];
        }
        
        return $purge;
}

function buttons($page) {
        include("vars.php");
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
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
        $result = @mysql_query($sql,$connection) or die(mysql_error());
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
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT status FROM tournaments";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
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
		
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                return $row[$var];
        }
}

function insert_matches($fighters, $key) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $m = 1;
        $b = 1;
        $loop = 1;
        
        if (odd(sizeof($fighters))) {
                array_push($fighters, 'UNEVEN');
        }
        
        foreach ($fighters as $f) {
                //id, t_key, match_id, contender, score, box_id, round, done
                $sql = "INSERT INTO matches VALUES ('', '$key', '$m', '$f', 0, $b, 1, 'NO')";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                $b++;
                if (even($loop)) {
                        $m++;
                        $b = 1;
                }
                $loop++;
        }
}

function logs($game) {

        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

        $sql = "SELECT rec_method, method_name FROM games WHERE game = '$game'";
        $result = @mysql_query($sql, $connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if (($row[rec_method] != null) || ($row[rec_method] != "")) {
                        return "yes";
                } else {
                        return "no";
                }
        }

}

function peeps() {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT Count(*) AS count FROM squadmembers WHERE intourn = 'yes'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                return $row[count];
        }
}

function on_team($id, $key) {

        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM teammates WHERE user_id = '".$id."' AND t_key = '".$key."'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) > 0) {
                return TRUE;
        } else {
                return FALSE;
        }

}

function team_name($id) {

        if ($id == "UNEVEN") { return $id; }
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $teams = get_tourn_var(get_key(), "teams");
        if ($teams == "yes") {
                $sql = "SELECT * FROM teams WHERE id = '$id'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                while ($row = mysql_fetch_array($result)) {
                        return $row[name];
                }
        } else {
                return get_user_from_id($id);
        }
        
}

function highest_id($table) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $highest_id = 0;
        $sql = "SELECT id FROM $table";
        $find_id = @mysql_query($sql,$connection) or die(mysql_error());
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
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT MAX(".$column.") AS maxnum FROM ".$table." WHERE ".$param;
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $max = $row[maxnum];
        }

        return $max;
}

function renumber($table) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT id FROM $table";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        $num = 1;
        while ($row = mysql_fetch_array($result)) {
                $sql2 = "UPDATE $table SET id = $num WHERE id = '$row[id]'";
                @mysql_query($sql2,$connection) or die(mysql_error());
                $num++;
        }
}

function banned($id) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT ban FROM squadmembers WHERE id = '$id'";
        $result = mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $ban = $row[ban];
        }
        if (($ban > 0) || ($ban == "I")) {
                return TRUE;
        } else {
                return FALSE;
        }
}

function tourny_exists() {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());

        $t = FALSE;
        $sql = "SELECT status FROM tournaments";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if ($row[status] != "finished") {
                        $t = TRUE;
                }
        }
        
        return $t;
}

function get_key() {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT t_key FROM tournaments WHERE status != 'finished'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 0) {
                $key = mysql_result($result, 0);
        }
        return $key;
}

function get_round($key) {
        $connection = @mysql_connect("mysql.squadbng.com", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT round FROM matches WHERE t_key = '$key' ORDER BY round DESC";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 0) {
                $round = mysql_result($result,0);
        }
        return $round;
}

function _get_browser()
{
  $browser = array ( //reversed array
   "OPERA",
   "MSIE",            // parent
   "NETSCAPE",
   "FIREFOX",
   "SAFARI",
   "KONQUEROR",
   "MOZILLA"        // parent
  );

  $info[browser] = "OTHER";

  foreach ($browser as $parent)
  {
   if ( ($s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent)) !== FALSE )
   {
     $f = $s + strlen($parent);
     $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 5);
     $version = preg_replace('/[^0-9,.]/','',$version);

     $info[browser] = $parent;
     $info[version] = $version;
     break; // first match wins
   }
  }

  return $info;
}
?>
