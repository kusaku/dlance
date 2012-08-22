<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events_mdl extends Model
{
	function add($data)
	{
		$this->db->insert('events', $data);
	}

	//Вывод новых событий пользователя
	function get($user_id = '', $status = '')
	{
		$this->db->order_by('date', 'desc');

		$this->db->select('*');

		$this->db->where('status', 1);

		$this->db->where('user_id', $user_id);

		return $this->db->get('events')->result_array();
	}

	//Вывод событий пользователя
	function get_all($start_from = FALSE, $per_page, $user_id = '', $status = '')
	{
		$this->db->order_by('date', 'desc');

		$this->db->select('*');

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		if( !empty($status) )
		{
			$this->db->where('status', $status);
		}

		$this->db->where('user_id', $user_id);

		$query = $this->db->get('events')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);
		}
		
		return $query;
	}

	function count_all($user_id = '', $status = '') 
	{
		if( !empty($status) )
		{
			$this->db->where('status', $status);
		}

		$this->db->where('user_id', $user_id);

		return $this->db->count_all_results('events'); 
	}

	//Новые события у пользователя для вывода на главной
	function count_new_events($user_id = '')
	{
		$this->db->where('user_id', $user_id);

		$this->db->where('status', 1);

		return $this->db->count_all_results('events'); 
	}

	function update($id)
	{
		$this->db->where('id', $id);

		$this->db->update('events', array('status' => 2));
	}
}