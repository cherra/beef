<?php
class acl
{
	var $perms = array();		//Array : Almacena los permisos del usuario
	var $userID;			//Integer : Almacena el ID del usuario
	var $userRoles = array();	//Array : Almacena los roles del usuario
	var $ci;
        var $routing;
	
        function __construct() {
		$this->ci = &get_instance();
                $this->routing =& load_class('Router');
                //$this->ci->load->helper('url');

                /*if(isset($config['userID'])){
                    $this->userID = floatval($config['userID']);
                    $this->userRoles = $this->getUserRoles();
                    $this->buildACL();
                }*/
	}

	function buildACL() {
		//Obtiene los permisos para los roles del usuario
		if (count($this->userRoles) > 0)
		{
			$this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));
		}
                //Después, obtiene los permisos individuales del usuario
		$this->perms = array_merge($this->perms,$this->getUserPerms($this->userID));
	}

	function getPermKeyFromID($permID) {
		//$strSQL = "SELECT `permKey` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
		$this->ci->db->select('permKey');
		$this->ci->db->where('id',floatval($permID));
		$sql = $this->ci->db->get('perm_data',1);
		$data = $sql->result();
		return $data[0]->permKey;
	}

	function getPermNameFromID($permID) {
		//$strSQL = "SELECT `permName` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
		$this->ci->db->select('permName');
		$this->ci->db->where('id',floatval($permID));
		$sql = $this->ci->db->get('perm_data',1);
		$data = $sql->result();
		return $data[0]->permName;
	}

	function getRoleNameFromID($roleID) {
		//$strSQL = "SELECT `roleName` FROM `".DB_PREFIX."roles` WHERE `ID` = " . floatval($roleID) . " LIMIT 1";
		$this->ci->db->select('roleName');
		$this->ci->db->where('id',floatval($roleID),1);
		$sql = $this->ci->db->get('role_data');
		$data = $sql->result();
		return $data[0]->roleName;
	}

	function getUserRoles() {
		//$strSQL = "SELECT * FROM `".DB_PREFIX."user_roles` WHERE `userID` = " . floatval($this->userID) . " ORDER BY `addDate` ASC";

		$this->ci->db->where(array('userID'=>floatval($this->userID)));
		$this->ci->db->order_by('addDate','asc');
		$sql = $this->ci->db->get('user_roles');
		$data = $sql->result();

		$resp = array();
		foreach( $data as $row )
		{
			$resp[] = $row->roleID;
		}
		return $resp;
	}

	function getAllRoles($format='ids') {
		$format = strtolower($format);
		//$strSQL = "SELECT * FROM `".DB_PREFIX."roles` ORDER BY `roleName` ASC";
		$this->ci->db->order_by('roleName','asc');
		$sql = $this->ci->db->get('role_data');
		$data = $sql->result();

		$resp = array();
		foreach( $data as $row )
		{
			if ($format == 'full')
			{
				$resp[] = array("id" => $row->ID,"name" => $row->roleName);
			} else {
				$resp[] = $row->ID;
			}
		}
		return $resp;
	}

	function getAllPerms($format='ids') {
		$format = strtolower($format);
		//$strSQL = "SELECT * FROM `".DB_PREFIX."permissions` ORDER BY `permKey` ASC";

		$this->ci->db->order_by('permKey','asc');
		$sql = $this->ci->db->get('perm_data');
		$data = $sql->result();

		$resp = array();
		foreach( $data as $row )
		{
			if ($format == 'full')
			{
				$resp[$row->permKey] = array('id' => $row->ID, 'name' => $row->permName, 'key' => $row->permKey);
			} else {
				$resp[] = $row->ID;
			}
		}
		return $resp;
	}

	function getRolePerms($role) {
		if (is_array($role))
		{
			//$roleSQL = "SELECT * FROM `".DB_PREFIX."role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
			$this->ci->db->where_in('roleID',$role);
		} else {
			//$roleSQL = "SELECT * FROM `".DB_PREFIX."role_perms` WHERE `roleID` = " . floatval($role) . " ORDER BY `ID` ASC";
			$this->ci->db->where(array('roleID'=>floatval($role)));

		}
		$this->ci->db->order_by('id','asc');
		$sql = $this->ci->db->get('role_perms'); //$this->db->select($roleSQL);
		$data = $sql->result();
		$perms = array();
		foreach( $data as $row )
		{
			$pK = strtolower($this->getPermKeyFromID($row->permID));
			if ($pK == '') { continue; }
			if ($row->value === '1') {
				$hP = true;
			} else {
				$hP = false;
			}
			$perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'name' => $this->getPermNameFromID($row->permID),'id' => $row->permID);
		}
		return $perms;
	}

	function getUserPerms($userID) {
		//$strSQL = "SELECT * FROM `".DB_PREFIX."user_perms` WHERE `userID` = " . floatval($userID) . " ORDER BY `addDate` ASC";

		$this->ci->db->where('userID',floatval($userID));
		$this->ci->db->order_by('addDate','asc');
		$sql = $this->ci->db->get('user_perms');
		$data = $sql->result();

		$perms = array();
		foreach( $data as $row )
		{
			$pK = strtolower($this->getPermKeyFromID($row->permID));
			if ($pK == '') { continue; }
			if ($row->value == '1') {
				$hP = true;
			} else {
				$hP = false;
			}
			$perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'name' => $this->getPermNameFromID($row->permID),'id' => $row->permID);
		}
		return $perms;
	}
        
        function setPerm($perm){
            $class = $this->routing->fetch_class();
            $method = $this->routing->fetch_method();
            $folder = strstr(uri_string(), '/'.$class, TRUE);
            $folders = explode('/',$folder);
            $permData = array(
                'permKey' => $perm,
                'permName' => $perm,
                'folder' => $folders[0] ? $folders[0] : '',
                'submenu' => $folders[1] ? $folders[1] : '',
                'method' => $method,
                'class' => $class
            );
            
            $this->ci->db->insert('perm_data',$permData);
        }

	function hasRole($roleID) {
		foreach($this->userRoles as $k => $v)
		{
			if (floatval($v) === floatval($roleID))
			{
				return true;
			}
		}
		return false;
	}

	function hasPermission() {
                $class = $this->routing->fetch_class();
                $method = $this->routing->fetch_method();
                $folder = strstr(uri_string(), $class, TRUE);
                
                //$permKey = $this->ci->uri->uri_string();
                $permKey = $class;
                $permKey .= $method != "index" ? "/".$method : "";
                $permKey = strtolower($permKey);
                
                if($this->check_isvalidated()){ // Si ya esta iniciada la sesión
                    if(!$this->ci->input->is_ajax_request() && $class != "ajax"){
                        if($class == 'login' && $method == 'index')
                            redirect('home');

                        if($class == 'home' && $method == 'index')
                            return false;

                        if($this->ci->session->userdata('userid')){
                            $this->userID = floatval($this->ci->session->userdata('userid'));
                            $this->userRoles = $this->getUserRoles();
                            $this->buildACL();

                            /*
                            *  Si el permiso no está dado de alta en la base de datos, verifica que el método llamado existe,
                            * y lo da de alta en la tabla perm_data.
                            */
                            $roles = $this->getAllPerms('full');
                            if(!array_key_exists($permKey, $roles)){
                                if(method_exists($this->ci, $method)){
                                    if(is_callable(array($this->ci,$method))){
                                        $this->setPerm($permKey);
                                    }
                                }
                            }
                            
                            if (array_key_exists($permKey,$this->perms))
                            {
                                    if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true)
                                    {
                                        $this->ci->load->vars(array('title' => $this->perms[$permKey]['name']));
                                        return true;
                                    } else {
                                        redirect('home');
                                    }
                            } else {
                                redirect('home');
                            }
                        }else
                            redirect('home');
                    }
                }elseif($permKey != strstr($permKey,'login'))
                    redirect('login');
	}
        
        private function check_isvalidated(){
            $permKey = $this->ci->uri->uri_string();
            $permKey = strtolower($permKey);
            if(! $this->ci->session->userdata('validated')){
                return false;
            }else
                return true;
        }
}
?>
