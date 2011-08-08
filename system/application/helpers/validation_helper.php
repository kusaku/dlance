<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function show_validation()
	{
		$CI = & get_instance();
		
		$code = $CI->load->view('validation', $data = '', TRUE);
		
		return $code;
	}	