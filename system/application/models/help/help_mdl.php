<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Help_mdl extends Model
{
	function get($id)
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('help_pages')->row_array();
	}

	function name($id)
	{
		$this->db->select('name');

		$query = $this->db->get_where('help_categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->name;
		}

		return FALSE;
	}

	function get_categories($id = '')
	{
		if( !empty($id) )
		{
			$this->db->where('id', $id);
		}

		$this->db->select('*');

		return $this->db->get('help_categories')->result_array();
	}

	function get_pages()
	{
		$this->db->select('*');

		return $this->db->get('help_pages')->result_array();
	}

	function category_check($category)
	{
		$this->db->where('id', $category);

		if( $this->db->count_all_results('help_categories') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}

	function count_pages($category)
	{
		$this->db->where('category', $category);

		return $this->db->count_all_results('help_pages'); 
	}
}