<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common
{
	function __construct()
	{
		$this->_ci =& get_instance();

		$this->_ci->load->model('balance/balance_mdl');

		$this->change_tariff();

		$this->return_payment();
	}
/*
|---------------------------------------------------------------
| Смена тарифа
|---------------------------------------------------------------
*/
    function change_tariff() 
	{
		$this->_ci->load->model('common/common_mdl');

		$this->_ci->common_mdl->change_tariff();
	}
/*
|---------------------------------------------------------------
| Возвращение платежей с истёкшим сроком
|---------------------------------------------------------------
*/
    function return_payment() 
	{
		$this->_ci->load->model('common/common_mdl');

		$this->_ci->common_mdl->return_payment();
	}
    function email($email, $subject, $message, $file = '') 
	{
		$encoding = "windows-1251";

		$subject = "=?".$encoding."?b?".base64_encode($subject)."?=";

		$from = $this->_ci->config->item('email');

		$this->_ci->load->library('email');
		
		$this->_ci->email->clear(TRUE);

		if( !empty($file) )
		{
			$this->_ci->email->attach($file);
		}

		$this->_ci->email->from($from);

		$this->_ci->email->to($email);

		$this->_ci->email->subject($subject);

		$this->_ci->email->message($message);

		$this->_ci->email->send();
	}
}