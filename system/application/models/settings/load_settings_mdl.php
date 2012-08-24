<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Load_settings_mdl extends Model
{	 
	function __construct()
	{
		parent::Model();
		$this->load_config();
	}

	function load_config()
	{
		$query = $this->db->get('settings');
		
		$sets = $query->result();
		
		foreach($sets as $row) 
		{
			$val = $row->value;
			if( is_numeric($val) ) 
			{
				//Преобразование в числовой тип
				$val = $val + 0;
			}
			//Сохранение конфигурационных данных 
			$this->config->set_item($row->param, $val);
		}
	}
}