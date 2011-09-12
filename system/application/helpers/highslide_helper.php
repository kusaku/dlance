<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function show_highslide()
{
	$CI = & get_instance();

	$code = $CI->load->view('highslide', $data = '', TRUE);

	return $code;
}