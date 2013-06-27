<?
function check_login() {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $ip = md5(getenv("REMOTE_ADDR"));
        $ip_addresses = array();
        $sql = "SELECT * FROM sessions";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if ($row[saved_ips] != NULL) {
                        if (strpos($ip_addresses, ":") === FALSE) {
                                $ip_addresses[] = $row[saved_ips];
                        } else {
                                $ip_addresses = explode(":", $row[saved_ips]);
                        }
                        $username = get_user_from_id($row[user_id]);
                        if (in_array($ip, $ip_addresses)) {
                                $_SESSION[username] = $username;
                                if (rank($username) == "admin") {
                                        $_SESSION[rank] = "ADMIN";
                                }
                                if (rank($username) == "judge") {
                                        $_SESSION[rank] = "JUDGE";
                                }
                                if (rank($username) == "squad") {
                                        $_SESSION[rank] = "SQUAD";
                                }
                        }
                        unset($ip_addresses);
                }
        }
        return;
}

function get_user_id($username) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
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
$connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT * FROM squadmembers WHERE id = '$id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                return;
        }
        while ($row = mysql_fetch_array($result)) {
                $username = $row[username];
        }
        return $username;
}

function insert_saved_ip($ip) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $u_id = get_user_id($_SESSION[username]);
        $sql = "SELECT * FROM sessions WHERE user_id = '$u_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                return;
        }

        while ($row = mysql_fetch_array($result)) {
                if ($row[saved_ips] != NULL) {
                        if (strpos($row[saved_ips], ":") === FALSE) {
                                $ip_addresses[] = $row[saved_ips];
                        } else {
                                $ip_addresses = explode(":", $row[saved_ips]);
                        }
                }
        }
        if (in_array($ip, $ip_addresses)) {
                return;
        } else {
                $ip_addresses[] = $ip;
                if (sizeof($ip_addresses) == 1) {
                        $saved_ips = $ip_addresses[0];
                } else {
                        $saved_ips = implode(":", $ip_addresses);
                }
                $sql = "UPDATE sessions SET saved_ips = '$saved_ips' WHERE user_id = '$u_id'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
                return;
        }
}

function remove_saved_ip($ip) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $u_id = get_user_id($_SESSION[username]);
        $sql = "SELECT * FROM sessions WHERE user_id = '$u_id'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                return;
        }
        $ip_addresses = array();
        while ($row = mysql_fetch_array($result)) {
                if ($row[saved_ips] != NULL) {
                        if (strpos($row[saved_ips], ":") === FALSE) {
                                $ip_addresses[] = $row[saved_ips];
                        } else {
                                $ip_addresses = explode(":", $row[saved_ips]);
                        }
                }
        }
        $temp_array = array();
        $loop = 1;
        while ($loop <= sizeof($ip_addresses)) {
                if ($ip_addresses[$loop] != $ip) {
                        $temp_array[$loop] = $ip_addresses[$loop];
                        $loop++;
                }
        }
        unset($ip_addresses);
        $ip_addresses = array();
        $loop = 1;
        while ($loop <= sizeof($temp_array)) {
                $ip_addresses[$loop] = $temp_array[$loop];
                $loop++;
        }
        if (sizeof($ip_addresses) > 1) {
                $saved_ips = implode(":", $ip_addresses);
                $sql = "UPDATE sessions SET saved_ips = '$saved_ips' WHERE user_id = '$u_id'";
        } elseif (sizeof($ip_addresses) == 1) {
                $saved_ips = $ip_addresses[0];
                $sql = "UPDATE sessions SET saved_ips = '$saved_ips' WHERE user_id = '$u_id'";
        } else {
                $saved_ips = NULL;
                $sql = "UPDATE sessions SET saved_ips = NULL WHERE user_id = '$u_id'";
        }
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        return;
}


function rank($username) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT rank FROM squadmembers WHERE username = '$username'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                $rank = $row[rank];
        }
        return $rank;
}

function buttons($page) {
        include("vars.php");
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $buttonblock = "";
        if ($page == "admin") {
                $sql = "SELECT * FROM buttons WHERE type != 'squad' ORDER BY type, type_id";
        }
        if ($page == "judge") {
                $sql = "SELECT * FROM buttons WHERE type = 'judge' ORDER BY type_id";
        }
        if ($page == "squad") {
                $sql = "SELECT * FROM buttons WHERE type = 'squad' ORDER BY type_id";
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
                                $dest = $admin_dir.$row[dest];
                        } else {
                                $dest = $site_dir.$row[dest];
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
        if (($num / 2) == intval($num / 2)) {
                return TRUE;
        } else {
                return FALSE;
        }
}

function odd($num) {
        if (($num / 2) != intval($num / 2)) {
                return TRUE;
        } else {
                return FALSE;
        }
}

function tourny_status($status) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT status FROM tournaments";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if (($row[status] == "active") && ($status == "active")) {
                        return TRUE;
                }
                if (($row[status] == "pending") && ($status == "pending")) {
                        return TRUE;
                }
        }
        return FALSE;
}

function teams($key) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT teams FROM tournaments";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
                if ($row[teams] == "yes") {
                        return TRUE;
                } else {
                        return FALSE;
                }
        }
}

function highest_id($table) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
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

function banned($user) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT ban FROM squadmembers WHERE username = '$user'";
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

function get_key() {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $status = "active";
        $sql = "SELECT t_key FROM tournaments WHERE status = '$status'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) != 1) {
                $status = "pending";
                $sql = "SELECT t_key FROM tournaments WHERE status = '$status'";
                $result = @mysql_query($sql,$connection) or die(mysql_error());
        }
        $key = mysql_result($result, 0);
        return $key;
}

function get_round($key) {
        $connection = @mysql_connect("localhost", "nessie_squadbng", "weroxxor") or die(mysql_error());
        $db = @mysql_select_db("nessie_squadbng", $connection) or die(mysql_error());
        $sql = "SELECT t_round FROM matches WHERE t_key = '$key' ORDER BY t_round DESC";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        $round = mysql_result($result,0);
        return $round;
}
?>
