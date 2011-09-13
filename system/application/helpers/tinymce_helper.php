<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function show_tinimce($id, $mode = '')
	{
		$CI = & get_instance();
		$data = array();
		$data['id'] = $id;
		
		if( $mode == 'simple' )
		{
			$code = $CI->load->view('tinymce/tinymce_simple', $data, TRUE);	
		}
		else
		{
			$code = $CI->load->view('tinymce/tinymce', $data, TRUE);
		}

		
		return $code;
	}