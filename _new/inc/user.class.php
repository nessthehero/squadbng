<?

class User {

	var $id;
	var $name;
	var $email;
	var $password;
	var $rank;
	var $gender;
	var $twon;
	var $tpart;
	var $ban;
	var $intourn;

	public function setUser($id) {
	
		$sql = "SELECT id, username, email, password, gender, twon, tpart, ban, intourn, rank FROM squadmembers WHERE id = '$id'";
		$result = mysql_query($sql) or die(mysql_error());
		
		while ($row = mysql_fetch_array($result)) {
		
			$this->id = $row['id'];
			$this->name = $row['username'];
			$this->email = $row['email'];
			$this->password = $row['password'];
			$this->gender = $row['gender'];
			$this->rank = $row['rank'];
			$this->twon = $row['twon'];
			$this->tpart = $row['tpart'];
			$this->ban = $row['ban'];
			$this->intourn = $row['intourn'];
		
		}
	
	}
	
	public function isLoggedIn($id = $this->id) {
	
		protected bool $return;
	
		if ($this->id != $id) {
			$this->setUser($id);
		}
		
		if ((isset($_COOKIE['SQUADBNG_LOGIN'])) && ($_COOKIE['SQUADBNG_LOGIN'] === strtoupper($this->name))) {
			$return = TRUE;
		} else {
			$return = FALSE;
		}
		
		return $return;
	}
	
	public function avatar {
	
		$sql = "SELECT * FROM avatars WHERE user = '".$this->id."' AND def = '1'";
        $result = @mysql_query($sql,$connection) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
                return "NONE";
        }
        while ($row = mysql_fetch_array($result)) {
                $avatar = $row['file'];
        }
        return $avatar;
	
	}

}


?>