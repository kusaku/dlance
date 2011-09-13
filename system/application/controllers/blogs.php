<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blogs extends Controller
{
	public $user_id;

	public $username;

	public $userpic;

	public $team;

	function __construct()
	{
		parent::Controller();
		$this->load->model('blogs/blogs_mdl');
		$this->load->helper('text');
		$this->load->helper('tinymce');
		if( $this->users_mdl->logged_in() )
		{
			$this->user_id = $this->session->userdata('id');
	
			$user = $this->users_mdl->get_user_by_id($this->user_id);

			$this->username = $user->username;

			$this->userpic = $user->userpic;

			$this->team = $user->team;
		}
	}
/*
|---------------------------------------------------------------
| Блоги
|---------------------------------------------------------------
*/
    function index($start_page = 0)  
	{
		parse_str($_SERVER['QUERY_STRING'], $_GET);

		$per_page = 10;

		$start_page = intval($start_page);

		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$category = '';

		$input = array();

		$title = 'Блоги';

		if( !empty($_GET['category']) )
		{
			$category = $_GET['category'];

			if( !$this->_category_check($category) )
			{
				$category = 1;
			}

			$title = $this->blogs_mdl->name($category).' | '.$title;//Выводим заголовок категории

			$input['category'] = $category;

			$url['category'] = 'category='.$_GET['category'];
		}

		$this->load->library('pagination');

		$config['base_url'] = base_url().'/blogs/index/';
		$config['total_rows'] = $this->blogs_mdl->count_all($input);
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		if( !empty($url) ) 
		{
			$url = implode ("&", $url);
			$data['page_links'] = str_replace( '">', '/?'.$url.'">',$data['page_links']);
		}

		$data['blogs'] = $this->blogs_mdl->get_all($start_page, $per_page, $input);


		/**
		* Блок
		*/
		$data['categories'] = $this->blogs_mdl->get_categories();//категории

		$this->template->build('blogs/index', $data, $title);
    }
/*
|---------------------------------------------------------------
| Просмотр
|---------------------------------------------------------------
*/
    function view($id = '') 
	{
		if( !$data = $this->blogs_mdl->get($id) )
		{
			show_404('page');
		}

		$this->load->helper('smiley');//Смайлы
		$this->load->library('table');//Создание таблиц

		$data['check'] = $this->_check($id, $data['user_id']);//Проверка

		$data['category_id'] = $data['category'];

		$data['category'] = $this->blogs_mdl->name($data['category']);

		$data['date'] = date_smart($data['date']);

		$data['username']= $this->users_mdl->get_username($data['user_id']);

		//Комментарии
		if( $this->input->post('newcomment') and $this->users_mdl->logged_in() )
		{
			$rules = array 
			(
				array (
					'field' => 'text', 
					'label' => 'Текст',
					'rules' => 'required|max_length[10000]'
				)
			);

			$commentdata = array (
				'date' => now(),
				'blog_id' => $id,
				'user_id' => $this->user_id,
				'text' => $this->input->post('text')
			);
	
			$this->form_validation->set_rules($rules);

			if( $this->form_validation->run() ) 
			{
				$this->blogs_mdl->add_comment($commentdata);

				redirect('blogs/'.$id.'.html');
			}
		}

		$comments['data'] = $this->blogs_mdl->get_comments($id);


		//Смайлы
		$image_array = get_clickable_smileys('/img/smileys/');

		$col_array = $this->table->make_columns($image_array, 20);		
			
		$comments['smiley'] = $this->table->generate($col_array);



		$data['comments'] = $this->load->view('wdesigns/blogs/comments', $comments, TRUE);


		/**
		* Блок
		*/
		$data['categories'] = $this->blogs_mdl->get_categories();//категории





		$this->template->build('blogs/view', $data, $title = ''.$data['title'].' | Блоги');
	}
/*
|---------------------------------------------------------------
| Удаление
|---------------------------------------------------------------
*/
    function del($id = '') 
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if(  !$this->_check_action($id) )
		{
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}

		$this->blogs_mdl->del($id);

		redirect('account/blogs');
	}
/*
|---------------------------------------------------------------
| Добавление
|---------------------------------------------------------------
*/
    function add() 
	{
		if( !$this->errors->access() )
		{
			return;
		}
	
		$rules = array 
		(
			array (
				'field' => 'title', 
				'label' => 'Заголовок',
				'rules' => 'required|text|max_length[64]'
			),
			array (
				'field' => 'text', 
				'label' => 'Текст',
				'rules' => 'required|max_length[10000]'
			),
			array (
				'field' => 'category_id', 
				'label' => 'Категория',
				'rules' => 'required'
			)
		);

		$data = array (
			'date' => now(),
			'title' => $this->input->post('title'),
			'user_id' => $this->user_id,
			'text' => htmlspecialchars($this->input->post('text')),
			'descr' => character_limiter($this->input->post('text'), 255),
			'category' => $this->input->post('category_id')
		);

		$this->form_validation->set_rules($rules);

		if( $this->form_validation->run() ) 
		{
			$this->blogs_mdl->add($data);

			redirect('blogs/');
		}

		$data['categories'] = $this->blogs_mdl->get_categories();

		$this->template->build('blogs/add', $data, $title = 'Добавить запись');
	}
/*
|---------------------------------------------------------------
| Редактирование
|---------------------------------------------------------------
*/
    function edit($id) 
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$data = $this->blogs_mdl->get($id) )
		{
			show_404('page');
		}

		$data['check'] = $this->_check($id, $data['user_id']);

		if(  !$data['check'] )
		{
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}

		$rules = array 
		(
			array (
				'field' => 'title', 
				'label' => 'Заголовок',
				'rules' => 'required|text|max_length[64]'
			),
			array (
				'field' => 'text', 
				'label' => 'Текст',
				'rules' => 'required|max_length[10000]'
			),
			array (
				'field' => 'category_id', 
				'label' => 'Категория',
				'rules' => 'required'
			)
		);

		$blogdata = array (
			'title' => $this->input->post('title'),
			'text' => htmlspecialchars($this->input->post('text')),
			'descr' => character_limiter($this->input->post('text'), 255),
			'category' => $this->input->post('category_id')
		);

		$this->form_validation->set_rules($rules);

		if( $this->form_validation->run() ) 
		{
			$this->blogs_mdl->edit($id, $blogdata);

			redirect('blogs/'.$id.'.html');
		}

		$data['categories'] = $this->blogs_mdl->get_categories();

		$this->template->build('blogs/edit', $data, $title = 'Редактировать запись');
	}
/*
|---------------------------------------------------------------
| Функции, проверки
|---------------------------------------------------------------
*/
    function _check_action($id = '') 
	{
		if( $this->blogs_mdl->check($id, $this->user_id) )//Если найдена запись и она принадлежит пользователю
		{
			return TRUE;
		}
		
		return FALSE;
	}

	function _check($id = '', $user_id = '')//Проверка редактирования модератором, $id - ид блога, $user_id пользователь чей блог
	{
		$userdata = $this->users_mdl->get_user($user_id);

		if( $userdata['team'] == 2 )//Если блог модератора
		{
			if(  !$this->_check_action($id) )
			{
				return FALSE;
			}
		}
		else//Блог обычного пользователя (может редактировать модератор)
		{

			if( $this->team != 2 )//ЕСЛИ НЕ МОДЕРАТОР, проверяем
			{
				if(  !$this->_check_action($id) )
				{
					return FALSE;
				}
			}

		}
		
		return TRUE;
	}

	function _category_check($category)
	{
	    if( $this->blogs_mdl->category_check($category) )
	    {
			return TRUE;
	    }
	    else
	    {
	        return FALSE;
	    }
	}






/*
|---------------------------------------------------------------
| МОДЕРАТОР
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| Редактирование комментария
|---------------------------------------------------------------
*/
    function comments_edit($id) 
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$data = $this->blogs_mdl->get_comment($id) )
		{
			show_404('page');
		}

		if(  !$this->_check_comment($id, $data['user_id']) )
		{
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}

		$rules = array 
		(
			array (
				'field' => 'text', 
				'label' => 'Текст',
				'rules' => 'required|max_length[10000]'
			)
		);

		$commentdata = array (
			'text' => htmlspecialchars($this->input->post('text'))
		);

		$this->form_validation->set_rules($rules);

		if( $this->form_validation->run() ) 
		{
			$this->blogs_mdl->edit_comment($id, $commentdata);

			redirect('blogs/'.$data['blog_id'].'.html');
		}

		$this->template->build('blogs/comments_edit', $data, $title = 'Редактировать комментарий');
	}

    function comments_del($id = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$data = $this->blogs_mdl->get_comment($id) )
		{
			show_404('page');
		}

		if(  !$this->_check_comment($id, $data['user_id']) )
		{
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}

		$this->blogs_mdl->del_comment($id);

		redirect('blogs/'.$data['blog_id'].'.html');
	}

	function _check_comment($id = '', $user_id = '')//Проверка редактирования модератором, $id - ид блога, $user_id пользователь чей блог
	{
		$userdata = $this->users_mdl->get_user($user_id);

		if( $userdata['team'] == 2 )//Если коммент модератора
		{
			if(  !$this->_check_action_comment($id) )
			{
				return FALSE;
			}
		}
		else//коммент обычного пользователя (может редактировать модератор)
		{

			if( $this->team != 2 )//ЕСЛИ НЕ МОДЕРАТОР, проверяем
			{
				if(  !$this->_check_action_comment($id) )
				{
					return FALSE;
				}
			}

		}
		
		return TRUE;
	}

    function _check_action_comment($id = '') 
	{
		if( $this->blogs_mdl->check_comment($id, $this->user_id) )//Если найдена запись и она принадлежит пользователю
		{
			return TRUE;
		}
		
		return FALSE;
	}
}