<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_mdl extends Model
{
	function get($id)//Полный вывод
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('news')->row_array();
	}

	function get_news()//Вывод
	{
		$this->db->select('*');

		$query = $this->db->get('news')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);//Дата размещения
		}

		return $query;
	}

	function get_all($start_from = FALSE, $per_page)//Страницы
	{
		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

    	$this->db->order_by('date', 'desc');

		return $this->get_news();
	}

	function count_all()
	{
		return $this->db->count_all_results('news'); 
	}

	function get_newest($limit = 10)
  	{
    	$this->db->order_by('date', 'desc');
    	$this->db->limit($limit);

    	return $this->get_news();
  	}
}