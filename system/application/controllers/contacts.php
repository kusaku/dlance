<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class Contacts extends Controller {
	public $user_id;
	
	public $username;
	
	public $userpic;
	
	public $team;

	function __construct() {
		parent::Controller();
		$this->load->model('contacts/contacts_mdl');
		if ($this->users_mdl->logged_in()) {
			$this->user_id = $this->session->userdata('id');
			$this->type = $this->session->userdata('type');
			
			$user = $this->users_mdl->get_user_by_id($this->user_id);
			$this->username = $user->username;
			$this->userpic = $user->userpic;
			$this->team = $user->team;
		}
	}

	function index($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		//Категория
		if (! empty($_GET['group_id'])) {
			$group_id = $_GET['group_id'];
			
			//Если группа не существует
			if (!$this->contacts_mdl->check_group($group_id)) {
				$group_id = 1;
			}
			
			$url['group_id'] = 'group_id='.$_GET['group_id'];
		} else {
			$group_id = 1;
		}
		
		$data['groups'] = $this->contacts_mdl->get_groups();
		
		$data['active'] = $this->contacts_mdl->get_group($group_id);
		
		$this->load->library('pagination');
		
		$config['base_url'] = base_url().'/contacts/index/';
		$config['total_rows'] = $this->contacts_mdl->count_contacts($group_id, $this->user_id);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$contacts['data'] = $this->contacts_mdl->get_contacts($start_page, $per_page, $group_id);
		
		$contacts['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			
			$contacts['page_links'] = str_replace('">', '/?'.$url.'">', $contacts['page_links']);
		}
		
		$data['contacts'] = $this->load->view('wdesigns/contacts/contacts', $contacts, TRUE);
		
		$this->template->build('contacts/view', $data, $title = 'Контакты / Сообщения');
	}

	function add() {
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'name','label'=>'Название','rules'=>'required|max_length[64]'
			)
		);
		
		$data = array(
			'user_id'=>$this->user_id,'name'=>htmlspecialchars($this->input->post('name'))
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->contacts_mdl->add_group($data);
			
			redirect('contacts/');
		}
		
		$data['groups'] = $this->contacts_mdl->get_groups();
		
		$this->template->build('contacts/add', $data, $title = 'Контакты / Сообщения');
	}

	function move() {
		if (!$this->errors->access()) {
			return;
		}
		
		//массив с id контактов
		$id = $this->input->post('users');
		
		//группа куда будем перемещать контакты
		$group_id = $this->input->post('group_id');
		
		$this->contacts_mdl->move_contacts($id, $group_id);
		
		redirect('contacts/index/?group_id='.$group_id);
	}
	
	//Здесь выводим все сообщения и форму отправки сообщений

	function send($username = '', $start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$contact = $this->users_mdl->get_id($username)) {
			show_404('page');
		}
		
		if ($contact == $this->user_id) {
			redirect('contacts/');
		}
		
		$rules = array(
			array(
				'field'=>'text','label'=>'Текст','rules'=>'required|text|max_length[1000]'
			)
		);
		
		$data = array(
			//Пользователь отправитель
			'sender_id'=>$this->user_id,
			//Получатель
			'recipient_id'=>$contact,'date'=>now(),'text'=>$this->input->post('text')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->contacts_mdl->send_message($data);
			
			if (!$this->contacts_mdl->count_contacts($group_id = '', $this->user_id, $contact)) {
				//Добавляем чела к себе
				$data = array(
					'user_id'=>$this->user_id,'contact'=>$contact,'group_id'=>1,'last_msg'=>now()
				);
				
				$this->contacts_mdl->add_contact($data);
			}
			
			//Проверяем есть ли мы в контакте у пользователя
			if (!$this->contacts_mdl->count_contacts($group_id = '', $contact, $this->user_id)) {
				//Добавляем нас к пользовелю
				$data = array(
					'user_id'=>$contact,'contact'=>$this->user_id,'group_id'=>1,'last_msg'=>now()
				);
				
				$this->contacts_mdl->add_contact($data);
			}
			
			//Обновляем дату последнего сообщения
			$this->contacts_mdl->update_last_msg($this->user_id, $contact);
			
			$this->contacts_mdl->update_last_msg($contact, $this->user_id);
			/**
			 * ---------------------------------------------------------------
			 *	Получатель сообщение
			 * ---------------------------------------------------------------
			 */
			$this->events->create($contact, 'Получено персональное сообщение', 'receipt_message');#Событие с репутацией
			/**
			 * ---------------------------------------------------------------
			 *	Отправитель сообщения
			 * ---------------------------------------------------------------
			 */
			$this->events->create($this->user_id, 'Отправлено персональное сообщение', 'send_message');#Событие с репутацией
			
			redirect('contacts/send/'.$username.'');
		}
		
		//Выводим пользователя
		$data = $this->users_mdl->get_user($contact);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$this->load->library('pagination');
		
		$config['uri_segment'] = '4';
		$config['base_url'] = base_url().'/contacts/send/'.$username;
		$config['total_rows'] = $this->contacts_mdl->count_messages($contact);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['messages'] = $this->contacts_mdl->get_messages($start_page, $per_page, $contact);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['black_list'] = $this->_black_list($contact);
		
		$data['created'] = date_smart($data['created']);
		
		$data['last_login'] = date_smart($data['last_login']);
		
		$this->template->build('contacts/send', $data, $title = 'Контакты / Сообщения');
	}
	
	//Проверяем находимся ли мы в черном списке у контакта

	function _black_list($contact) {
		//4 - черный список
		if ($this->contacts_mdl->count_contacts(4, $contact, $this->user_id)) {
			return TRUE;
		}
		
		return FALSE;
	}

	function del($group_id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если такая группа не существует у пользователя
		if (!$this->contacts_mdl->check_group($group_id, $this->user_id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		if ($this->contacts_mdl->count_contacts($group_id, $this->user_id) > 0) {
			show_error('Нельзя удалить не пустую группу.');
		}
		
		$this->contacts_mdl->del_group($group_id);
		
		redirect('contacts/');
	}

	function edit($group_id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если такая группа не существует у пользователя
		if (!$this->contacts_mdl->check_group($group_id, $this->user_id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$rules = array(
			array(
				'field'=>'name','label'=>'Название','rules'=>'required|text|max_length[64]'
			)
		);
		
		$data = array(
			'user_id'=>$this->user_id,'name'=>htmlspecialchars($this->input->post('name'))
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->contacts_mdl->edit_group($group_id, $data);
			
			redirect('contacts/');
		}
		
		$data = $this->contacts_mdl->get_group($group_id);
		
		$data['groups'] = $this->contacts_mdl->get_groups();
		
		$this->template->build('contacts/edit', $data, $title = 'Контакты / Сообщения');
	}
}
