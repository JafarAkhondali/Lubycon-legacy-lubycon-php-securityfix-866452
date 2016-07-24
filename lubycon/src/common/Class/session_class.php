<?php
# this class is session handling class
class Session{
	protected $id;
	protected $seperator;
	protected $error;

	public function __construct($seperator = "lubycon", $session_name = "lubycon",$max_lifeTime = 1440, $lifeTime = 0){
		session_name($session_name);

		if(!isset($_SESSION)){
			$this->$session_name = $session_name;
			$this-> InitSession($max_lifeTime, $lifeTime);
		}
		$this->id = session_id();
		$this->seperator = $seperator;

		if($this->error)
			die("didn't start Session");
	}

	public function InitSession($max_lifeTime, $lifeTime){
		$this->error = session_start();
		# set php.ini
		# set session expire time maximum 1440(if do not anything)
		# set session lifetime 0(if exit browser delete session)
		ini_set("session.gc_maxlifetime", $max_lifeTime);
		ini_set("session.cookie_lifetime", $lifeTime);
	}

	public function SessionId(){
		$this->id = session_id();
		return isset($this->id);
	}

	public function SessionExist(){
		$count = 0;
		
		if(isset($_SESSION)){
			foreach($_SESSION as $name=>$val){
				if(strpos($name,$this->seperator) !== false){
					if(strpos($name,'session_id') == false){
						
						if(isset($val) === true)
							$count = $count + 1;
							
					}
				}
			}
		}
		return ($count > 0) ? true : false;
	}

	public function WriteSession($seperator="lubycon",$array){
		$this->seperator = $seperator;

		$_SESSION[$seperator.'_session_id'] = session_id();

		foreach($array as $key=>$value){
			if($key !== "pass")
				$_SESSION[$seperator.'_'.$key] = $value;
		}
		
		/*
		$temp_sessionId = $seperator.'_session_id';
		$temp_id = $seperator.'_id';
		$temp_nick = $seperator.'_nick';
		$temp_code = $seperator.'_code';
		$temp_validation = $seperator.'_validation';

		$_SESSION[$temp_sessionId] = $this->session_id = session_id();
		$_SESSION[$temp_id] = $this->user_id = $id;
		$_SESSION[$temp_nick] = $this->user_nick = $nick;
		$_SESSION[$temp_code] = $this->user_code = $code;
		*/
	}

	public function DestroySession(){
		session_destroy();

		$temp_sessionId = $this->seperator.'_session_id';
		$temp_id = $this->seperator.'_id';
		$temp_nick = $this->seperator.'_nick';
		$temp_code = $this->seperator.'_code';

		$_SESSION[$temp_sessionId] = NULL;
		$_SESSION[$temp_id] = NULL;
		$_SESSION[$temp_nick] = NULL;
		$_SESSION[$temp_code] = NULL;
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
		$this->id = null;
		$this->user_id = null;
		$this->user_nick = null;
		$this->user_code = null;
		$this->seperator = null;
	}

	public function GetSessionId(){return session_id();}
	public function GetSessionName(){return session_name();}
}

?>