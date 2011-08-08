<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tariff_mdl extends Model
{
	function value($id, $param)//Вывод значения тарифа
	{
		$this->db->select($param);

		$query = $this->db->get_where('tariffs', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->$param;
		}

		return FALSE;
	}

	function get($user_id)//Вывод тарифа пользователя
	{
		$this->db->select('tariffs.name');

		$this->db->join('tariffs', 'tariffs.id = users.tariff');

		$query = $this->db->get_where('users', array('users.id '=> $user_id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->name;
		}

		return FALSE;
	}

	function id($user_id)//Вывод тарифа пользователя
	{
		$this->db->select('tariff');

		$query = $this->db->get_where('users', array('id '=> $user_id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->tariff;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| Смена тарифа
|---------------------------------------------------------------
*/
	function update($user_id, $data)
	{
		$this->db->update('users', $data, array('id' => $user_id));
	}
/*
|---------------------------------------------------------------
| Вывод всех данных тарифа
|---------------------------------------------------------------
*/
	function get_tariff($id)
	{
		$this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('tariffs')->row_array();
	}
/*
|---------------------------------------------------------------
| Период
|---------------------------------------------------------------
*/
	function period($user_id)
	{
		$this->db->select('tariff_period');

		$query = $this->db->get_where('users', array('id '=> $user_id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->tariff_period;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| Вывод всех тарифов
|---------------------------------------------------------------
*/
	function get_all()
	{
		$this->db->select('*');

		return $this->db->get('tariffs')->result_array();
	}
}