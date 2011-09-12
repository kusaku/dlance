<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events
{
	function __construct()
	{
		$this->_ci =& get_instance();
	}

	function create($user_id, $title, $value = '', $multiple = FALSE)
	{
		if( !empty($value) )
		{
			$rating = $this->_ci->rating->value($value);

			if( !empty($multiple) )//��� �������
			{
				$rating = $rating * $multiple;

				$rating = floor($rating);//���������� ������������ ����� �����
			}

			if( $rating > 0 )
			{
				$title = $title.", ���� ��������� ��������� �� ".$rating;
			}
			elseif( $rating < 0 )
			{
				$title = $title.", ���� ��������� ��������� �� ".$rating;
			}

			$this->_ci->rating->plus($user_id, $rating);
		}

		$this->_ci->load->model('events/events_mdl');

		$data = array (
			'user_id' => $user_id,
			'date' => now(),
			'title' => $title,
			'status' => 1
		);

		$this->_ci->events_mdl->add($data);
	}

	function del($user_id, $date)
	{
		$this->_ci->db->where('user_id', $user_id);

		$this->_ci->db->where('date', $date);

		$this->_ci->db->delete('events');
	}

	function get($user_id)
	{
		$this->_ci->load->model('events/events_mdl');

		return $this->_ci->events_mdl->get($user_id);
	}
}