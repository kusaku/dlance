<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rating_mdl extends Model
{
	//Вывод рейтинга пользователя
	function value($param)
	{
		$this->db->select('value');
		$query = $this->db->get_where('rating', array('param '=> $param));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->value;
		}

		return FALSE;
	}

	//Вывод рейтинга пользователя
	function get($user_id)
	{
		$this->db->select('rating');
		$query = $this->db->get_where('users', array('id '=> $user_id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->rating;
		}

		return FALSE;
	}

	function plus($user_id, $sum)
	{
		$this->db->select('rating');

		$query = $this->db->get_where('users', array('id' => $user_id));

		$query = $query->row_array();

		$rating = $query['rating'] + $sum;

	//Обновляем
		$this->db->update('users', array('rating' => $rating), array('id' => $user_id));
	}

	function minus($user_id, $sum)
	{
		$this->db->select('rating');

		$query = $this->db->get_where('users', array('id' => $user_id));

		$query = $query->row_array();

		$rating = $query['rating'] - $sum;

	//Обновляем
		$this->db->update('users', array('rating' => $rating), array('id' => $user_id));
	}
}