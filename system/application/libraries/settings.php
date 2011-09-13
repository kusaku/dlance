<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings
{
	function __construct()
	{
		$this->_ci =& get_instance();
	}

    function value($user_id, $param)
	{
		$settings = $this->_ci->users_mdl->get_settings($user_id);
		
		return $settings[$param];
	}
}