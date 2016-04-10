<?php
# this class is session handling class
class Session{
	protected $session_id;
	protected $session_name;
	protected $user_id;
	protected $user_nick;
	protected $seperator;

	public function __construct($seperator = "lubycon", $session_name = "lubycon"){
		session_name($session_name);

		if(!isset($_SESSION)){
			$this->$session_name = $session_name;
			$this-> InitSession();
		}
		$this->session_id = session_id();
		$this->seperator = $seperator;
	}

	public function InitSession(){
		session_start();
		# set php.ini
		# set session expire time maximum 1440(if do not anything)
		# set session lifetime 0(if exit browser delete session)
		ini_set("session.gc_maxlifetime", 1440);
		ini_set("session.cookie_lifetime", 0);
	}

	public function SessionId(){
		$this->session_id = session_id();
		return isset($this->session_id);
	}

	public function SessionExist(){
		$count = 0;
		if(isset($_SESSION)){
			foreach($_SESSION as $name=>$val){
				if(strpos($name,$this->seperator) !== false){
					if(strpos($name,'session_id') == false){
						if(isset($val)){
						$count = $count + 1;
						}	
					}
				}
			}
		}
		if($count > 0){
			return true;
		}else{
			return false;
		}
	}

	public function WriteSession($seperator="lubycon",$id, $nick){
		$this->seperator = $seperator;
		
		$temp_sessionId = $seperator.'_session_id';
		$temp_id = $seperator.'_id';
		$temp_nick = $seperator.'_nick';

		$_SESSION[$temp_sessionId] = $this->session_id = session_id();
		$_SESSION[$temp_id] = $this->user_id = $id;
		$_SESSION[$temp_nick] = $this->user_nick = $nick;
	}

	public function DestroySession(){
		session_destroy();

		$temp_sessionId = $this->seperator.'_session_id';
		$temp_id = $this->seperator.'_id';
		$temp_nick = $this->seperator.'_nick';

		$_SESSION[$temp_sessionId] = NULL;
		$_SESSION[$temp_id] = NULL;
		$_SESSION[$temp_nick] = NULL;
	}

	public function GetVar(){
		$var = array();
		foreach($_SESSION as $name=>$val){
			if(strpos($name, $this->seperator) !== false){ // 아이덴티티 분리 후 검사해야할듯 재검토 필요 160307
				$temp = array($name=>$val);
				$var = array_merge($var,$temp);
			}
		}
		return $var;
	}

	public function FreeResource(){
		$this->session_id = null;
		$this->user_id = null;
		$this->user_nick = null;
		$this->seperator = null;
	}

	public function GetSessionId(){return session_id();}
	public function GetSessionName(){return session_name();}
}

?>