<?php

class User
{
	
	// Internal class variables
	protected $new_user;
	// User variables
	protected $id, $name, $email, $password, $gender, $won, $participation, $ban, $intourn, $rank;
		
	public function User($id=0) {
	
		$this->id 				= 0;
		$this->name 			= '';
		$this->email 			= '';
		$this->password 		= '';
		$this->gender 			= 'male';
		$this->won 				= 0;
		$this->participation 	= 0;
		$this->ban				= 0;
		$this->intourn			= 'no';
		$this->rank 			= 'squad';
	
		if ($id != 0) {
			$this->load($id);
		}
	
	}
	
	public function create($name, $email, $password, $gender) {
	
		$this->new_user = 1;
	
		$this->name 			= $name;
		$this->email 			= $email;
		$this->password 		= md5($password);
		$this->gender 			= $gender;
		$this->won 				= 0;
		$this->participation 	= 0;
		$this->ban				= 0;
		$this->intourn			= 'no';
		$this->rank 			= 'squad';
		
		$this->save();
		
	}
	
	public function load($id) {	
	
		$this->id 				= $id;
		$this->name 			= '';
		$this->email 			= '';
		$this->password 		= '';
		$this->gender 			= '';
		$this->won 				= 0;
		$this->participation 	= 0;
		$this->ban				= 0;
		$this->intourn			= 'no';
		$this->rank 			= '';
		
		$sql = "SELECT * FROM squadmembers WHERE id = '$id' LIMIT 1";
		$result = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			
			$row = mysql_fetch_array($result);
			
			$this->name 			= $row['username'];
			$this->email 			= $row['email'];
			$this->password 		= $row['password'];
			$this->gender 			= $row['gender'];
			$this->won 				= $row['twon'];
			$this->participation 	= $row['tpart'];
			$this->ban				= $row['ban'];
			$this->intourn			= $row['intourn'];
			$this->rank 			= $row['rank'];
			
		}
		
	}
	
	public function search($name) {	
	
		$this->id 				= 0;
		$this->name 			= $name;
		$this->email 			= '';
		$this->password 		= '';
		$this->gender 			= '';
		$this->won 				= '';
		$this->participation 	= '';
		$this->ban				= 0;
		$this->intourn			= 'no';
		$this->rank 			= '';
		
		$sql = "SELECT * FROM squadmembers WHERE username = '$name' LIMIT 1";
		$result = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($result) != 0) {
			
			$row = mysql_fetch_array($result);
			
			$this->id 				= $row['id'];
			$this->email 			= $row['email'];
			$this->password 		= $row['password'];
			$this->gender 			= $row['gender'];
			$this->won 				= $row['twon'];
			$this->participation 	= $row['tpart'];
			$this->ban				= $row['ban'];
			$this->intourn			= $row['intourn'];
			$this->rank 			= $row['rank'];
			
			return 1;
			
		} else {
			return 0;
		}
		
	}
	
	function getAvatar($env="profile") {
		$sql = "SELECT * FROM avatars WHERE user = '".$this->id."' AND def = '1'";
        $result = @mysql_query($sql) or die(mysql_error());
        if (mysql_num_rows($result) == 0) {
        	$return = "NONE";
        } else {
			while ($row = mysql_fetch_array($result)) {
				$file = $row['file'];
			}
			
			$return = "<div class='user_avatar'><img src='".SITE_DIR.$file."' border='0' ALT='"."' />";
			if ($env != "profile") {
				$return .= "<br />".$this->getName();
			}
			$return .= "</div>";
		}
        return $return;	
	}
	
	function getAwards() {

		$awardsArray = array();

		$sql = "SELECT a.notes, i.* FROM `awards` a, `images` i WHERE i.id = a.img_id AND a.username = '".$this->id."' ORDER BY a.level ASC";
		$result = @mysql_query($sql) or die(mysql_error());
		while ($row = mysql_fetch_array($result)) {
			$awardsArray[$row['class']][] = array(
				'filename' 	=> SITE_DIR.'images/awards/'.$row['filename'],
				'name' 		=> $row['name'],
				'notes'		=> $row['notes'],
				'misc'		=> $row['misc']
			);
		}

		return $awardsArray;

	}
	
	function getTemplate() {
		return "squad";
	}
	
	function save() {
	
		if ($this->new_user == 1) {
		
			$sql = "INSERT INTO squadmembers 
						VALUES ('', 
								'".$this->name."', 
								'".$this->email."',
								'".$this->password."',
								'".$this->gender."',
								'".$this->won."',
								'".$this->participation."',
								'".$this->ban."',
								'".$this->intourn."',
								'".$this->rank."')";
			$this->new_user = 0;
		
		} else {
	
			$sql = "UPDATE squadmembers 
						SET username 	= '".$this->name."',
							email 		= '".$this->email."',
							password 	= '".$this->password."',
							gender 		= '".$this->gender."',
							twon 		= '".$this->won."',
							tpart 		= '".$this->participation."',
							ban 		= '".$this->ban."',
							intourn		= '".$this->intourn."',
							rank 		= '".$this->rank."'
						WHERE id = '".$this->id."'";
		
		}
		
		@mysql_query($sql) or die(mysql_error());
	
	}
	
	// Getters and Setters
	
	function getID() {
		return $this->id;
	}	
	function getName() {
		return $this->name;
	}
	function getEmail() {
		return $this->email;
	}
	function getPassword() {
		return $this->password;
	}
	function getGender() {
		return $this->gender;
	}	
	function getWins() {
		return $this->won;
	}
	function getParticipation() {
		return $this->participation;
	}
	function getBan() {
		return $this->ban;	
	}
	function getInTourn() {
		return $this->intourn;
	}
	function getRank() {
		return $this->rank;
	}
	
	function setID($id) {
		$this->id = $id;
	}	
	function setName($name) {
		$this->name = $name;
	}
	function setEmail($email) {
		$this->email = $email;
	}
	function setPassword($pass) {
		$this->password = $pass; 
	}
	function setGender($gender) {
		$this->gender = $gender;
	}	
	function setWins($won) {
		$this->won = $won;
	}
	function setParticipation($part) {
		$this->participation = $part;
	}
	function setBan($ban) {
		$this->ban = $ban;
	}
	function setInTourn($intourn) {
		$this->intourn = $intourn;
	}
	function setRank($rank) {
		$this->rank = $rank;
	}

}
?>