<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Common {

	function __construct() {
		$this->_ci = &get_instance();
		
		$this->_ci->load->model('balance/balance_mdl');
		
		$this->change_tariff();
		
		$this->return_payment();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Смена тарифа
	 * ---------------------------------------------------------------
	 */

	function change_tariff() {
		$this->_ci->load->model('common/common_mdl');
		
		$this->_ci->common_mdl->change_tariff();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Возвращение платежей с истёкшим сроком
	 * ---------------------------------------------------------------
	 */

	function return_payment() {
		$this->_ci->load->model('common/common_mdl');
		
		$this->_ci->common_mdl->return_payment();
	}

	function email($email, $subject, $message, $file = '') {
	
		/** @var $pml PHPMailerLite */

		static $pml;
		
		if (isset($pml)) {
			$pml->ClearAddresses();
			$pml->ClearCCs();
			$pml->ClearBCCs();
			$pml->ClearReplyTos();
			$pml->ClearAllRecipients();
			$pml->ClearAttachments();
			$pml->ClearCustomHeaders();
		} else {
			$this->_ci->load->library('phpmailerlite');
			$pml = $this->_ci->phpmailerlite;
			$pml->CharSet = $this->_ci->config->item('charset');
			$pml->Mailer = $this->_ci->config->item('protocol');
			$pml->WordWrap = $this->_ci->config->item('wordwrap');
			$pml->IsHTML();
		}
		
		$pml->From = "noreply@{$_SERVER['HTTP_HOST']}";
		$pml->FromName = 'Dlance';
		$pml->Sender = "root@{$_SERVER['HTTP_HOST']}";
		
		$pml->AddAddress($email);
		
		$pml->Subject = $subject;
		$pml->Body = $message;
		$pml->AltBody = strip_tags($message);
		
		if (! empty($file)) {
			$pml->AddAttachment($file);
		}
		
		$pml->Send();
	}
}


