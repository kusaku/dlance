<?php 
defined('BASEPATH') or exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation {

	function MY_Form_validation() {
		parent::CI_Form_validation();
		$this->CI->load->language('extra_validation');
	}

	function text($str) {
		return preg_match("/[^\||\'|\<|\>|\"|\$|\@|\/|\\\|\&]+$/u", $str) > 0;
	}
	
	//Специальные символы запрещены
	function nospecial($str) {
		return preg_match("/[^\||\'|\<|\>|\"|\!|\?|\$|\@|\/|\\\|\&\~\*\+]+$/u", $str) > 0;
	}
	
	//Только русские (и латинские?) символы
	function cyrillic($str) {
		return preg_match("/^[\wА-Яа-яЁё]+$/u ", $str) > 0;
	}
	
	//Может содержать латинские символы, цифры, знак подчеркивания и дефис.
	function skype($str) {
		return preg_match("/^[\w\d_\-]+$/u", $str) > 0;
	}
	
	//Может содержать латинские символы, цифры, знак подчеркивания и дефис.
	function telephone($str) {
		return preg_match("/^[0-9\-\(\)\+]+$/u", $str) > 0;
	}

	function wmz($str) {
		return preg_match("/^([z])+[0-9]{12}$/ix", $str) > 0;
	}

	function wmr($str) {
		return preg_match("/^([r])+[0-9]{12}$/ix", $str) > 0;
	}
}
