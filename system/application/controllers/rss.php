<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class Rss extends Controller {
	public $adult = 0;

	function __construct() {
		parent::Controller();
		$this->load->model('designs/designs_mdl');
		$this->load->helper('xml');
	}

	function designs() {
		$data['encoding'] = 'UTF-8';
		$data['feed_name'] = 'Дизайны сайтов | Dlance.ru';
		$data['feed_url'] = 'http://www.dlance.ru';
		$data['page_description'] = 'Дизайны сайтов на сервисе Dlance.ru';
		$data['page_language'] = 'ru-ru';
		$data['posts'] = $this->designs_mdl->get_designs(array('limit'=>50, 'offset'=>0));
		
		header("Content-Type: application/rss+xml");
		
		$this->load->view('rss', $data);
	}
	
}
