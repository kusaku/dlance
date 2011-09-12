<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class News extends Controller
{

	function __construct()
	{
		parent::Controller();
		$this->load->model('news/news_mdl');
	}

	function index($start_page = 0)
	{
		parse_str($_SERVER['QUERY_STRING'],$_GET);

		$per_page = 10;

		$start_page = intval($start_page);
		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$this->load->library('pagination');

		$config['base_url'] = base_url().'/news/index/';
		$config['total_rows'] = $this->news_mdl->count_all();
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		$data['news'] = $this->news_mdl->get_all($start_page, $per_page);



		/**
		 * ����
		 */
		$data['newest_news'] = $this->news_mdl->get_newest(10);


		$this->template->build('news/index', $data, $title = '������� �������');
	}

	function view($id = '')
	{
		if( !$data = $this->news_mdl->get($id) )
		{
			show_404('page');
		}

		$data['date']= date_smart($data['date']);


		/**
		 * ����
		 */
		$data['newest_news'] = $this->news_mdl->get_newest(10);

		$this->template->build('news/view', $data, $title = ''.$data['title'].' | ������� �������');
	}
}