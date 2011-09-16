<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Errors
{
	function __construct()
	{
		$this->_ci =& get_instance();
	}

	function access()
	{
		if( !$this->_ci->users_mdl->logged_in() )
		{

			$this->_ci->template->build('users/login', $data = array(), $title = 'Авторизация пользователя');

			return FALSE;
		}
			return TRUE;
	}
}