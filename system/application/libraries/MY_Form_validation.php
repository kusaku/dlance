<?php defined('BASEPATH') or exit('No direct script access allowed.');

class MY_Form_validation extends CI_Form_validation {

	function MY_Form_validation()
	{
		parent::CI_Form_validation();
		$this->CI->load->language('extra_validation');
	}

	function text($str)
	{
		return ( ! preg_match("/[^\||\'|\<|\>|\"|\$|\@|\/|\\\|\&]+$/", $str)) ? FALSE : TRUE;
	}

	function nospecial($str)//����������� ������� ���������
	{
		return ( ! preg_match("/[^\||\'|\<|\>|\"|\!|\?|\$|\@|\/|\\\|\&\~\*\+]+$/", $str)) ? FALSE : TRUE;
	}

	function cyrillic($str)//������ ������� �������
	{
		return ( ! preg_match("/^([�-��-�\�])+$/i", $str)) ? FALSE : TRUE;
	}

	function skype($str)//����� ��������� ��������� �������, �����, ���� ������������� � �����.
	{
		return ( ! preg_match("/^[a-zA-z0-9_\-]+$/", $str)) ? FALSE : TRUE;
	}

	function telephone($str)//����� ��������� ��������� �������, �����, ���� ������������� � �����.
	{
		return ( ! preg_match("/^[0-9\-\(\)\+]+$/", $str)) ? FALSE : TRUE;
	}

	function wmz($str)
	{
		return ( ! preg_match("/^([z])+[0-9]{12}$/ix", $str)) ? FALSE : TRUE;
	}

	function wmr($str)
	{
		return ( ! preg_match("/^([r])+[0-9]{12}$/ix", $str)) ? FALSE : TRUE;
	}
}
