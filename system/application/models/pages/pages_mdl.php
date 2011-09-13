<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_mdl extends Model
{
	function get($name)
	{
	    $this->db->where('name', $name);

		$this->db->select('*');

		return $this->db->get('pages')->row_array();
	}
}