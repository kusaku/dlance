<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Transaction
{
	function __construct()
	{
		$this->_ci =& get_instance();
	}

    function create($user_id, $descr, $amount) 
	{
		if( empty($amount) )
		{
			return FALSE;
		}

		$data = array (
			'user_id' => $user_id,
			'date' => now(),
			'amount' => $amount,
			'descr' => $descr
		);

		$this->_ci->db->insert('transaction', $data);
	}
}