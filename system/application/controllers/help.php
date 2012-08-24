<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class Help extends Controller {

	function __construct() {
		parent::Controller();
		$this->load->model('help/help_mdl');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод всех категорий/страниц
	 * ---------------------------------------------------------------
	 */

	function index() {
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$title = 'Помощь';
		
		$category = '';
		
		if (! empty($_GET['category'])) {
			$category = $_GET['category'];
			
			if (!$this->_category_check($category)) {
				$category = 1;
			}
			
			$title = $this->help_mdl->name($category).' | '.$title;
		}
		
		$data['help_categories'] = $this->help_mdl->get_categories($category);
		
		$data['help_pages'] = $this->help_mdl->get_pages();
		
		/**
		 * Блок
		 */
		$data['categories'] = $this->help_mdl->get_categories();
		
		$this->template->build('help/index', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Полный вывод
	 * ---------------------------------------------------------------
	 */

	function view($id = '') {
		if (!$data = $this->help_mdl->get($id)) {
			show_404('page');
		}
		
		/**
		 * Блок
		 */
		$data['categories'] = $this->help_mdl->get_categories();
		
		$this->template->build('help/view', $data, $title = ''.$data['title'].' | Помощь');
	}

	function _category_check($category) {
		if (!$this->help_mdl->category_check($category)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
