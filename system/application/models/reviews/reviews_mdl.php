<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reviews_mdl extends Model
{
/*
|---------------------------------------------------------------
| Для редактирования
|---------------------------------------------------------------
*/
	function get($id)
	{
		$this->db->select('*');

	    $this->db->where('id', $id);

		return $this->db->get('reviews')->row_array();
	}

	function edit($id, $data) 
	{
	    $this->db->where('id', $id);

		$this->db->update('reviews', $data);
	}

	function del($id) 
	{
	    $this->db->where('id', $id);

		$this->db->delete('reviews');
	}
/*
|---------------------------------------------------------------
| Вывод
|---------------------------------------------------------------
*/
	function get_reviews($start_from = FALSE, $per_page, $user_id, $type = '')//Выводим все отзывы пользователя
	{
		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('date', 'desc');

		$this->db->select('reviews.*, users.username, users.userpic, users.created, users.last_login, users.surname, users.name');

		if( $type )
		{
			if( $type == 'positive' ) $this->db->where('reviews.rating', 1);
			
			if( $type == 'negative' ) $this->db->where('reviews.rating', -1);
		}

		$this->db->from('reviews');

	    $this->db->where('reviews.user_id', $user_id);

		$this->db->join('users', 'users.id = reviews.from_id');

		$query = $this->db->get()->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);
	
			$query[$i]['created'] = date_smart($query[$i]['created']);

			$query[$i]['last_login'] = date_smart($query[$i]['last_login']);
			
			if( !empty($query[$i]['moder_date']) )
			{
				$query[$i]['moder_date'] = date_smart($query[$i]['moder_date']);

				$query[$i]['moder_user_id'] = $this->users_mdl->get_username($query[$i]['moder_user_id']);
			}
		}
		
		return $query;
	}

	function count_reviews($user_id = '', $type)//Все отзывы пользователя
	{
		if( $type )
		{
			if( $type == 'positive' ) $this->db->where('reviews.rating', 1);
			
			if( $type == 'negative' ) $this->db->where('reviews.rating', -1);
		}

		$this->db->where('user_id', $user_id);

		return $this->db->count_all_results('reviews'); 
	}

	function count_reviews_positive($user_id = '')//Все положительные отзывы пользователя
	{
		$this->db->where('rating', 1);

		$this->db->where('user_id', $user_id);

		return $this->db->count_all_results('reviews'); 
	}

	function count_reviews_negative($user_id = '')//Все отрицательные отзывы пользователя
	{
		$this->db->where('rating', -1);

		$this->db->where('user_id', $user_id);

		return $this->db->count_all_results('reviews'); 
	}

	function add($data)
	{
		$this->db->insert('reviews', $data);
	}

	function check($user_id = '', $from_id = '')//Проверка отзыва по пользователю
	{
		$this->db->where('user_id', $user_id);

		$this->db->where('from_id', $from_id);

		if( $this->db->count_all_results('reviews') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}

	function last_date($user_id = '')//Дата последнего добавления отзыва пользователем
	{
		$this->db->select_max('date');

		$query = $this->db->get_where('reviews', array('from_id' => $user_id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->date;
		}

		return FALSE;
	}
}