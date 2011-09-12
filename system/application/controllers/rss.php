<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rss extends Controller
{
	public $adult = 0;
	function __construct()
	{
		parent::Controller();
		$this->load->model('designs/designs_mdl');
		$this->load->helper('xml');
	}

	function designs()
	{
		$data['encoding'] = 'windows-1251';

		$data['feed_name'] = '������� ������ | Dlance.ru';

		$data['feed_url'] = 'http://www.dlance.ru';

		$data['page_description'] = '������� ������ �� ������� Dlance.ru';

		$data['page_language'] = 'ru-ru';

		$data['posts'] = $this->designs_mdl->get_designs(0, 50);

		header("Content-Type: application/rss+xml");

		$this->load->view('rss', $data);
	}

}
