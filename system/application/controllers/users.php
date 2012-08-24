<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class Users extends Controller {
	public $user_id;
	
	public $username;
	
	public $userpic;
	
	public $adult;
	
	public $team;

	function __construct() {
		parent::Controller();
		$this->load->library('pagination');
		$this->load->model('categories/categories_mdl');
		$this->load->model('reviews/reviews_mdl');
		$this->load->model('designs/designs_mdl');
		$this->load->model('account/account_mdl');
		$this->load->helper('highslide');
		if ($this->users_mdl->logged_in()) {
			$this->user_id = $this->session->userdata('id');
			
			$user = $this->users_mdl->get_user_by_id($this->user_id);
			$this->username = $user->username;
			$this->userpic = $user->userpic;
			$this->team = $user->team;
			$this->adult = $this->settings->value($this->user_id, 'adult');
		} else {
			$this->adult = 0;
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Обратная связь
	 * ---------------------------------------------------------------
	 */

	function _email_support($data) {
		//Админу
		$email = $this->config->item('email');
		$subject = $data['subject'];
		
		if ( empty($email)) {
			return FALSE;
		}
		
		switch ($subject) {
			case 0:
				$subject = 'Вопрос по работе системы';
				break;
			case 1:
				$subject = 'Предложение сотрудничества';
				break;
			case 2:
				$subject = 'Сообщение об ошибке';
				break;
			case 3:
				$subject = 'Размещение рекламы на dlance.ru';
				break;
		}
		
		$message = $this->load->view('emails/support', $data, TRUE);
		
		$this->common->email($email, $subject, $message);
	}

	function support() {
		$this->load->helper('string');
		$this->load->plugin('captcha');
		
		$rules = array(
			array(
				'field'=>'subject','label'=>'Тема','rules'=>'required'
			),array(
				'field'=>'email','label'=>'Email','rules'=>'required|valid_email'
			),array(
				'field'=>'message','label'=>'Сообщение','rules'=>'required'
			),array(
				'field'=>'code','label'=>'Код','rules'=>'required|callback__captcha_check'
			)
		);
		
		$data = array(
			'email'=>$this->input->post('email'),'subject'=>$this->input->post('subject'),
				'message'=>$this->input->post('message')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->_email_support($data);
			
			show_error('Ваше сообщение было успешно отправлено!');
		} else {
			$rnd_str = random_string('numeric', 6);
			
			//Записываем строку в сессии
			$ses_data = array(
			);
			$ses_data['captcha_rnd_str'] = $rnd_str;
			
			$this->session->set_userdata($ses_data);
			
			//Форумируем картинку
			$vals = array(
				'word'=>$rnd_str,'img_path'=>'./img/captcha/','img_url'=>base_url().'img/captcha/',
					'font_path'=>'./system/fonts/texb.tff','img_width'=>120,'img_height'=>30,
					'expiration'=>10
			);
			
			$cap = create_captcha($vals);
			
			$data['imgcode'] = $cap['image'];
			
			$this->template->build('users/support', $data, $title = 'Обратная связь');
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Авторизация
	 * ---------------------------------------------------------------
	 */

	function fast_register_check() {
		$rules = array(
			array(
				'field'=>'username','label'=>'Имя пользователя','rules'=>'required|alpha_numeric|min_length[3]|max_length[15]|callback__username_check'
			),array(
				'field'=>'email','label'=>'Email','rules'=>'required|valid_email|max_length[48]|callback__email_check'
			)
		);
		
		$data = array(
			'username'=>$this->input->post('username'),'email'=>strtolower($this->input->post('email')),
				'password'=>random_string('alnum', 6)
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$res['status'] = "OK";
			
			$code = $this->users_mdl->fast_register($data['username'], $data['email'], $data['password']);
			
			$res['username'] = $data['username'];
			
			$res['email'] = $data['email'];
			
			$res['password'] = $data['password'];
			
			$res['code'] = $code;
		} else {
			$res['username_err'] = iconv('windows-1251', 'UTF-8', form_error('username'));
			
			$res['email_err'] = iconv('windows-1251', 'UTF-8', form_error('email'));
		}
		
		echo json_encode($res);
	}

	function fast_register() {
		//Контент
		$this->load->view('wdesigns/users/fast_register', $data = '');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Авторизация
	 * ---------------------------------------------------------------
	 */

	function login() {
		$rules = array(
			array(
				'field'=>'username','label'=>'Логин','rules'=>'required|trim|callback__login_check'
			),array(
				'field'=>'password','label'=>'Пароль','rules'=>'required|trim'
			)
		);
		
		$data = array(
			'username'=>$this->input->post('username'),'password'=>$this->input->post('password')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run() or $this->users_mdl->logged_in()) {
			if (!$this->_last_auth()) {
				$this->events->create($this->session->userdata('id'), 'Авторизация в системе', 'auth');#Событие с повышением репутации
			}
			
			redirect('/account');
		} else {
			$this->template->build('users/login', $data, $title = 'Авторизация пользователя');
		}
		
	}

	function _last_auth() {
		if ($last_auth = $this->users_mdl->get_last_auth($this->session->userdata('id'))) {
			$month = date('m');
			
			$day = date('d');
			
			$year = date('Y');
			
			$date_start = mktime(0, 0, 0, $month, $day, $year);
			
			$date_end = mktime(23, 59, 59, $month, $day, $year);
			
			if ($last_auth > $date_start and $last_auth < $date_end) {
				return TRUE;
			}
			
			return FALSE;
			
		}
		
		return FALSE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Выход
	 * ---------------------------------------------------------------
	 */

	function logout() {
		$this->users_mdl->logout();
		
		redirect('');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Регистрация
	 * ---------------------------------------------------------------
	 */

	function register() {
		//Если пользователь зарегистрирован кидаем на главную
		if ($this->users_mdl->logged_in()) {
			redirect('');
		}
		
		$this->load->helper('string');
		$this->load->plugin('captcha');
		
		$rules = array(
			array(
				'field'=>'username','label'=>'Имя пользователя','rules'=>'required|alpha_numeric|min_length[3]|max_length[15]|callback__username_check'
			),array(
				'field'=>'email','label'=>'Email','rules'=>'required|valid_email|max_length[48]|callback__email_check'
			),array(
				'field'=>'password1','label'=>'Пароль','rules'=>'required|min_length[6]|max_length[24]|matches[password2]'
			),array(
				'field'=>'password2','label'=>'Повтор пароля','rules'=>'required'
			),array(
				'field'=>'surname','label'=>'Фамилия','rules'=>'required|cyrillic|max_length[24]'
			),array(
				'field'=>'name','label'=>'Имя','rules'=>'required|cyrillic|max_length[24]'
			),array(
				'field'=>'sex','label'=>'Пол','rules'=>'required'
			),array(
				'field'=>'country_id','label'=>'Страна','rules'=>'required'
			),array(
				'field'=>'city_id','label'=>'Город','rules'=>'required'
			),array(
				'field'=>'dob_day','label'=>'День рождения','rules'=>'required'
			),array(
				'field'=>'dob_month','label'=>'Месяц рождения','rules'=>'required'
			),array(
				'field'=>'dob_year','label'=>'Год рождения','rules'=>'required'
			),array(
				'field'=>'code','label'=>'Код','rules'=>'required|callback__captcha_check'
			),array(
				'field'=>'agree','label'=>'Пользовательское соглашение','rules'=>'callback__agree_check'
			)
		);
		
		$data = array(
			'username'=>$this->input->post('username'),'email'=>strtolower($this->input->post('email')),
				'password'=>$this->input->post('password1'),'surname'=>ucwords(strtolower($this->input->post('surname'))),
				'name'=>ucwords(strtolower($this->input->post('name'))),'sex'=>$this->input->post('sex'),
				'day'=>$this->input->post('dob_day'),'month'=>$this->input->post('dob_month'),
				'year'=>$this->input->post('dob_year'),'country_id'=>$this->input->post('country_id'),
				'city_id'=>$this->input->post('city_id')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->users_mdl->register($data['username'], $data['email'], $data['password'], $data['surname'], $data['name'], $data['sex'], $data['country_id'], $data['city_id'], $data['day'], $data['month'], $data['year']);
			
			show_error('Регистрация успешно завершена, на указанный email был выслан код для активации аккаунта');
		} else {
			$rnd_str = random_string('numeric', 6);
			
			//Записываем строку в сессии
			$ses_data = array(
			);
			$ses_data['captcha_rnd_str'] = $rnd_str;
			
			$this->session->set_userdata($ses_data);
			
			//Форумируем картинку
			$vals = array(
				'word'=>$rnd_str,'img_path'=>'./img/captcha/','img_url'=>base_url().'img/captcha/',
					'font_path'=>'./system/fonts/texb.tff','img_width'=>120,'img_height'=>30,
					'expiration'=>10
			);
			
			$cap = create_captcha($vals);
			
			$data['imgcode'] = $cap['image'];
			
			$this->template->build('users/register', $data, $title = 'Регистрация');
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Список пользователей
	 * ---------------------------------------------------------------
	 */

	function all($start_page = 0) {
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$category_array = '';
		
		$input = array(
		);
		
		$url = '';
		
		$title = 'Все дизайнеры';
		
		if (! empty($_GET['category'])) {
			$category = $_GET['category'];
			
			if (!$this->_category_check($category)) {
				$category = 1;
			}
			
			$data['category'] = $category;
			
			//Описание пользователей
			$data['users_descr'] = $this->categories_mdl->users_descr($category);
			
			//Выводим Заголовок категории
			$title = $this->categories_mdl->title($category).' | '.$title;
			
			$data['title'] = $this->categories_mdl->title($category);
			
			$category_array = $this->categories_mdl->cat_array($category);
			
			$input['category_array'] = $this->categories_mdl->cat_array($category);
			
			$url['category'] = 'category='.$category;
		}
		
		//Для прикрепления к ссылке сортировки
		$data['url'] = $url;
		
		//Сортировка
		if (! empty($_GET['order_field'])) {
			$order_field = $_GET['order_field'];
			
			if ($order_field == 'rating') {
				$input['order_field'] = $_GET['order_field'];
				$url['order_field'] = 'order_field='.$_GET['order_field'];
			}
		}
		
		//Тип сортировки
		if (! empty($_GET['order_type'])) {
			$input['order_type'] = $_GET['order_type'];
			$url['order_type'] = 'order_type='.$_GET['order_type'];
		} else {
			$input['order_type'] = 'desc';
		}
		
		$config['base_url'] = base_url().'/users/all/';
		$config['total_rows'] = $this->users_mdl->count_all($input);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		//Вывод
		$data['data'] = $this->users_mdl->get_all($start_page, $per_page, $input);
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			//Присоединяем к ссылкам на страницы, поисковые GET параметры
			$data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
		}
		
		if (! empty($data['url'])) {
			$data['url'] = implode("&", $data['url']);
		}
		
		/**
		 * Блок
		 */
		$data['categories'] = $this->categories_mdl->get_categories_for_users();
		
		$data['input'] = array(
			'order_field'=>(isset($input['order_field'])) ? $input['order_field'] : '',
			//Если не задан ордер тип, ставим desc
			'order_type'=>(isset($input['order_type'])) ? $input['order_type'] : 'desc',
		);
		
		$this->template->build('users/all', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Расширенный поиск пользователей
	 * ---------------------------------------------------------------
	 */

	function search($start_page = 0) {
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 100;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$url = '';
		
		$category = '';
		
		$input = array(
		);
		
		$title = 'Поиск дизайнера';
		
		if (! empty($_GET['category'])) {
			$category = $_GET['category'];
			
			if (!$this->_category_check($category)) {
				$category = 1;
			}
			
			$data['category'] = $category;
			
			//Выводим Заголовок категории
			$title = $this->categories_mdl->title($category).' | '.$title;
			
			$input['category_array'] = $this->categories_mdl->cat_array($category);
			
			$url['category'] = 'category='.$category;
		}
		
		//Результатов на страницу
		if (! empty($_GET['result']) and is_numeric($_GET['result'])) {
			$input['per_page'] = $_GET['result'];
			$url['result'] = 'result='.$_GET['result'];
			
			$per_page = $input['per_page'];
		}
		
		//Ключевые слова
		if (! empty($_GET['keywords'])) {
			$input['keywords'] = $_GET['keywords'];
			$url['keywords'] = 'keywords='.$_GET['keywords'];
		}
		
		//Страна
		if (! empty($_GET['country_id'])) {
			$input['country_id'] = $_GET['country_id'];
			$url['country_id'] = 'country_id='.$_GET['country_id'];
		}
		
		//Город
		if (! empty($_GET['city_id'])) {
			$input['city_id'] = $_GET['city_id'];
			$url['city_id'] = 'city_id='.$_GET['city_id'];
		}
		
		//Возраст от
		if (! empty($_GET['age_start']) and is_numeric($_GET['age_start'])) {
			$input['age_start'] = $_GET['age_start'];
			$url['age_start'] = 'age_start='.$_GET['age_start'];
		}
		
		//Возраст до
		if (! empty($_GET['age_end']) and is_numeric($_GET['age_end'])) {
			$input['age_end'] = $_GET['age_end'];
			$url['age_end'] = 'age_end='.$_GET['age_end'];
		}
		
		//Цена за час от
		if (! empty($_GET['price_1_start']) and is_numeric($_GET['price_1_start'])) {
			$input['price_1_start'] = $_GET['price_1_start'];
			$url['price_1_start'] = 'price_1_start='.$_GET['price_1_start'];
		}
		
		//Цена за час до
		if (! empty($_GET['price_1_end']) and is_numeric($_GET['price_1_end'])) {
			$input['price_1_end'] = $_GET['price_1_end'];
			$url['price_1_end'] = 'price_1_end='.$_GET['price_1_end'];
		}
		
		//Цена за месяц от
		if (! empty($_GET['price_2_start']) and is_numeric($_GET['price_2_start'])) {
			$input['price_2_start'] = $_GET['price_2_start'];
			$url['price_2_start'] = 'price_2_start='.$_GET['price_2_start'];
		}
		
		//Цена за месяц до
		if (! empty($_GET['price_2_end']) and is_numeric($_GET['price_2_end'])) {
			$input['price_2_end'] = $_GET['price_2_end'];
			$url['price_2_end'] = 'price_2_end='.$_GET['price_2_end'];
		}
		
		//Для прикрепления к ссылке сортировки
		$data['url'] = $url;
		
		//Сортировка
		if (! empty($_GET['order_field'])) {
			$order_field = $_GET['order_field'];
			
			if ($order_field == 'rating') {
				$input['order_field'] = $_GET['order_field'];
				$url['order_field'] = 'order_field='.$_GET['order_field'];
			}
		}
		
		//Тип сортировки
		if (! empty($_GET['order_type'])) {
			$input['order_type'] = $_GET['order_type'];
			$url['order_type'] = 'order_type='.$_GET['order_type'];
		} else {
			$input['order_type'] = 'desc';
		}
		
		$config['base_url'] = base_url().'/users/search/';
		$config['total_rows'] = $this->users_mdl->count_all($input);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		//Вывод
		$data['data'] = $this->users_mdl->get_all($start_page, $per_page, $input);
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			//Присоединяем к ссылкам на страницы, поисковые GET параметры
			$data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
		}
		
		if (! empty($data['url'])) {
			$data['url'] = implode("&", $data['url']);
		}
		
		/**
		 * Блок
		 */
		$data['input'] = array(
			'keywords'=>(isset($input['keywords'])) ? $input['keywords'] : '','country_id'=>(isset($input['country_id'])) ? $input['country_id'] : '',
				'city_id'=>(isset($input['city_id'])) ? $input['city_id'] : '','age_start'=>(isset($input['age_start'])) ? $input['age_start'] : '',
				'age_end'=>(isset($input['age_end'])) ? $input['age_end'] : '','price_1_start'=>(isset($input['price_1_start'])) ? $input['price_1_start'] : '',
				'price_1_end'=>(isset($input['price_1_end'])) ? $input['price_1_end'] : '',
				'price_2_start'=>(isset($input['price_2_start'])) ? $input['price_2_start'] : '',
				'price_2_end'=>(isset($input['price_2_end'])) ? $input['price_2_end'] : '',
				'category'=>$category,'order_field'=>(isset($input['order_field'])) ? $input['order_field'] : '',
			//Если не задан ордер тип, ставим desc
			'order_type'=>(isset($input['order_type'])) ? $input['order_type'] : 'desc',
				'result'=>$per_page,
		);
		
		$data['categories'] = $this->categories_mdl->get_categories_for_users();
		
		$this->template->build('users/search', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Профиль пользователя
	 * ---------------------------------------------------------------
	 */

	function view($username = '') {
		//КЭШИРОВАНИЕ
		//$this->output->cache(5);
		if (!$data = $this->users_mdl->get($username)) {
			show_404('page');
		}
		
		if ($cause = $this->_check_banned($data['id'])) {
			show_error('Пользователь заблокирован.<br><br>Причина: '.$cause.'');
		}
		
		$this->users_mdl->update_views($data['id']);
		
		$title = $data['name'].' '.$data['surname'].' ('.$data['username'].')';
		
		$data['profile'] = $this->account_mdl->get_profile($data['id']);
		
		$this->template->build('users/view', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Услуги пользователя
	 * ---------------------------------------------------------------
	 */

	function services($username = '') {
		if (!$data = $this->users_mdl->get($username)) {
			show_404('page');
		}
		
		if ($cause = $this->_check_banned($data['id'])) {
			show_error('Пользователь заблокирован.<br><br>Причина: '.$cause.'');
		}
		
		$this->users_mdl->update_views($data['id']);
		
		$data['services'] = $this->account_mdl->get_services($data['id']);
		
		if ($data['services']) {
			$select = $data['services'];
			
			foreach ($select as $row=>$value):
				$select[$row] = $value['category'];
				$select_parent[$row] = $value['parent_id'];
			endforeach;
			
			//Категории
			$data['select'] = $select;
			
			//Разделы
			$data['select_parent'] = $select_parent;
		}
		
		$data['categories'] = $this->categories_mdl->get_categories();
		
		$title = $data['name'].' '.$data['surname'].' ('.$data['username'].') | Услуги';
		
		$this->template->build('users/services', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Подписчики
	 * ---------------------------------------------------------------
	 */

	function followers($username = '', $start_page = 0) {
		if (!$data = $this->users_mdl->get($username)) {
			show_404('page');
		}
		
		if ($cause = $this->_check_banned($data['id'])) {
			show_error('Пользователь заблокирован.<br><br>Причина: '.$cause.'');
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$type = '';
		
		if (! empty($_GET['type'])) {
			$type = $_GET['type'];
			
			$url['type'] = 'type='.$_GET['type'];
		}
		
		$this->users_mdl->update_views($data['id']);
		
		$data['positive'] = $this->reviews_mdl->count_reviews_positive($data['id']);
		
		$data['negative'] = $this->reviews_mdl->count_reviews_negative($data['id']);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['uri_segment'] = '4';
		$config['base_url'] = base_url().'/users/followers/'.$username.'';
		//$this->reviews_mdl->count_reviews($data['id'], $type);
		$config['total_rows'] = 10;
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			$data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
		}
		
		$data['followers'] = $this->account_mdl->get_followers($start_page, $per_page, $data['id']);
		
		$title = $data['name'].' '.$data['surname'].' ('.$data['username'].') | Отзывы';
		
		$this->template->build('users/followers', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Отзывы пользователя
	 * ---------------------------------------------------------------
	 */

	function reviews($username = '', $start_page = 0) {
		if (!$data = $this->users_mdl->get($username)) {
			show_404('page');
		}
		
		if ($cause = $this->_check_banned($data['id'])) {
			show_error('Пользователь заблокирован.<br><br>Причина: '.$cause.'');
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$type = '';
		
		if (! empty($_GET['type'])) {
			$type = $_GET['type'];
			
			$url['type'] = 'type='.$_GET['type'];
		}
		
		$this->users_mdl->update_views($data['id']);
		
		$data['positive'] = $this->reviews_mdl->count_reviews_positive($data['id']);
		
		$data['negative'] = $this->reviews_mdl->count_reviews_negative($data['id']);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['uri_segment'] = '4';
		$config['base_url'] = base_url().'/users/reviews/'.$username.'';
		$config['total_rows'] = $this->reviews_mdl->count_reviews($data['id'], $type);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			$data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
		}
		
		$data['reviews'] = $this->reviews_mdl->get_reviews($start_page, $per_page, $data['id'], $type);
		
		$title = $data['name'].' '.$data['surname'].' ('.$data['username'].') | Отзывы';
		
		$this->template->build('users/reviews', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Добавить отзыв
	 * ---------------------------------------------------------------
	 */
	//Нельзя оставлять отзывы самому себе и больше одного раза в час, проверяем сколько прошло времени с последнего добавления отзыв, нельзя оставлять несколько отзывов одному и тому же пользователю

	function reviews_add($username = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если пользователь не найден
		if (!$user_id = $this->users_mdl->get_id($username)) {
			show_404('page');
		}
		
		if ($this->user_id == $user_id) {
			show_error('Нельзя оставлять отзыв себе');
		}
		
		//Если отзыв был уже добавлен
		if ($this->_check_add_reviews($user_id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		//От текущей даты отнимаем дату последнего добавления отзыва
		$date = now() - $this->reviews_mdl->last_date($this->user_id);
		
		//Если остаток даты меньше чем заданный в настройках
		if ($date < $this->config->item('reviews_add')) {
			//
			$left_date = $this->config->item('reviews_add') - $date;
			$left_date = now() + $left_date;
			$left_date = date_await($left_date);
			
			show_error('Следующий отзыв вы сможете добавить через '.$left_date.'');
		}
		
		$rules = array(
			array(
				'field'=>'text','label'=>'Текст','rules'=>'required|max_length[1000]'
			),array(
				'field'=>'rating','label'=>'Рейтинг','rules'=>'required'
			)
		);
		
		$data = array(
			'user_id'=>$user_id,'from_id'=>$this->user_id,'date'=>now(),'text'=>htmlspecialchars($this->input->post('text')),
				'rating'=>$this->input->post('rating')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->db->insert('reviews', $data);
			
			/**
			 * ---------------------------------------------------------------
			 *	Отправитель отзыва
			 * ---------------------------------------------------------------
			 */
			if ($data['rating'] > 0) {
				$this->events->create($this->user_id, 'Отправлен положительный отзыв', 'add_positive_review');#Событие с репутацией
			} else {
				$this->events->create($this->user_id, 'Отправлен отрицательный отзыв', 'add_negative_review');#Событие с репутацией
			}
			
			/**
			 * ---------------------------------------------------------------
			 *	Получатель отзыва
			 * ---------------------------------------------------------------
			 */
			if ($data['rating'] > 0) {
				$this->events->create($data['user_id'], 'Получен положительный отзыв', 'receipt_positive_review');#Событие с репутацией
			} else {
				$this->events->create($data['user_id'], 'Получен отрицательный отзыв', 'receipt_negative_review');#Событие с репутацией
			}
			
			redirect('users/reviews/'.$username);
		}
		
		$this->template->build('users/reviews_add', $data, $title = 'Добавить отзыв');
		
	}
	
	//Проверка, был ли уже добавлен отзыв пользователю от данного пользователя(from_id

	function _check_add_reviews($user_id = '') {
		if ($this->reviews_mdl->check($user_id, $this->user_id)) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Дизайны пользователя
	 * ---------------------------------------------------------------
	 */

	function designs($username = '', $start_page = 0) {
		if (!$data = $this->users_mdl->get($username)) {
			show_404('page');
		}
		
		if ($cause = $this->_check_banned($data['id'])) {
			show_error('Пользователь заблокирован.<br><br>Причина: '.$cause.'');
		}
		
		$this->users_mdl->update_views($data['id']);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$input['user_id'] = $data['id'];
		
		$config['uri_segment'] = '4';
		$config['base_url'] = base_url().'/users/designs/'.$username.'';
		$config['total_rows'] = $this->designs_mdl->count_designs($input);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->designs_mdl->get_designs($start_page, $per_page, $input);
		
		$data['used_colors'] = $this->designs_mdl->used_colors($data['id']);
		
		$title = $data['name'].' '.$data['surname'].' ('.$data['username'].') | Портфолио';
		
		$this->template->build('users/designs', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Портфолио пользователя
	 * ---------------------------------------------------------------
	 */

	function portfolio($username = '') {
		$this->load->helper('highslide');
		
		if (!$data = $this->users_mdl->get($username)) {
			show_404('page');
		}
		
		if ($cause = $this->_check_banned($data['id'])) {
			show_error('Пользователь заблокирован.<br><br>Причина: '.$cause.'');
		}
		
		$this->users_mdl->update_views($data['id']);
		
		$data['portfolio'] = $this->account_mdl->get_portfolio($data['id']);
		
		$title = $data['name'].' '.$data['surname'].' ('.$data['username'].') | Альбом';
		
		$this->template->build('users/portfolio', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Восстановление пароля
	 * ---------------------------------------------------------------
	 */

	function recovery() {
		$rules = array(
			array(
				'field'=>'username','label'=>'Логин','rules'=>'required|trim'
			),array(
				'field'=>'email','label'=>'Email','rules'=>'required|valid_email|callback__remind_check'
			)
		);
		
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run() and $this->users_mdl->recovery($email)) {
			show_error('На ваш email был отправлен сгенерированный пароль');
			
		} else {
			$this->template->build('users/recovery', $data = '', $title = 'Восстановление пароля');
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Активация пользователя
	 * ---------------------------------------------------------------
	 */

	function activate($code = '') {
		if ($this->users_mdl->logged_in() or !$code) {
			redirect('');
		}
		
		if ($this->users_mdl->activate($code)) {
			show_error('Активация успешно завершена');
		} else {
			show_error('Активация не удалась');
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Активация пользователя
	 * ---------------------------------------------------------------
	 */

	function activate_2($code = '') {
		if ($this->users_mdl->activate_2($code)) {
			redirect('');
		} else {
			show_error('Активация не удалась');
		}
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Функции, проверки
	 * ---------------------------------------------------------------
	 */

	function _category_check($category) {
		if ($this->categories_mdl->category_check($category)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function _check_banned($user_id) {
		if ($cause = $this->users_mdl->check_banned($user_id)) {
			return $cause;
		}
		
		return FALSE;
	}

	function _login_check($username) {
		if ($this->users_mdl->login($username, $this->input->post('password'))) {
			return TRUE;
		}
		
		$this->form_validation->set_message('_login_check', 'Неверно введён логин или пароль');
		return FALSE;
	}

	function _username_check($username) {
		if ($this->users_mdl->username_check($username)) {
			$this->form_validation->set_message('_username_check', 'Имя пользователя уже используется');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function _remind_check($email) {
		if ($this->users_mdl->remind_check($email, $this->input->post('username'))) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_remind_check', 'Пользователь с адресом '.$email.' не найден.');
			return FALSE;
		}
	}

	function _email_check($email) {
		if ($this->users_mdl->email_check($email)) {
			$this->form_validation->set_message('_email_check', 'Email уже используется');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function _agree_check($agree) {
		if ($agree) {
			return TRUE;
		} else {
			$this->form_validation->set_message('_agree_check', 'Пользовательское соглашение должно быть принято.');
			return FALSE;
		}
	}

	function _captcha_check($captcha) {
		if ($captcha != $this->session->userdata('captcha_rnd_str')) {
			$this->form_validation->set_message('_captcha_check', 'Неверно введён код');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	МОДЕРАТОР
	 * ---------------------------------------------------------------
	 */
	 
	 /**
	 * ---------------------------------------------------------------
	 *	Редактировать отзыв
	 * ---------------------------------------------------------------
	 */

	function reviews_edit($id = '') {
		//МОДЕРАТОРЫ
		$this->_moderator();
		
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$data = $this->reviews_mdl->get($id)) {
			show_404('page');
		}
		
		//Получаем сведения об отправителе отзыва
		$userdata = $this->users_mdl->get_user($data['from_id']);
		
		//Если отзыв модератора и отзыв не принадлежит пользователю
		if ($userdata['team'] == 2 and $data['from_id'] != $this->user_id) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$rules = array(
			array(
				'field'=>'text','label'=>'Текст','rules'=>'required|max_length[1000]'
			)
		);
		
		$reviewdata = array(
			'text'=>htmlspecialchars($this->input->post('text')),'moder_date'=>now(),'moder_user_id'=>$this->user_id
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->reviews_mdl->edit($id, $reviewdata);
			
			//Будет исправлено
			$userdata = $this->users_mdl->get_user($data['user_id']);
			
			redirect('users/reviews/'.$userdata['username']);
		}
		
		$this->template->build('users/reviews_edit', $data, $title = 'Редактировать отзыв');
		
	}
	
	//Убрать рейтинг и удалить историю добавления

	function reviews_del($id = '') {
		$this->_moderator();
		
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$data = $this->reviews_mdl->get($id)) {
			show_404('page');
		}
		
		//Получаем сведения об отправителе отзыва
		$userdata = $this->users_mdl->get_user($data['from_id']);
		
		//Если отзыв модератора и отзыв не принадлежит пользователю+
		if ($userdata['team'] == 2 and $data['from_id'] != $this->user_id) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		//Если был положительный
		if ($data['rating'] == 1) {
			if ($this->rating->value('add_positive_review') > 0) {
				$this->rating->minus($data['user_id'], $this->rating->value('add_positive_review'));
			}
			
			if ($this->rating->value('receipt_positive_review') > 0) {
				$this->rating->minus($data['from_id'], $this->rating->value('add_negative_review'));
			}
		} else {
			if ($this->rating->value('add_negative_review') > 0) {
				$this->rating->minus($data['user_id'], $this->rating->value('add_negative_review'));
			}
			
			if ($this->rating->value('receipt_negative_review') > 0) {
				$this->rating->minus($data['from_id'], $this->rating->value('add_negative_review'));
			}
		}
		
		$this->reviews_mdl->del($id);
		
		$this->events->del($data['user_id'], $data['date']);
		
		$this->events->del($data['from_id'], $data['date']);
		
		//Будет исправлено
		$userdata = $this->users_mdl->get_user($data['user_id']);
		
		redirect('users/reviews/'.$userdata['username']);
	}
	
	//Модератор

	function _moderator() {
		if ($this->team != 2) {
			show_error('Вы не имеете доступа к данному разделу');
		}
	}
}
