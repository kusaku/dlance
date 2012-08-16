<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories_mdl extends Model
{
/**
* ---------------------------------------------------------------
*  Каталог, и есть услуги пользователей
* ---------------------------------------------------------------
*/
	function get($id)
	{
		$this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('categories')->row_array();
	}

	function get_categories()//Для списков и вывода услуг в аккаунта - services
	{
		$this->db->select('id, name, parent_id');

		return $this->db->get('categories')->result_array();
	}

/*	
        $query = "SELECT ci_categories.name, ci_categories.id, ci_categories.parent_id, COUNT(ci_services.id) AS number".
                    " FROM ci_categories LEFT JOIN ci_services ON ci_categories.id = ci_services.category".
                    " GROUP BY ci_categories.id";

        $query = $this->db->query($query);

		if( $query->num_rows() == 0 )
		{
			return false;
		}
		else
		{
			return $query->result_array();
		}
    }

*/
	function get_categories_for_users()//Категории с колличеством пользователей предоставляющих данную услугу
	{
		$this->db->select('categories.name, categories.id, categories.parent_id, COUNT(ci_services.id) AS number');

		$this->db->join('services', 'categories.id = services.category', 'LEFT');

		$this->db->group_by('categories.id');

		return $this->db->get('categories')->result_array();
	}

	function name($id)
	{
		$this->db->select('name');
		$query = $this->db->get_where('categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->name;
		}

		return FALSE;
	}

	function title($id)
	{
		$this->db->select('title');

		$query = $this->db->get_where('categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->title;
		}

		return FALSE;
	}

	function descr($id)//Описание
	{
		$this->db->select('descr');

		$query = $this->db->get_where('categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->descr;
		}

		return FALSE;
	}

	function users_descr($id)//Описание для пользователей каталога
	{
		$this->db->select('users_descr');

		$query = $this->db->get_where('categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->users_descr;
		}

		return FALSE;
	}

	function cat_array($id)
	{
		$this->db->select('parent_id');
		$query = $this->db->get_where('categories', array('id '=> $id));


		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			$parent_id = $row->parent_id;
		}
		else
		{
			return FALSE;
		}

		if( $parent_id != 0 )//Если выбранная категория не является разделом - выводим проекты только с одной субкатегории
		{
			$array = array($id);
			
			return $array;
		}

		$this->db->select('id');

		$this->db->where('parent_id', $id);//Выводим все подразделы главного раздела

		$array = $this->db->get('categories')->result_array();

		$a = '';
		foreach($array as $row):
			$a .= $row['id'];
			$a .= ', ';
		endforeach;

		$a = trim($a);;

		$a = substr($a, 0, -1);

		$array = explode(", ", $a);;

		return $array;
	}

	function category_check($id = '')
	{
	    if( empty($id) )
	    {
			return FALSE;
	    }

		$this->db->where('id', $id);

		if( $this->db->count_all_results('categories') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}

}