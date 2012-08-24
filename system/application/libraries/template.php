<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template
{
	private $user_id;

	private $username;

	private $userpic;

	private $_ci;
	
	private $theme;

	private $script = '';

	function __construct()
	{
		$this->_ci =& get_instance();

		$this->theme = 'wdesigns';
	}

		function build($view, $data = array(), $title = '', $section = FALSE) 
	{
		$template['title'] = $this->title($title);

		$theme = $this->theme;

		if( $this->_ci->users_mdl->logged_in() )
		{
			$this->hint();

			$this->_ci->user_id = $this->_ci->session->userdata('id');
			$this->_ci->username = $this->_ci->users_mdl->get_user_by_id($this->_ci->user_id)->username;
			$this->_ci->userpic = $this->_ci->users_mdl->get_user_by_id($this->_ci->user_id)->userpic;
			
			$template['login']['username'] = $this->_ci->username;
			$template['login']['userpic'] = $this->_ci->userpic;

			$template['login']['name'] = $this->_ci->users_mdl->get_user_by_id($this->_ci->user_id)->name;
			$template['login']['surname'] = $this->_ci->users_mdl->get_user_by_id($this->_ci->user_id)->surname;

			$this->_ci->load->model('balance/balance_mdl');
			$this->_ci->load->model('contacts/contacts_mdl');
			$this->_ci->load->model('events/events_mdl');

			$template['login']['messages'] = $this->_ci->contacts_mdl->count_new_messages($this->_ci->user_id);

			$template['login']['events'] = $this->_ci->events_mdl->count_new_events($this->_ci->user_id);

			$template['login']['balance'] = $this->_ci->balance_mdl->get($this->_ci->user_id);

			$template['login']['rating'] = $this->_ci->rating->get($this->_ci->user_id);

			$template['login']['tariff'] = $this->_ci->tariff->get($this->_ci->user_id);
		}
		else
		{
			$template['login'] = '';
		}

		$template['login']['logged_in'] = $this->_ci->users_mdl->logged_in();

		$template['login'] = $this->_ci->load->view($theme.'/login', $template['login'], TRUE);

		if( isset($data['descr']) )
		{
			$data['description'] = $this->set_metadata('description', $data['descr']);
		}

		if( isset($data['keywords']) )
		{
			$data['keywords'] = $this->set_metadata('keywords', $data['keywords']);
		}

		//Контент
		$template['content'] = $this->_ci->load->view($theme.'/'.$view, $data, TRUE);

		if( isset($this->script) )
		{
			$template['script'] = $this->script;
		}

		$this->_ci->load->view($theme.'/template', $template);
	}

		function build_admin($view, $data = array(), $title = '') 
	{
		if( !$this->_ci->admin_mdl->logged_in() )
		{
			redirect('administrator/login');
		}

		$template['title'] = $this->title($title);

		$template['view'] = $view;

		$theme = 'admin';

		//Контент
		$template['content'] = $this->_ci->load->view($theme.'/'.$view, $data, TRUE);

		$template['count_new_reports'] = $this->_ci->admin_mdl->count_new_reports();

		$template['new_reports'] = $this->_ci->admin_mdl->get_new_reports();

		$this->_ci->load->view($theme.'/template', $template);
	}

	function set_metadata($name, $content)
	{
				$name = htmlspecialchars(strip_tags($name));
				$content = htmlspecialchars(strip_tags($content));

				if($name == 'keywords' && !strpos($content, ','))
				{
					$content = preg_replace('/[\s]+/', ', ', trim($content));
				}

		$metadata = '<meta name="'.$name.'" content="'.$content.'" />';

		return $metadata;
	}

	function title($title)
	{
		$title = $title.' | '.$this->_ci->config->item('site');

		return $title;
	}

/**
* ---------------------------------------------------------------
*	Контроллер вывода подсказан, только для авторизированных, только для тех у кого не отключены уведомления, события, повышения репутации и т д
* ---------------------------------------------------------------
*/
		function hint() 
	{
		$settings = $this->_ci->users_mdl->get_settings($this->_ci->session->userdata('id'));

		//Если у пользователя отключены всплывающии подсказкм
		if( $settings['hint'] == 0 )
		{
			return FALSE;
		}

		$data['data'] = $this->_ci->events->get($this->_ci->session->userdata('id'));

		$data = $this->_ci->load->view('events', $data, TRUE);

		//Если нету новых событий останавливаем контроллер
		if( empty($data) )
		{
			return FALSE;
		}

		$this->script = 

<<<HERE
<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	var counter = 0, massiv = massiv();

	//Показываем первый элемент
	show(massiv[counter]);

	function massiv()
	{
		// находим все подсказки
		var massiv = [], data = $('.event');
			
		// перебираем все
		for( var i = 0, size = data.length;i < size; i++ )
		{
			id = data[i].id.split('-');

			massiv[i] = id[1];
		}

		return massiv;
	}

	function show(id){
		$('#message-' + id).css({visibility: "visible"});
	}

	$('.event').click(function()
	{
		//Счётчик
		counter++;

		//Id данного элемента
		data = $(this).attr('id').split('-');

		id = data[1];

		//Удаляем событие из базы
		delete_message(id);

		//Id следующего элемента который будем показываеть
		next_id = massiv[counter];

		//Скрываем подсказку
		$('#message-' + id).animate({ top:"+=15px",opacity:0 }, "slow");

		$('#message-' + id).queue(function ()
		//Очередь
		{
			//Делаем невидимым
			$('#message-' + id).css({visibility: "hidden"});
			show(next_id);
		});
			
	});

	$('.events').click(function()
	{
		//Удаляем событие из базы
		delete_message_all();

		//Скрываем подсказку
		$('#message-all').animate({ top:"+=15px",opacity:0 }, "slow");

		$('#message-all').queue(function ()
		//Очередь
		{
			//Делаем невидимым
			$('#message-all').css({visibility: "hidden"});
			show(next_id);
		});
			
	});

	$(window).scroll(function()
	{
		$('.event').animate({top:$(window).scrollTop()+"px" },{queue: false, duration: 350}); 
		$('.events').animate({top:$(window).scrollTop()+"px" },{queue: false, duration: 350}); 
	});

//Удаляем сообщение
	function delete_message(id)
	{
		var dataString = 'id='+ id;

		$.ajax({
			type: "POST",
			url: "/account/delete_message",
			data: dataString,
			cache: false,
		});

		return false;
	}

//Удаляем сообщение
	function delete_message_all()
	{
		$.ajax({
			type: "POST",
			url: "/account/delete_message_all",
			cache: false,
		});

		return false;
	}

});
</script>
$data
HERE;

	}
}