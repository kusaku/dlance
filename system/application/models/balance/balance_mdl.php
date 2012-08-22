<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Balance_mdl extends Model
{
	//Вывод баланса пользователя
	function get($user_id)
	{
		$this->db->select('balance');
		$query = $this->db->get_where('users', array('id '=> $user_id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->balance;
		}

		return FALSE;
	}

	function plus($user_id, $sum)
	{
		$this->db->select('balance');

		$query = $this->db->get_where('users', array('id' => $user_id));

		$query = $query->row_array();

		$balance = $query['balance'] + $sum;

	//Обновляем
		$this->db->update('users', array('balance' => $balance), array('id' => $user_id));

		$this->events->create($user_id, 'Увеличение баланса', 'plus_balance', $sum);
	}

	function minus($user_id, $sum)
	{
		$this->db->select('balance');

		$query = $this->db->get_where('users', array('id' => $user_id));

		$query = $query->row_array();

		$balance = $query['balance'] - $sum;

	//Обновляем
		$this->db->update('users', array('balance' => $balance), array('id' => $user_id));

		$this->events->create($user_id, 'Уменьшение баланса', 'minus_balance', $sum);
	}
}