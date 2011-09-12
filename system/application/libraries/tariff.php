<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tariff
{
	function __construct()
	{
		$this->_ci =& get_instance();
	}

	function value($id, $param)
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->value($id, $param);
	}

	function get($user_id)
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->get($user_id);
	}

	function id($user_id)
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->id($user_id);
	}

	function get_tariff($id)
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->get_tariff($id);
	}

	function period($user_id)
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->period($user_id);
	}

	function get_all()
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->get_all();
	}

	function update($user_id, $data)
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->update($user_id, $data);
	}

	function config($id)//�������� �������� �� ������, ��������
	{
		$this->_ci->load->model('tariff/tariff_mdl');

		return $this->_ci->tariff_mdl->update($user_id, $data);
	}
}