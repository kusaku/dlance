<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class Pages extends Controller {

	function __construct() {
		parent::Controller();
		$this->load->model('pages/pages_mdl');
	}

	function view($id = '') {
		if (!$data = $this->pages_mdl->get($id)) {
			show_404('page');
		}
		
		$this->template->build('pages/view', $data, $title = $data['title']);
	}
}
