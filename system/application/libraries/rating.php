<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rating
{
	function __construct()
	{
		$this->_ci =& get_instance();
	}

    function value($user_id)//Получаем пункты рейтинга за какое нибудь действие
	{
		$this->_ci->load->model('rating/rating_mdl');

		return $this->_ci->rating_mdl->value($user_id);
	}

    function get($user_id) 
	{
		$this->_ci->load->model('rating/rating_mdl');

		return $this->_ci->rating_mdl->get($user_id);
	}

    function plus($user_id, $count) 
	{
		$this->_ci->load->model('rating/rating_mdl');

		$this->_ci->rating_mdl->plus($user_id, $count);
	}

    function minus($user_id, $count) 
	{
		$this->_ci->load->model('rating/rating_mdl');

		$this->_ci->rating_mdl->minus($user_id, $count);
	}
}