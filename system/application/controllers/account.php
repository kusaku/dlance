<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Account extends Controller {
	public $user_id;
	
	public $username;
	
	public $userpic;
	
	public $user_tariff;
	
	public $adult;
	
	public $team;

	function __construct() {
		parent::Controller();
		$this->load->model('categories/categories_mdl');
		$this->load->model('balance/balance_mdl');
		$this->load->model('blogs/blogs_mdl');
		$this->load->model('designs/designs_mdl');
		$this->load->model('account/account_mdl');
		$this->load->library('pagination');
		if ($this->users_mdl->logged_in()) {
			$this->user_id = $this->session->userdata('id');
			
			$this->user = $this->users_mdl->get_user_by_id($this->user_id);
			$this->username = $this->user->username;
			$this->userpic = $this->user->userpic;
			$this->team = $this->user->team;
			$this->user_tariff = $this->tariff->id($this->user_id);
			$this->adult = $this->settings->value($this->user_id, 'adult');
		} else {
			$this->adult = 0;
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	ROBOKASSA
	 * ---------------------------------------------------------------
	 */

	function balance() {
		if (!$this->errors->access()) {
			return;
		}
		
		$this->config->item('pay_robox_login');
		// регистрационная информация (логин, пароль #1)
		
		// registration info (login, password #1)
		
		$mrh_login = $this->config->item('pay_robox_login');
		$mrh_pass1 = $this->config->item('pay_robox_pass1');
		// номер заказа
		
		// number of order
		
		$inv_id = 1;
		// описание заказа
		
		// order description
		
		$inv_desc = "Пополнение баланса";
		// сумма заказа
		
		// sum of order
		
		$out_summ = "";
		// предлагаемая валюта платежа
		
		// default payment e-currency
		
		$in_curr = "PCR";
		// язык
		
		// language
		
		$culture = "ru";
		// формирование подписи
		
		// generate signature
		
		$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
		// форма оплаты товара
		
		// payment form
		
		$data = array(
			'rb_mrh_login'=>$mrh_login,'rb_payment_amount'=>$out_summ,'rb_payment_id'=>$inv_id,
				'rb_payment_desc'=>$inv_desc,'rb_sign'=>$crc
		);
		if ($this->config->item('pay_robox_mode') == 0)
			$data["robokassaUrl"] = 'http://test.robokassa.ru/Index.aspx';
		else
			$data["robokassaUrl"] = 'https://merchant.roboxchange.com/Index.aspx';
			
		$this->template->build('account/balance_r', $data, $title = 'Пополнение баланса через Робокассу');
	}

	function result_r() {
		// регистрационная информация (пароль #2)
		
		// registration info (password #2)
		
		$mrh_pass2 = $this->config->item('pay_robox_pass2');
		
		//установка текущего времени
		
		//current date
		
		$tm = getdate(time() + 9 * 3600);
		$date = "$tm[year]-$tm[mon]-$tm[mday] $tm[hours]:$tm[minutes]:$tm[seconds]";
		
		// чтение параметров
		
		// read parameters
		
		$out_summ = $_REQUEST["OutSum"];
		$inv_id = $_REQUEST["InvId"];
		$crc = $_REQUEST["SignatureValue"];
		
		//Заказ без авторизацииы
		
		if (! empty($_REQUEST["ShpCart"])) {
			$ShpCart = $_REQUEST["ShpCart"];
		}
		
		//Заказ без авторизацииы
		
		if (! empty($_REQUEST["ShpCode"])) {
			$ShpCode = $_REQUEST["ShpCode"];
		}
		
		$crc = strtoupper($crc);
		
		//Заказ без авторизацииы
		
		if (! empty($ShpCart)) {
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:ShpCart=".$ShpCart.":ShpCode=".$ShpCode.""));
		} else {
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));
		}
		
		// проверка корректности подписи
		
		// check signature
		
		if ($my_crc != $crc) {
			echo "bad sign\n";
			exit();
		}
		
		// признак успешно проведенной операции
		
		// success
		
		echo "OK$inv_id\n";
	}

	function tes($code = '') {
		$userdata = $this->users_mdl->activate_3($code);
		
		$data['username'] = $userdata['username'];
		
		$data['password'] = $userdata['password'];
		
		$this->template->build('account/tes', $data, $title = 'Авторизация');
	}

	function succes_r() {
		// регистрационная информация (пароль #1)
		
		// registration info (password #1)
		
		$mrh_pass1 = "199122x199122x";
		
		// чтение параметров
		
		// read parameters
		
		$out_summ = $_REQUEST["OutSum"];
		$inv_id = $_REQUEST["InvId"];
		$crc = $_REQUEST["SignatureValue"];
		$crc = strtoupper($crc);
		
		//Заказ без авторизацииы
		
		if (! empty($_REQUEST["ShpCart"])) {
			$ShpCart = $_REQUEST["ShpCart"];
		}
		
		//Заказ без авторизацииы
		
		if (! empty($_REQUEST["ShpCode"])) {
			$ShpCode = $_REQUEST["ShpCode"];
		}
		
		//Заказ без авторизацииы
		
		if (! empty($ShpCart)) {
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:ShpCart=".$ShpCart.":ShpCode=".$ShpCode.""));
		} else {
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));
		}
		
		// проверка корректности подписи
		
		// check signature
		
		if ($my_crc != $crc) {
			echo "bad sign\n";
			exit();
		}
		
		if (! empty($ShpCart)) {
			$this->result_pay($ShpCart, $ShpCode);
			
			redirect('account/tes/'.$ShpCode);
		} else {
		
			/**
			 * ---------------------------------------------------------------
			 *	Пополнение счёта
			 * ---------------------------------------------------------------
			 */
			$this->balance_mdl->plus($this->user_id, $out_summ);
			
			$this->transaction->create($this->user_id, 'Пополнение счета', $out_summ);
			
			redirect('account');
		}
	}

	function result_pay($designs, $ShpCode) {
		$user_id = $this->users_mdl->get_id_by_code($ShpCode);
		
		$designs = $this->account_mdl->pay_no_auth_designs($designs);
		/**
		 * ---------------------------------------------------------------
		 *	После проверки выполняем изменения, добавляем в заказы, снимаем средства, прибавляем средства владельцу, отправляем дизайн на почту и т д
		 * ---------------------------------------------------------------
		 */
		foreach ($designs as $row):
		
			$email = $this->users_mdl->get_email($user_id);
			
			$file = $this->account_mdl->get_file($row['id']);
			
			$file = 'files/download/'.$file;
			
			$this->common->email($email, $subject = 'Вам прислан файл', '', $file);
			
			$data = array(
				'user_id'=>$user_id,'design_id'=>$row['id'],'date'=>now(),'kind'=>$row['kind']
			);
			
			//Добавляем в заказанные
			
			$this->account_mdl->add('purchased', $data);
			
			//Увеличиваем число заказов
			
			$this->designs_mdl->update_sales($row['id']);
			
			if ($row['kind'] == '1') {
				//Прибавляем владельцу цену за заказ
				
				$this->balance_mdl->plus($row['user_id'], $row['price_1']);
			}
			//Если дизайн вызаказан переводим статус на заказан - 2
			
			else {
				//Прибавляем владельцу цену за выкуп
				
				$this->balance_mdl->plus($row['user_id'], $row['price_2']);
				
				//Переводим в вызаказан
				
				$this->designs_mdl->enter($row['id']);
			}
			
			//Добавляем событие
			
			$this->events->create($row['user_id'], 'Ваш дизайн "'.$row['title'].'" был заказан');
			
			/**
			 * ---------------------------------------------------------------
			 *	Повышение репутации продавцу
			 * ---------------------------------------------------------------
			 */
			$this->events->create($row['user_id'], 'Продажа дизайна', 'sell_design');#Событие с репутацией
			
			/**
			 * ---------------------------------------------------------------
			 *	Повышение репутации покупателю
			 * ---------------------------------------------------------------
			 */
			$this->events->create($user_id, 'Заказ дизайна', 'buy_design');#Событие с репутацией
			
		endforeach;
	}

	function fail_r() {
		show_error('Вы отказались от оплаты.');
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Мерчант webmoney
	 * ---------------------------------------------------------------
	 */

	function balance_w() {
		if (!$this->errors->access()) {
			return;
		}
		
		$data = array(
		);
		
		$data['purse'] = 'R344515119665';
		
		$this->template->build('account/balance', $data, $title = 'Пополнение баланса');
	}

	function result() {
		$LMI_PREREQUEST = $this->input->post('LMI_PREREQUEST');
		$LMI_PAYMENT_AMOUNT = $this->input->post('LMI_PAYMENT_AMOUNT');
		$LMI_PAYEE_PURSE = $this->input->post('LMI_PAYEE_PURSE');
		$user_id = $this->input->post('user_id');
		
		$purse = 'R344515119665';
		
		if ($LMI_PREREQUEST == 1) {
		
			if ($LMI_PAYEE_PURSE != $purse) {
				$err = 1;
				echo "ERR: Вы не авторизированы на сайте";
				exit;
			}
			
			if (!$err)
				echo "YES";
		} else {
			$this->balance_mdl->plus($user_id, $LMI_PAYMENT_AMOUNT);
			
			$this->transaction->create($this->user_id, 'Пополнение счета', $LMI_PAYMENT_AMOUNT);
		}
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Перевод
	 * ---------------------------------------------------------------
	 */
	//Вывод

	function payments($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['base_url'] = base_url().'/account/payments';
		$config['total_rows'] = $this->account_mdl->count_payments($this->user_id);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->account_mdl->get_payments($start_page, $per_page, $this->user_id);
		
		$this->template->build('account/payments', $data, $title = 'Список платежей');
	}
	
	//Просмотр платежа

	function payments_view($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$data = $this->account_mdl->get_payment($id)) {
			show_404('page');
		}
		
		//Если платеж не причастен к пользователю
		
		if ($data['user_id'] != $this->user_id and $data['recipient_id'] != $this->user_id) {
			redirect('account/payments');
		}
		
		$rules = array(
			array(
				'field'=>'payment_id','label'=>'ID платежа','rules'=>'required|callback__check_payment'
			)
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			//Списываем со счёта
			
			$this->balance_mdl->plus($data['recipient_id'], $data['amount']);
			
			//Добавляем событие
			
			$this->events->create($data['user_id'], 'Платеж с ID '.$data['id'].' был принят');
			
			$update = array(
				'status'=>2
			);
			
			$this->account_mdl->edit('payments', $data['id'], $update);
			
			$username = $this->users_mdl->get_username($data['user_id']);
			
			$this->transaction->create($data['recipient_id'], 'Получение средств от пользователя "'.$username.'"', $data['amount']);
			
			show_error('Перевод получен.');
		}
		
		$this->template->build('account/payments_view', $data, $title = 'Платежи');
	}
	
	//Проверка принятия платежа, есть ли код протекции, если есть сверить код протекции с введённым, предназачен ли платеж пользователю

	function _check_payment($id) {
		//Выводим все данные о платеже
		
		$payment = $this->account_mdl->get_payment($id);
		
		if ($payment['type'] == 2) {
			$code = $this->input->post('code');
			
			if ( empty($code)) {
				$this->form_validation->set_message('_check_payment', 'Не введён код протекции');
				
				return FALSE;
			}
			
			if ($payment['code'] != $code) {
				$this->form_validation->set_message('_check_payment', 'Не верно введён код протекции');
				
				return FALSE;
			}
		}
		
		if ($payment['recipient_id'] != $this->user_id) {
			$this->form_validation->set_message('_check_payment', 'Платеж не предназначен вам');
			
			return FALSE;
		}
		
		if ($payment['status_id'] != 1) {
			$this->form_validation->set_message('_check_payment', 'Платеж уже завершён');
			
			return FALSE;
		}
		
		return TRUE;
	}

	function transfer() {
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'type','label'=>'Тип платежа','rules'=>'required'
			),array(
				'field'=>'recipient','label'=>'Получатель','rules'=>'required|max_length[15]|callback__user_check'
			),array(
				'field'=>'amount','label'=>'Сумма','rules'=>'required|numeric|max_length[6]|callback__check_transfer'
			),array(
				'field'=>'text','label'=>'Комментарий','rules'=>'required|max_length[10000]'
			)
		);
		
		$data = array(
			'user_id'=>$this->user_id,'recipient_id'=>$this->input->post('recipient'),'date'=>now(),
				'type'=>$this->input->post('type'),'code'=>'','time'=>$this->input->post('time'),
				'amount'=>$this->input->post('amount'),'text'=>htmlspecialchars($this->input->post('text')),
				'status'=>1
		);
		
		//Для истории
		
		$recipient = $this->input->post('recipient');
		
		$data['recipient_id'] = $this->users_mdl->get_id($recipient);
		
		//Для истории
		
		$recipient_id = $data['recipient_id'];
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			if ($data['type'] == 2) {
				//Создаём код протекции
				
				$data['code'] = random_string('alnum', 6);
				
				//Дата возвращения платежа отправителю 86400 - один день
				
				//Сколько всего времени до события
				
				$data['time'] = $data['time'] * 86400;
				
				//Прибавляем текущую дату
				
				$data['time'] = NOW() + $data['time'];
			}
			
			$this->account_mdl->add('payments', $data);
			
			//Списываем со счёта
			
			$this->balance_mdl->minus($this->user_id, $data['amount']);
			
			if ($data['type'] == 2) {
				$this->transaction->create($this->user_id, 'Перевод средств с кодом протекции пользователю "'.$recipient.'"', $data['amount']);
				
				show_error('Перевод завершен. Код протекции: '.$data['code'].'');
			} else {
				$this->transaction->create($this->user_id, 'Перевод средств пользователю "'.$recipient.'"', $data['amount']);
				
				show_error('Перевод завершен.');
			}
		}
		
		$this->template->build('account/transfer', $data, $title = 'Создание платежа');
	}
	
	//Проверка

	function _check_transfer($amount) {
		if ($amount > $this->balance_mdl->get($this->user_id)) {
			$this->form_validation->set_message('_check_transfer', 'На вашем счету недостаточно средств');
			return FALSE;
		}
		
		return TRUE;
	}

	function _user_check($username) {
		if ($this->username == $username) {
			$this->form_validation->set_message('_user_check', 'Нельзя указывать себя в качестве получателя');
			return FALSE;
		}
		
		if (!$this->users_mdl->username_check($username)) {
			$this->form_validation->set_message('_user_check', 'Получатель не найден');
			return FALSE;
		}
		
		return TRUE;
	}

	function _check_tarrif($id) {
		//Выводим все данные о тарифе
		
		$tariff = $this->tariff->get_tariff($id);
		
		$period = $this->input->post('period');
		
		if ($period == 1) {
			//Стоимость в месяц
			
			$price = $tariff['price_of_month'];
		} else {
			//Стоимость в год
			
			$price = $tariff['price_of_year'];
		}
		
		if ($price > $this->balance_mdl->get($this->user_id)) {
			$this->form_validation->set_message('_check_tarrif', 'На вашем счету недостаточно средств');
			return FALSE;
		}
		
		if ($tariff['id'] == $this->user_tariff) {
			$this->form_validation->set_message('_check_tarrif', 'Данный тариф уже установлен');
			return FALSE;
		}
		
		return TRUE;
	}

	function tariff_set() {
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'tariff','label'=>'ID тарифа','rules'=>'required|callback__check_tarrif'
			)
		);
		
		$data = array(
			'tariff'=>$this->input->post('tariff')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$tariff = $this->tariff->get_tariff($data['tariff']);
			
			if ($this->input->post('period') == 1) {
				$price = $tariff['price_of_month'];
				
				$time = 2629743;
			} else {
			
				$price = $tariff['price_of_year'];
				
				$time = 31556926;
			}
			
			//Списываем со счёта оплату
			
			$this->balance_mdl->minus($this->user_id, $price);
			
			//К текущей дате прибавляем срок действия тарифа, получаем дату до которой будет действовать тариф
			
			$date = now() + $time;
			
			$data['tariff_period'] = $date;
			
			$this->tariff->update($this->user_id, $data);
			
			/**
			 * ---------------------------------------------------------------
			 *	Записываем историю
			 * ---------------------------------------------------------------
			 */
			$this->transaction->create($this->user_id, 'Установка виртуального статуса "'.$tariff['name'].'"', $price);
			
			show_error('Виртуальный статус установлен.');
		}
		
		$data['data'] = $this->tariff->get_all();
		
		$this->template->build('account/tariff_set', $data, $title = 'Настройка виртуального статуса');
	}

	function tariff() {
		if (!$this->errors->access()) {
			return;
		}
		/**
		 Выводим установленный тариф, сколько всего осталось времени
		 
		 Затем если сабмитится продление прибавляем к дате до которой действует тариф, период на который увеличиваем, отнимаем баланс
		 
		 Проверка на сумму баланса
		 */
		$rules = array(
			array(
				'field'=>'tariff','label'=>'ID тарифа','rules'=>'required|callback__check_tarrif_long'
			)
			
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
		
			/**
			 * ---------------------------------------------------------------
			 *	Продлеваем по времени
			 1 минута	60 секунд
			 1 час	3600 секунд
			 1 день	86400 секунд
			 1 неделя	604800 секунд
			 1 месяц (30.44 дней) 	2629743 секунд
			 1 год (365.24 дней) 	 31556926 секунд
			 * ---------------------------------------------------------------
			 */
			$tariff_period = $this->tariff->period($this->user_id);
			
			$tariff = $this->tariff->get_tariff($this->user_tariff);
			
			if ($this->input->post('period') == 1) {
				//за месяц
				
				$price = $tariff['price_of_month'];
				
				$time = 2629743;
			} else {
				//за год
				
				$price = $tariff['price_of_year'];
				
				$time = 31556926;
			}
			
			//Списываем со счёта оплату
			
			$this->balance_mdl->minus($this->user_id, $price);
			
			$tariff_period = $tariff_period + $time;
			
			$data = array(
				'tariff_period'=>$tariff_period
			);
			
			$this->tariff->update($this->user_id, $data);
			
			$this->transaction->create($this->user_id, 'Продление виртуального статуса "'.$tariff['name'].'"', $price);
			
			show_error('Виртуальный статус продлен.');
		}
		
		//Выводим все данные о тарифе
		
		$data = $this->tariff->get_tariff($this->user_tariff);
		
		/**
		 * ---------------------------------------------------------------
		 *	Узнаём остаток времени
		 * ---------------------------------------------------------------
		 */
		$tariff_period = $this->tariff->period($this->user_id);
		
		//От срока когда истекает период отнимаем текущую дату
		
		$date = $tariff_period - now();
		
		$date = $date + now();
		
		$data['tariff_period'] = date_await($date);
		
		$this->template->build('account/tariff', $data, $title = 'Виртуальный статус');
	}

	function _check_tarrif_long($id) {
		//Выводим все данные о тарифе
		
		$tariff = $this->tariff->get_tariff($id);
		
		$period = $this->input->post('period');
		
		if ($period == 1) {
			//Стоимость в месяц
			
			$price = $tariff['price_of_month'];
		} else {
			//Стоимость в год
			
			$price = $tariff['price_of_year'];
		}
		
		if ($price > $this->balance_mdl->get($this->user_id)) {
			$this->form_validation->set_message('_check_tarrif_long', 'На вашем счету недостаточно средств');
			return FALSE;
		}
		
		return TRUE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Подписка на рубрики
	 * ---------------------------------------------------------------
	 */

	function categories_followers() {
		if (!$this->errors->access()) {
			return;
		}
		
		//Выбранные подписки
		
		$categories_followers = $this->input->post('category');
		
		//Кнопка
		
		$submit = $this->input->post('submit');
		
		if ($submit) {
			//Удаляем старые подписки
			
			$this->account_mdl->del_categories_followers($this->user_id);
			
			if ($categories_followers) {
			
				//Создаём массив и заносим
				
				foreach ($categories_followers as $row=>$value):
				
					$array = array(
						'user_id'=>$this->user_id,'category'=>$value,
					);
					
					$this->account_mdl->add_categories_followers($array);
					
				endforeach;
			}
			
		}
		
		//Все категории
		
		$data['categories'] = $this->designs_mdl->get_categories();
		
		//Подписки пользователя
		
		$data['categories_followers'] = $this->account_mdl->get_categories_followers($this->user_id);
		
		if ($data['categories_followers']) {
			$select = $data['categories_followers'];
			
			foreach ($select as $row=>$value):
				$select[$row] = $value['category'];
			endforeach;
			
			$data['select'] = $select;
		}
		
		$this->template->build('account/categories_followers', $data, $title = 'Подписки на рубрики');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Подписки на пользовательские работы
	 * ---------------------------------------------------------------
	 */

	function users_followers($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 50;
		
		$start_page = intval($start_page);
		
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['base_url'] = base_url().'/account/cart';
		$config['total_rows'] = $this->account_mdl->count_followers($user_id = '', $this->user_id);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->account_mdl->get_followers($start_page, $per_page, $user_id = '', $this->user_id);
		
		$this->template->build('account/users_followers', $data, $title = 'Подписки на пользовательские работы');
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Подписчики
	 * ---------------------------------------------------------------
	 */

	function followers($start_page = 0) {
	
		$this->users_mdl->update_views($this->user_id);
		
		$data['positive'] = $this->reviews_mdl->count_reviews_positive($data['id']);
		
		$data['negative'] = $this->reviews_mdl->count_reviews_negative($data['id']);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['uri_segment'] = '4';
		$config['base_url'] = base_url().'/account/followers/'.$username.'';
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
		
		$this->template->build('account/followers', $data, $title);
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Корзина
	 * ---------------------------------------------------------------
	 */

	function cart($start_page = 0) {
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		if ($this->users_mdl->logged_in()) {
			$user_id = $this->user_id;
			
			$session_id = '';
			
			$template = 'cart';
		} else {
			$user_id = '';
			
			$session_id = $this->session->userdata('session_id');
			
			$template = 'cart_no_auth';
		}
		
		$config['base_url'] = base_url().'/account/cart';
		$config['total_rows'] = $this->account_mdl->count_cart($user_id, $session_id);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->account_mdl->get_cart($start_page, $per_page, $user_id, $session_id);
		
		$this->template->build('account/'.$template.'', $data, $title = 'Корзина');
	}

	function pay_no_auth() {
		//Сначала регистрируем здесь получаем user_id
		
		$designs = $this->input->post('designs');
		
		if ( empty($designs)) {
			show_error('Выберите товары для оплаты');
		}
		
		$cart = $designs;
		$cart = implode(", ", $cart);
		
		$designs = $this->account_mdl->pay_designs($designs);
		
		//Итоговая сумма
		
		$total_amount = $this->total_amount($designs);
		
		/**
		 * ---------------------------------------------------------------
		 *	Проверяем каждый дизайн
		 * ---------------------------------------------------------------
		 */
		foreach ($designs as $row):
		
			//Если у дизайна больше одной продажи и пользователь пытается вызаказать дизайн
			
			if ($row['sales'] > 0 and $row['kind'] == 2) {
			
				show_error('Дизайн с ID '.$row['id'].' невозможно вызаказать');
			}
			
			if ($row['status'] == 2) {
				show_error('Дизайн с ID '.$row['id'].' заказан');
			}
			
		endforeach;
		
		$data['total_amount'] = $total_amount;
		
		$data['data'] = $designs;
		
		$data['cart'] = $cart;
		
		$this->template->build('account/pay', $data, $title = 'Корзина');
	}

	function newa() {
		$cart = $this->input->post('cart');
		$code = $this->input->post('code');
		$total_amount = $this->input->post('total_amount');
		
		// регистрационная информация (логин, пароль #1)
		
		// registration info (login, password #1)
		
		$mrh_login = "Openweblife";
		$mrh_pass1 = "199122x199122x";
		// номер заказа
		
		// number of order
		
		$inv_id = 1;
		// описание заказа
		
		// order description
		
		$inv_desc = "Пополнение баланса";
		// сумма заказа
		
		// sum of order
		
		$out_summ = $total_amount;
		// предлагаемая валюта платежа
		
		// default payment e-currency
		
		$in_curr = "PCR";
		// язык
		
		// language
		
		$culture = "ru";
		
		$ShpCart = $cart;
		$ShpCode = $code;
		
		// формирование подписи
		
		// generate signature
		
		$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:ShpCart=".$ShpCart.":ShpCode=".$ShpCode."");
		// форма оплаты товара
		
		// payment form
		
		$data = array(
			//'robokassaUrl'					=> 'https://merchant.roboxchange.com/Index.aspx',
			'robokassaUrl'=>'http://test.robokassa.ru/Index.aspx','rb_mrh_login'=>$mrh_login,
				'rb_payment_amount'=>$out_summ,'rb_payment_id'=>$inv_id,'rb_payment_desc'=>$inv_desc,
				'rb_sign'=>$crc,'cart'=>$cart,'code'=>$code,
		);
		
		$this->load->view('wdesigns/account/newa', $data);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Корзина/Удаление товара
	 * ---------------------------------------------------------------
	 */

	function cart_del($id = '') {
		//Если не существует товара у пользователя
		
		if (!$this->_check_cart($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->account_mdl->del('cart', $id);
		
		redirect('account/cart');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Корзина/Добавление товара
	 * ---------------------------------------------------------------
	 */

	function cart_add() {
		$id = $this->input->post('id');
		
		$kind = $this->input->post('kind');
		
		//Авторизированный пользователя
		
		if (! empty($this->user_id)) {
			$data = array(
				'user_id'=>$this->user_id,'design_id'=>$id,'date'=>now(),'kind'=>$kind
			);
		}
		//Не авторизированный
		
		else {
			$data = array(
				'session_id'=>$this->session->userdata('session_id'),'design_id'=>$id,'date'=>now(),
					'kind'=>$kind
			);
		}
		
		//Если дизайн уже был добавлен в корзину
		
		if ($this->_check_action_cart($id)) {
			echo json_encode(array(
				'success'=>FALSE,'message'=>'Товар уже добавлен',
			));
			return;
		}
		
		//Если дизайн уже был заказан
		
		if ($this->_check_purchased($id)) {
			echo json_encode(array(
				'success'=>FALSE,'message'=>'Товар уже заказан',
			));
			return;
		}
		
		//Выводим всю информацию по дизайну
		
		$design = $this->designs_mdl->get_edit($id);
		
		if ($design['sales'] > 0 and $kind == 2) {
			echo json_encode(array(
				'success'=>FALSE,'message'=>'Товар нелья выкупить',
			));
			return;
		}
		
		if ($design['user_id'] == $this->user_id) {
			echo json_encode(array(
				'success'=>FALSE,'message'=>'Товар принадлежит вам',
			));
			return;
		}
		
		$this->account_mdl->add('cart', $data);
		
		echo json_encode(array(
			'success'=>TRUE,'message'=>'Товар добавлен в <a href="/account/cart/">корзину</a>',
		));
	}

	function _check_action_cart($design_id) {
		//Авторизированный пользователь
		
		if (! empty($this->user_id)) {
			$session_id = '';
		}
		//Не авторизированный
		
		else {
			$session_id = $this->session->userdata('session_id');
		}
		
		//Если существует товар у пользователя в корзине
		
		if ($this->account_mdl->cart_check($design_id, $this->user_id, $session_id)) {
			return TRUE;
		}
		return FALSE;
	}
	
	//Удаление, проверка по id корзиныы

	function _check_cart($id) {
		//Авторизированный пользователь
		
		if (! empty($this->user_id)) {
			$session_id = '';
		}
		//Не авторизированный
		
		else {
			$session_id = $this->session->userdata('session_id');
		}
		
		//Если существует товар у пользователя в корзине
		
		if ($this->account_mdl->cart_check_del($id, $this->user_id, $session_id)) {
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Оплата товаров
	 * ---------------------------------------------------------------
	 */
	 
	 /**
	 * ---------------------------------------------------------------
	 *	Контрольная сумма
	 * ---------------------------------------------------------------
	 */

	function total_amount($designs = '') {
		$total_amount = 0;
		
		foreach ($designs as $row):
		
			if ($row['kind'] == 1):
			
				$total_amount = $total_amount + $row['price_1'];
				
				else
					: $total_amount = $total_amount + $row['price_2'];
					
			endif;
			
		endforeach;
		
		return $total_amount;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Очистка корзины, от заказанных товаров у пользователя
	 * ---------------------------------------------------------------
	 */

	function cart_clear($designs, $user_id) {
		foreach ($designs as $row):
			$design_id[] = $row['id'];
		endforeach;
		
		$this->db->where_in('design_id', $design_id);
		
		$this->db->where('user_id', $user_id);
		
		$this->db->delete('cart');
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Очистка всей корзины
	 * ---------------------------------------------------------------
	 */


	function cart_purge() {
	
		if (! empty($this->user_id)) {
			$this->db->where('user_id', $this->user_id);
		} else {
			$this->db->where('session_id', $this->session->userdata('session_id'));
		}
		
		$this->db->delete('cart');
		
		redirect('account/cart');
		
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Очистка всей корзины
	 * ---------------------------------------------------------------
	 */


	function cart_checkout() {
	
		if ( empty($this->user_id) or !$this->errors->access()) {
			redirect('login');
		}
		
		$query = 'SELECT `design`.`id`, `design`.`title`, `thisuser`.`email` AS `thisuser_email`, `thisuser`.`name` AS `thisuser_name`, `thisuser`.`surname` AS `thisuser_surname`, `thisuser`.`telephone` AS `thisuser_telephone`,  `user`.`email`, `user`.`name`, `user`.`surname` FROM `ci_cart`';
		$query .= ' JOIN `ci_designs` AS `design` ON `design`.`id` = `ci_cart`.`design_id`';
		$query .= ' JOIN `ci_users` AS `user` ON `user`.`id` = `design`.`user_id`';
		$query .= " JOIN `ci_users` AS `thisuser` ON `thisuser`.`id` = '{$this->user_id}'";
		$query .= " WHERE `ci_cart`.`user_id` = '{$this->user_id}'";
		
		foreach ($this->db->query($query)->result_array() as $row) {
		
			$message = $this->load->view('emails/purchase', $row + array(
				'my_id'=>$this->user_id,'my_name'=>$this->username
			), TRUE);
			
			//$this->common->email($user['email'], 'Запрос на покупку дизайна', $message);
			$this->common->email('sedrak.k@fabricasaitov.ru', 'Запрос на покупку Вашего дизайна', $message);
		}
		
		return $this->cart_purge();
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Форма оплаты
	 * ---------------------------------------------------------------
	 */

	function pay() {
		if (!$this->errors->access()) {
			return;
		}
		
		$designs = $this->input->post('designs');
		
		$designs = $this->account_mdl->pay_designs($designs);
		
		$total_amount = $this->total_amount($designs);
		
		if ( empty($designs)) {
			show_error('Выберите товары для оплаты');
		}
		
		if ($total_amount > $this->balance_mdl->get($this->user_id)) {
			show_error('На вашем счету недостаточно средств');
		}
		/**
		 * ---------------------------------------------------------------
		 *	Проверяем каждый дизайн
		 * ---------------------------------------------------------------
		 */
		foreach ($designs as $row):
		
			//Если у дизайна больше одной продажи и пользователь пытается вызаказать дизайн
			
			if ($row['sales'] > 0 and $row['kind'] == 2) {
			
				show_error('Дизайн с ID '.$row['id'].' невозможно вызаказать');
			}
			
			if ($row['status'] == 2) {
				show_error('Дизайн с ID '.$row['id'].' вызаказан');
			}
			
		endforeach;
		/**
		 * ---------------------------------------------------------------
		 *	После проверки выполняем изменения, добавляем в заказа, снимаем средства, прибавляем средства владельцу и т д
		 * ---------------------------------------------------------------
		 */
		//Списываем со счёта
		
		$this->balance_mdl->minus($this->user_id, $total_amount);
		
		foreach ($designs as $row):
		
			$data = array(
				'user_id'=>$this->user_id,'design_id'=>$row['id'],'date'=>now(),'kind'=>$row['kind']
			);
			
			//Добавляем в заказанные
			
			$this->account_mdl->add('purchased', $data);
			
			//Увеличиваем число заказов
			
			$this->designs_mdl->update_sales($row['id']);
			
			if ($row['kind'] == '1') {
			
				//Заказ
				$price = $row['price_1'];
			}
			//Если дизайн вызаказан переводим статус на вызаказан - 2
			
			else {
				//Выкуп
				
				$price = $row['price_2'];
				
				//Переводим в вызаказан
				
				$this->designs_mdl->enter($row['id']);
			}
			
			//Прибавляем владельцу баланс
			
			$this->balance_mdl->plus($row['user_id'], $price);
			
			//Добавляем событие
			
			$this->events->create($row['user_id'], 'Ваш дизайн "'.$row['title'].'" был заказан');
			
			/**
			 * ---------------------------------------------------------------
			 *	Продавец
			 * ---------------------------------------------------------------
			 */
			$this->events->create($row['user_id'], 'Продажа дизайна', 'sell_design');#Событие с репутацией
			
			//История продавца
			
			$this->transaction->create($row['user_id'], 'Продажа дизайна', $price);
			/**
			 * ---------------------------------------------------------------
			 *	Покупатель
			 * ---------------------------------------------------------------
			 */
			$this->events->create($this->user_id, 'Заказ дизайна', 'buy_design');#Событие с репутацией
			
			//История покупателя
			
			$this->transaction->create($this->user_id, 'Заказ дизайна', $price);
			
		endforeach;
		
		//Удаляем заказанные товары из корзины
		
		$this->cart_clear($designs, $this->user_id);
		
		//Также нужно удалить вызаказанные товары из корзины всех пользователей
		
		show_error('Все товары оплачены.');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Заказать
	 * ---------------------------------------------------------------
	 */

	function buy($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$design = $this->designs_mdl->get_edit($id)) {
			show_404('page');
		}
		
		//Если статус дизайна отличный от открыт, может быть он уже вызаказан и т д
		
		if ($design['status'] != 1) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$rules = array(
			array(
				'field'=>'design_id','label'=>'ID дизайна','rules'=>'required|callback__check_buy'
			),array(
				'field'=>'kind','label'=>'Вид','rules'=>'required'
			)
		);
		
		$data = array(
			'user_id'=>$this->user_id,'design_id'=>$id,'date'=>now(),
			//1 - заказан, 2 - вызаказан, затем расчитываеться как 1 - цена заказа 2 - цена выкупа
			
			'kind'=>$this->input->post('kind')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->account_mdl->add('purchased', $data);
			
			//Цена которую будем списывать с нашего баланса
			
			if ($this->input->post('kind') == '1') {
				$price = $design['price_1'];
			}
			//Если дизайн вызаказан переводим статус на вызаказан - 2
			
			else {
				$price = $design['price_2'];
				
				//Переводим в вызаказан
				
				$this->designs_mdl->enter($id);
			}
			
			//Увеличиваем число заказов
			
			$this->designs_mdl->update_sales($id);
			
			//Списываем со счёта
			
			$this->balance_mdl->minus($data['user_id'], $price);
			
			//Добавляем событие
			
			$this->events->create($design['user_id'], 'Ваш дизайн "'.$design['title'].'" был заказан');
			
			redirect('account/purchased');
		}
		
		$data = $design;
		
		$this->template->build('account/buy', $data, $title = 'Заказать');
	}
	
	//Нельзя покупать свой дизайн или уже заказанный, проверяем наличие средств

	function _check_buy($id) {
		//Выводим все данные о дизайне
		
		$design = $this->designs_mdl->get_edit($id);
		
		$kind = $this->input->post('kind');
		
		if ($kind == 1) {
			$price = $design['price_1'];
		} else {
			$price = $design['price_2'];
		}
		
		if ($this->account_mdl->buy_check($design['id'], $this->user_id)) {
			$this->form_validation->set_message('_check_buy', 'Данный дизайн уже заказан вами');
			return FALSE;
		}
		
		if ($design['user_id'] == $this->user_id) {
			$this->form_validation->set_message('_check_buy', 'Дизайн принадлежит вам');
			return FALSE;
		}
		
		if ($price > $this->balance_mdl->get($this->user_id)) {
			$this->form_validation->set_message('_check_buy', 'На вашем счету недостаточно средств');
			return FALSE;
		}
		
		return TRUE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Заказанные
	 * ---------------------------------------------------------------
	 */

	function purchased($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['base_url'] = base_url().'/account/purchased';
		$config['total_rows'] = $this->account_mdl->count_purchased($this->user_id);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->account_mdl->get_purchased($start_page, $per_page, $this->user_id);
		
		$this->template->build('account/purchased', $data, $title = 'Заказанные');
	}

	function _check_purchased($design_id) {
		//Если существует товар у пользователя в заказх
		
		if ($this->account_mdl->purchased_check($design_id, $this->user_id)) {
			return TRUE;
		}
		return FALSE;
	}

	function create_download($design_id) {
		//Проверяем заказан ли дизайн нами, если да то создаём защищённую загрузку
		
		//Если дизайн не был заказан
		
		if (!$this->_check_purchased($design_id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$file = $this->account_mdl->get_file($design_id);
		
		$code = md5(time());
		
		$data = array(
			'design_id'=>$design_id,'user_id'=>$this->user_id,'date'=>now(),'ip'=>$this->input->ip_address(),
				'file'=>$file,'code'=>$code,
		);
		
		$this->account_mdl->add('downloads', $data);
		
		$this->template->build('account/create_download', $data, $title = 'Заказанные');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Созданные загрузки
	 * ---------------------------------------------------------------
	 */

	function downloads($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['base_url'] = base_url().'/account/downloads';
		$config['total_rows'] = $this->account_mdl->count_purchased($this->user_id);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->account_mdl->get_downloads($start_page, $per_page, $this->user_id);
		
		$this->template->build('account/downloads', $data, $title = 'Загрузки');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Закачка файла с защитой, папка с файлами files/downloads/ защищена http
	 * ---------------------------------------------------------------
	 */

	function download($code) {
	
		if (!$data = $this->account_mdl->get_download($code)) {
			show_404('page');
		}
		
		//После сверяем ip если ip другой то выдаём ошибку
		if ($data['ip'] != $this->input->ip_address()) {
			show_error('Ip не действителен.');
		}
		
		//Затем проверяем, действительна ли ссылка по времени, если нет удаляем это поле с файлом
		//От текущей даты отнимаем дату создания загрузки, получаем время прошедшее с момента создания загрузки
		$date = now() - $data['date'];
		
		//Если время прошедшее с момента создания файла больше чем заданное время продолжительности ссылки то выдаём ошибку и УДАЛЯЕМ ЗАГРУЗКУ
		if ($date > $this->config->item('download_period')) {
			$this->account_mdl->del('downloads', $data['id']);
			show_error('Период загрузки истёк, загрузка будет удалена.');
		}
		
		/**
		 * ---------------------------------------------------------------
		 *	Загрузка
		 * ---------------------------------------------------------------
		 */
		 
		//Настояший путь к файлу
		$file = 'files/download/'.$data['file'].'';
		$type = explode('.', $file);
		$type = $type[1];
		
		//Случайное название файла
		$fname = md5(time()).'.'.$type;
		$fsize = filesize($file);
		
		//Закачка
		$fdown = $file;
		
		/**
		 Мы только что "на лету" сгенерировали файл, которого физически на сервере не существует.
		 Таким образом мы можем генерировать "виртуальные" файлы и отдавать их пользователю.
		 */
		 
		// Установлена или нет переменная HTTP_RANGE
		if (getenv('HTTP_RANGE') == '')
		// Читать и отдавать файл от самого начала
		
		{
			$f = fopen($fdown, 'r');
			
			header("HTTP/1.1 200 OK");
			header("Connection: close");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Content-Disposition: Attachment; filename=".$fname);
			header("Content-Length: ".$fsize);
			
			while (!feof($f)) {
				if (connection_aborted()) {
					fclose($f);
					break;
				}
				echo fread($f, 10000);
				sleep(1);
			}
			
			fclose($f);
		} else {// Получить значение переменной HTTP_RANGE
			preg_match("/bytes=(\d+)-/", getenv('HTTP_RANGE'), $m);
			// Размер фрагмента
			$csize = $fsize - $m[1];
			// Позиция, с которой начинать чтение файла
			$p1 = $fsize - $csize;
			// Конец фрагмента
			$p2 = $fsize - 1;
			
			// Установить позицию чтения в файле
			$f = fopen($fdown, 'r');
			fseek($f, $p1);
			
			header("HTTP/1.1 206 Partial Content");
			header("Connection: close");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Content-Disposition: Attachment; filename=".$fname);
			header("Content-Range: bytes ".$p1."-".$p2."/".$fsize);
			header("Content-Length: ".$csize);
			
			while (!feof($f)) {
				if (connection_aborted()) {
					fclose($f);
					break;
				}
				echo fread($f, 10000);
				sleep(1);
			}
			fclose($f);
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Отправка заказанного файла на email
	 * ---------------------------------------------------------------
	 */

	function to_email($design_id) {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если данный дизайн был заказан
		
		if ($this->_check_purchased($design_id)) {
			$email = $this->users_mdl->get_email($this->user_id);
			
			$file = $this->account_mdl->get_file($design_id);
			
			$file = 'files/download/'.$file;
			
			$this->common->email($email, $subject = 'Вам прислан файл', '', $file);
			
			show_error('Купленный дизайн был отправлен вам на почту.');
		} else {
			redirect('account/purchased');
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	События
	 * ---------------------------------------------------------------
	 */

	function events($start_page = 0) {
		$this->load->model('events/events_mdl');
		
		if (!$this->errors->access()) {
			return;
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$status = '';
		
		if (! empty($_GET['status'])) {
			unset($status);
			
			$status = '';
			
			if ($_GET['status'] == '1') {
				$status = 1;
			}
			
			if ($_GET['status'] == '2') {
				$status = 2;
			}
		} else {
			$status = '';
		}
		
		$config['base_url'] = base_url().'/account/events';
		$config['total_rows'] = $this->events_mdl->count_all($this->user_id, $status);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			$data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
		}
		
		$data['data'] = $this->events_mdl->get_all($start_page, $per_page, $this->user_id, $status);
		
		$this->template->build('account/events', $data, $title = 'События');
	}

	function update_event() {
		$id = $this->input->post('id');
		
		if ( empty($id)) {
			return FALSE;
		}
		
		$this->load->model('events/events_mdl');
		
		$this->events_mdl->update($id);
	}
	/**
	 * ---------------------------------------------------------------
	 *	История операция
	 * ---------------------------------------------------------------
	 */

	function transaction() {
		if (!$this->errors->access()) {
			return;
		}
		
		$data = array(
		);
		
		$data['data'] = $this->account_mdl->get_transaction($this->user_id);
		
		$this->template->build('account/transaction', $data, $title = 'История операций');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Кошельки
	 * ---------------------------------------------------------------
	 */

	function purses() {
		if (!$this->errors->access()) {
			return;
		}
		
		$data = array(
		);
		
		$data['data'] = $this->account_mdl->get_purses($this->user_id);
		
		$this->template->build('account/purses', $data, $title = 'Кошельки');
	}

	function purses_add() {
		$rules = array(
			array(
				'field'=>'purse','label'=>'Кошелек','rules'=>'required|wmr|max_length[13]'
			)
		);
		
		$data = array(
			'user_id'=>$this->user_id,'date'=>now(),'last_operation'=>now(),'purse'=>$this->input->post('purse')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->account_mdl->add('purses', $data);
			
			redirect('account/purses');
		}
		
		$this->template->build('account/purses_add', $data, $title = 'Добавить кошелек');
	}
	
	//Удаление кошелька

	function purses_del($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если не существует кошелька у пользователя
		
		if (!$this->_check_purses($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->account_mdl->del('purses', $id);
		
		redirect('account/purses');
	}
	
	//Проверка

	function _check_purses($id = '') {
		//Если существует кошелёк у пользователя
		
		if ($this->account_mdl->purse_check($id, $this->user_id)) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Заявки на вывод
	 * ---------------------------------------------------------------
	 */

	function withdraw($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'purse','label'=>'Кошелек Z','rules'=>'required'
			),array(
				'field'=>'amount','label'=>'Сумма','rules'=>'required|numeric|max_length[6]|callback__check_amount'
			),
		);
		
		$data = array(
			'user_id'=>$this->user_id,'date'=>now(),'purse'=>$this->input->post('purse'),
				'amount'=>$this->input->post('amount'),'status'=>1
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->account_mdl->add('balance_applications', $data);
			
			//Списываем со счёта
			
			$this->balance_mdl->minus($data['user_id'], $data['amount']);
			
			redirect('account/withdraw');
		}
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$config['base_url'] = base_url().'/account/withdraw';
		$config['total_rows'] = $this->account_mdl->count_applications($this->user_id);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->account_mdl->get_applications($start_page, $per_page, $this->user_id);
		
		$data['purses'] = $this->account_mdl->get_purses($this->user_id);
		
		//Комиссия - будет по тарифу
		
		$data['commission'] = $this->tariff->value($this->user_tariff, 'commission');
		
		$this->template->build('account/withdraw', $data, $title = 'Вывод средств');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Заявки на вывод/Отмена операции
	 * ---------------------------------------------------------------
	 */

	function withdraw_del($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если не существует вывода у пользователя
		
		if (!$this->_check_withdraw($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->account_mdl->cancel_applications($id, $this->user_id);
		
		redirect('account/withdraw');
	}
	
	//Проверка на удаление заявки

	function _check_withdraw($id = '') {
		//Если заявка на вывод принадлежит пользователю
		
		if ($this->account_mdl->withdraw_check($id, $this->user_id)) {
			return TRUE;
		}
		
		return FALSE;
	}
	
	//Проверка для вывода

	function _check_amount($amount) {
		if ($amount < $this->tariff->value($this->user_tariff, 'minimum_w_a')) {
			$this->form_validation->set_message('_check_amount', 'Минимальная сумма вывода '.$this->tariff->value($this->user_tariff, 'minimum_w_a').' рублей');
			return FALSE;
		}
		
		if ($amount > $this->balance_mdl->get($this->user_id)) {
			$this->form_validation->set_message('_check_amount', 'На вашем счету недостаточно средств');
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Указатели
	 * ---------------------------------------------------------------
	 */

	function ad($id = '') {
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		if (! empty($_GET['ad'])) {
			$ad = $_GET['ad'];
			
			$data['ad'] = $_GET['ad'];
			
			if ($ad = $this->account_mdl->get_ad($ad)) {
				$data['code'] = '<a href="'.base_url().'user/'.$this->username.'" target="_blank" title="'.$this->config->item('title').'"><img src="'.base_url().''.$ad['img'].'" border="0" alt="'.$this->username.' на '.$this->config->item('site').'"></a>';
			}
		}
		
		$data['ads'] = $this->account_mdl->get_ads();
		
		$this->template->build('account/ad', $data, $title = 'Указатели');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Блоги
	 * ---------------------------------------------------------------
	 */

	function blogs($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$input = array(
		);
		
		$input['user_id'] = $this->user_id;
		
		$config['base_url'] = base_url().'/account/blogs';
		$config['total_rows'] = $this->blogs_mdl->count_blogs($input);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		$data['data'] = $this->blogs_mdl->get_all($start_page, $per_page, $input);
		
		$this->template->build('account/blogs', $data, $title = 'Список записей');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Дизайны
	 * ---------------------------------------------------------------
	 */

	function designs($start_page = 0) {
		if (!$this->errors->access()) {
			return;
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$input = array(
		);
		
		if (! empty($_GET['status'])) {
			$status = '';
			
			if ($_GET['status'] == '1') {
				$status = 1;
			}
			
			if ($_GET['status'] == '2') {
				$status = 2;
			}
			
			if ($_GET['status'] == '3') {
				$status = 3;
			}
			
			$input['status'] = $status;
		}
		
		$input['user_id'] = $this->user_id;
		
		$config['base_url'] = base_url().'/account/designs';
		$config['total_rows'] = $this->designs_mdl->count_designs($input);
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			$data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
		}
		
		$categories = $this->designs_mdl->get_categories();
		
		foreach ($this->designs_mdl->get_user_designs($this->user_id, $start_page, $per_page) as $item) {
			// невротебенно же!
			$cat_name_path = implode(' &gt ', $categories[$item['category_id']]['name_path']);
			$designs[$cat_name_path][] = $item;
		}
		
		$data['data'] = $designs;
		
		$this->template->build('account/designs', $data, $title = 'Редактировать дизайны | Аккаунт');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Главная
	 * ---------------------------------------------------------------
	 */

	function index() {
		if ($this->users_mdl->logged_in()) {
			$template = 'index';
		} else {
			$template = 'index_no_auth';
		}
		
		$this->template->build('account/'.$template.'', $data = '', $title = 'Мой кабинет');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Настройки
	 * ---------------------------------------------------------------
	 */

	function settings() {
		if (!$this->errors->access()) {
			return;
		}
		
		$data = array(
		);
		
		$submit = (bool)$this->input->post('submit');
		
		if ($submit) {
			$rules = array(
				array(
					'field'=>'surname','label'=>'Фамилия','rules'=>'required|cyrillic|max_length[24]'
				),array(
					'field'=>'name','label'=>'Имя','rules'=>'required|cyrillic|max_length[24]'
				),array(
					'field'=>'sex','label'=>'Пол','rules'=>'required'
				),array(
					'field'=>'dob_day','label'=>'День рождения','rules'=>'required'
				),array(
					'field'=>'dob_month','label'=>'Месяц рождения','rules'=>'required'
				),array(
					'field'=>'dob_year','label'=>'Год рождения','rules'=>'required'
				),array(
					'field'=>'country_id','label'=>'Страна','rules'=>'required'
				),array(
					'field'=>'city_id','label'=>'Город','rules'=>'required'
				),array(
					'field'=>'website','label'=>'Web-сайт','rules'=>'max_length[64]'
				),array(
					'field'=>'short_descr','label'=>'Краткое описание','rules'=>'max_length[255]'
				),array(
					'field'=>'full_descr','label'=>'Резюме','rules'=>'max_length[10000]'
				)
			);
			
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run()) {
				$this->users_mdl->edit($this->user_id, array(
					//
					'surname'=>ucwords(strtolower($this->input->post('surname'))),
					//
					'name'=>ucwords(strtolower($this->input->post('name'))),
					//
					'sex'=>(int) $this->input->post('sex'),
					//
					'day'=>(int) $this->input->post('dob_day'),
					//
					'month'=>(int) $this->input->post('dob_month'),
					//
					'year'=>(int) $this->input->post('dob_year'),
					//
					'country_id'=>(int) $this->input->post('country_id'),
					//
					'city_id'=>(int) $this->input->post('city_id'),
					//
					'website'=>prep_url($this->input->post('website')),
					//
					'short_descr'=>htmlspecialchars($this->input->post('short_descr')),
					//
					'full_descr'=>htmlspecialchars($this->input->post('full_descr'))
				));
			}
		}
		
		if ($submit) {
			$rules = array(
				array(
					'field'=>'email','label'=>'Email','rules'=>'valid_email|max_length[48]'
				),array(
					'field'=>'icq','label'=>'ICQ','rules'=>'trim|numeric|max_length[16]'
				),array(
					'field'=>'skype','label'=>'Skype','rules'=>'trim|skype|max_length[16]'
				),array(
					'field'=>'telephone','label'=>'Телефон','rules'=>'trim|telephone|max_length[24]'
				)
			);
			
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run()) {
				$this->users_mdl->edit($this->user_id, array(
					//
					'email'=>strtolower($this->input->post('email')),
					//
					'icq'=>$this->input->post('icq'),
					//
					'skype'=>$this->input->post('skype'),
					//
					'telephone'=>$this->input->post('telephone')
				));
			}
		}
		
		if ($submit) {
			$rules = array(
				array(
					'field'=>'price_1','label'=>'Цена за час работы','rules'=>'numeric|max_length[12]'
				),array(
					'field'=>'price_2','label'=>'Цена за месяц вашей работы','rules'=>'numeric|max_length[12]'
				)
			);
			
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run()) {
				$this->account_mdl->edit_profile($this->user_id, array(
					'price_1'=>$this->input->post('price_1'),'price_2'=>$this->input->post('price_2')
				));
			}
		}
		
		if ($submit) {
			$this->users_mdl->edit_settings($this->user_id, array(
				//
				'mailer'=>(int) $this->input->post('mailer'),
				//
				'notice'=>(int) $this->input->post('notice'),
				//
				'hint'=>(int) $this->input->post('hint'),
				//
				'adult'=>(int) $this->input->post('adult')
			));
		}
		
		if ($submit and $this->input->post('password1')) {
			$rules = $rules + array(
				array(
					'field'=>'old_password','label'=>'Старый пароль','rules'=>'required|callback__password_check'
				),array(
					'field'=>'password1','label'=>'Новый пароль','rules'=>'required|min_length[6]|max_length[24]|matches[password2]'
				),array(
					'field'=>'password2','label'=>'Повтор пароля','rules'=>'required'
				)
			);
			
			$password = $this->input->post('password1');
			
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run()) {
				$this->users_mdl->change_password($this->user_id, $password);
			}
		}
		
		if ($submit and isset($_FILES['userfile'])) {
		
			$this->load->library('upload');
			$this->load->library('Image_lib');
			
			$this->upload->initialize(array(
				'upload_path'=>'./userpics/','allowed_types'=>'gif|jpg|jpeg|png','overwrite'=>TRUE,'max_size'=>'1024','max_width'=>'2048','max_height'=>'2048'
			));
			
			if ($this->upload->do_upload()) {
				$filedata = $this->upload->data();
				
				//Если изображение не стандартное удаляем
				
				if (preg_match('/gravatar/', $this->userpic) == 0) {
					unlink('.'.$this->userpic);
				}
				
				$path = './userpics/'.$filedata['orig_name'].'';
				
				$this->image_lib->initialize(array(
					'source_image'=>$path,'maintain_ratio'=>TRUE,'width'=>100,'height'=>100,'new_image'=>'./userpics/userpic'.$filedata['file_ext'].'','create_thumb'=>TRUE,'thumb_marker'=>'_'.$this->username,
				));
				
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				//Удаляем оригинал
				unlink($path);
				
				$this->userpic = '/userpics/userpic_'.$this->username.$filedata['file_ext'];
				
				//Юзерпик
				$this->users_mdl->edit($this->user_id, array(
					'userpic'=>$this->userpic,
				));
				
			} else {
				$this->userpic = 'https://secure.gravatar.com/avatar/'.md5(strtolower($this->input->post('email'))).'?rating=PG&size=100&default=monsterid';
				$data['error'] = $this->upload->display_errors();
			}
			
		}
		
		//Получаем настройки для отображения
		$data += $this->users_mdl->profile();
		$data += $this->users_mdl->get_settings($this->user_id);
		$data['created'] = date_smart($data['created']);
		$data += $this->account_mdl->get_profile($this->user_id);
		$data['age'] = date('Y') - $data['year'];
		$data['userpic'] = $this->userpic;
		
		$this->template->build('account/settings', $data, $title = 'Настройки');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Профиль
	 * ---------------------------------------------------------------
	 */

	function profile() {
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'surname','label'=>'Фамилия','rules'=>'required|cyrillic|max_length[24]'
			),array(
				'field'=>'name','label'=>'Имя','rules'=>'required|cyrillic|max_length[24]'
			),array(
				'field'=>'sex','label'=>'Пол','rules'=>'required'
			),array(
				'field'=>'dob_day','label'=>'День рождения','rules'=>'required'
			),array(
				'field'=>'dob_month','label'=>'Месяц рождения','rules'=>'required'
			),array(
				'field'=>'dob_year','label'=>'Год рождения','rules'=>'required'
			),array(
				'field'=>'country_id','label'=>'Страна','rules'=>'required'
			),array(
				'field'=>'city_id','label'=>'Город','rules'=>'required'
			),array(
				'field'=>'website','label'=>'Web-сайт','rules'=>'max_length[64]'
			),array(
				'field'=>'short_descr','label'=>'Краткое описание','rules'=>'max_length[255]'
			),array(
				'field'=>'full_descr','label'=>'Резюме','rules'=>'max_length[10000]'
			)
		);
		
		$data = array(
			'surname'=>ucwords(strtolower($this->input->post('surname'))),'name'=>ucwords(strtolower($this->input->post('name'))),
				'sex'=>$this->input->post('sex'),'day'=>$this->input->post('dob_day'),'month'=>$this->input->post('dob_month'),
				'year'=>$this->input->post('dob_year'),'country_id'=>$this->input->post('country_id'),
				'city_id'=>$this->input->post('city_id'),'website'=>prep_url($this->input->post('website')),
				'short_descr'=>htmlspecialchars($this->input->post('short_descr')),'full_descr'=>htmlspecialchars($this->input->post('full_descr'))
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->users_mdl->edit($this->user_id, $data);
		}
		
		$data = $this->users_mdl->profile();
		
		$data['created'] = date_smart($data['created']);
		
		$this->template->build('account/profile', $data, $title = 'Настройки профиля');
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Услуги
	 * ---------------------------------------------------------------
	 */

	function services() {
		if (!$this->errors->access()) {
			return;
		}
		
		//Выбранные услуги
		
		$services = $this->input->post('category');
		
		//Кнопка
		
		$submit = $this->input->post('submit');
		
		if ($submit) {
			//Удаляем старые рубрики
			
			$this->account_mdl->del_services($this->user_id);
			
			if ($services) {
				//Создаём массив и заносим
				
				foreach ($services as $row=>$value):
				
					$array = array(
						'user_id'=>$this->user_id,'category'=>$value,
					);
					
					$this->account_mdl->add_services($array);
					
				endforeach;
			}
			
		}
		
		//Для каталога
		
		$this->load->model('categories/categories_mdl');
		
		//Все услуги
		
		$data['categories'] = $this->categories_mdl->get_categories();
		
		//Услуги пользователя
		
		$data['services'] = $this->account_mdl->get_services($this->user_id);
		
		if ($data['services']) {
			$select = $data['services'];
			
			foreach ($select as $row=>$value):
				$select[$row] = $value['category'];
			endforeach;
			
			$data['select'] = $select;
		}
		
		$this->template->build('account/services', $data, $title = 'Редактировать услуги | Аккаунт');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Дополнительные данные/Редактирование
	 * ---------------------------------------------------------------
	 */

	function additional_data() {
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'price_1','label'=>'Цена за час работы','rules'=>'numeric|max_length[12]'
			),array(
				'field'=>'price_2','label'=>'Цена за месяц вашей работы','rules'=>'numeric|max_length[12]'
			)
		);
		
		$data = array(
			'price_1'=>$this->input->post('price_1'),'price_2'=>$this->input->post('price_2')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->account_mdl->edit_profile($this->user_id, $data);
		}
		
		$data = $this->account_mdl->get_profile($this->user_id);
		
		$this->template->build('account/additional', $data, $title = 'Дополнительные данные | Настройки профиля');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Контактные данные/Редактирование
	 * ---------------------------------------------------------------
	 */

	function contact_data() {
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'email','label'=>'Email','rules'=>'valid_email|max_length[48]'
			),array(
				'field'=>'icq','label'=>'ICQ','rules'=>'trim|numeric|max_length[16]'
			),array(
				'field'=>'skype','label'=>'Skype','rules'=>'trim|skype|max_length[16]'
			),array(
				'field'=>'telephone','label'=>'Телефон','rules'=>'trim|telephone|max_length[24]'
			)
		);
		
		$data = array(
			'email'=>strtolower($this->input->post('email')),'icq'=>$this->input->post('icq'),
				'skype'=>$this->input->post('skype'),'telephone'=>$this->input->post('telephone')
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->users_mdl->edit($this->user_id, $data);
		}
		
		$data = $this->users_mdl->profile();
		
		$this->template->build('account/contact', $data, $title = 'Контактные данные | Настройки профиля');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Портфолио
	 * ---------------------------------------------------------------
	 */

	function portfolio() {
		if (!$this->errors->access()) {
			return;
		}
		
		$data['portfolio'] = $this->account_mdl->get_portfolio($this->user_id);
		
		$this->template->build('account/portfolio', $data, 'Редактировать портфолио | Аккаунт');
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Портфолио/Редактирование
	 * ---------------------------------------------------------------
	 */

	function portfolio_add() {
		if (!$this->errors->access()) {
			return;
		}
		
		$this->load->library('upload');
		$this->load->library('Image_lib');
		
		$rules = array(
			array(
				'field'=>'title','label'=>'Заголовок','rules'=>'required|text|max_length[64]'
			),array(
				'field'=>'text','label'=>'Краткое описание','rules'=>'required|max_length[255]'
			)
		);
		
		if (isset($_FILES['userfile']['tmp_name'])) {
			$config['encrypt_name'] = TRUE;
			$config['upload_path'] = './files/portfolio/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1600';
			$config['max_height'] = '1200';
			
			$this->upload->initialize($config);
			unset($config);
			
			if ($this->upload->do_upload()) {
			
				$data = $this->upload->data();
				
				$path = './files/portfolio/'.$data['file_name'].'';
				
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 120;
				$config['new_image'] = './files/portfolio/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_small';
				
				$this->image_lib->initialize($config);
				
				$this->image_lib->resize();
				
				//Дальше работаем над остальными полями
				
				$this->form_validation->set_rules($rules);
				
				if ($this->form_validation->run()) {
				
					$this->db->select_max('position');
					
					$query = $this->db->get('portfolio')->row_array();
					
					$data = array(
						'user_id'=>$this->user_id,'position'=>$query['position'] + 1,'date'=>now(),
							'title'=>$this->input->post('title'),'descr'=>htmlspecialchars($this->input->post('text')),
							'small_image'=>'/files/portfolio/'.$data['raw_name'].'_small'.$data['file_ext'],
							'full_image'=>'/files/portfolio/'.$data['file_name']
					);
					
					$this->account_mdl->add_porfolio($data);
					
					redirect('account/portfolio/');
				}
				
			} else {
				$data['error'] = $this->upload->display_errors();
			}
			
		}
		
		if ( empty($data)) {
			$data = '';
		}
		
		$this->template->build('portfolio/add', $data, $title = 'Добавить изображение | Настройки профиля');
	}

	function portfolio_edit($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$this->_check_porfolio($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->load->library('upload');
		$this->load->library('Image_lib');
		
		$rules = array(
			array(
				'field'=>'title','label'=>'Заголовок','rules'=>'required|text|max_length[64]'
			),array(
				'field'=>'text','label'=>'Краткое описание','rules'=>'required|max_length[255]'
			)
		);
		
		if (isset($_FILES['userfile']['tmp_name'])) {
			$config['encrypt_name'] = TRUE;
			$config['upload_path'] = './files/portfolio/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '1000';
			$config['max_width'] = '1600';
			$config['max_height'] = '1200';
			
			$this->upload->initialize($config);
			unset($config);
			
			if ($this->upload->do_upload()) {
			
				$data = $this->upload->data();
				
				$path = './files/portfolio/'.$data['file_name'].'';
				
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 120;
				$config['new_image'] = './files/portfolio/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_small';
				
				$this->image_lib->initialize($config);
				
				$this->image_lib->resize();
				
				$small_image = '/files/portfolio/'.$data['raw_name'].'_small'.$data['file_ext'];
				$full_image = '/files/portfolio/'.$data['file_name'];
			}
			
		}
		
		//Если не существует, оставляем прошлые изображения
		
		if (!isset($small_image) or !isset($full_image)) {
			$data = $this->account_mdl->get_image($id);
			$small_image = $data['small_image'];
			$full_image = $data['full_image'];
		}
		
		//Дальше работаем над остальными полями
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$data = array(
				'title'=>$this->input->post('title'),'descr'=>htmlspecialchars($this->input->post('text')),
					'small_image'=>$small_image,'full_image'=>$full_image
			);
			
			$this->account_mdl->edit_porfolio($id, $data);
			
			redirect('account/portfolio/');
		}
		
		$data = $this->account_mdl->get_image($id);
		
		$this->template->build('portfolio/edit', $data, $title = 'Редактировать изображение | Настройки профиля');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Портфолио/Удалить изображение
	 * ---------------------------------------------------------------
	 */

	function portfolio_del($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$this->_check_porfolio($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->account_mdl->del_porfolio($id);
		
		redirect('account/portfolio/');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Портфолио/Переместить вверх
	 * ---------------------------------------------------------------
	 */

	function portfolio_up($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$this->_check_porfolio($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->account_mdl->up_portfolio($id, $this->user_id);
		
		redirect('account/portfolio/');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Портфолио/Переместить вниз
	 * ---------------------------------------------------------------
	 */

	function portfolio_down($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$this->_check_porfolio($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->account_mdl->down_portfolio($id, $this->user_id);
		
		//Перекидываем на страницу вывода изображений
		
		redirect('account/portfolio/');
	}

	function _check_porfolio($id = '') {
		if ($this->account_mdl->check_porfolio($id, $this->user_id)) {
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Удаление события
	 * ---------------------------------------------------------------
	 */

	function delete_message() {
		if (!$this->errors->access()) {
			return;
		}
		
		$id = $this->input->post('id');
		
		if ( empty($id)) {
			return FALSE;
		}
		
		$this->db->update('events', array(
			'status'=>2
		), array(
			'id'=>$id
		));
	}
	/**
	 * ---------------------------------------------------------------
	 *	Удаление события - новый вариант все
	 * ---------------------------------------------------------------
	 */

	function delete_message_all() {
		if (!$this->errors->access()) {
			return;
		}
		
		$this->db->update('events', array(
			'status'=>2
		), array(
			'user_id'=>$this->user_id
		));
	}
	/**
	 * ---------------------------------------------------------------
	 *	Юзерпик/Удаление юзерпика
	 * ---------------------------------------------------------------
	 */

	function userpic_del() {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если юзерпик не стандартный удаляем
		
		if (preg_match('/gravatar/', $this->userpic) == 0) {
			unlink('.'.$this->userpic);
		}
		
		$data = array(
			'userpic'=>'https://secure.gravatar.com/avatar/'.md5(strtolower($this->user->email)).'?rating=PG&size=100&default=monsterid'
		);
		
		$this->users_mdl->edit($this->user_id, $data);
		
		redirect('/account/settings');
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	МОДЕРАТОР
	 * ---------------------------------------------------------------
	 */
	 
	 /**
	 * ---------------------------------------------------------------
	 *	пользователи
	 * ---------------------------------------------------------------
	 */

	function users($start_page = 0) {
		$this->_moderator();
		
		if (!$this->errors->access()) {
			return;
		}
		
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$per_page = 10;
		
		$start_page = intval($start_page);
		
		if ($start_page < 0) {
			$start_page = 0;
		}
		
		$input = array(
		);
		
		if (! empty($_GET['status'])) {
			$status = '';
			
			if ($_GET['status'] == '1') {
				$status = 1;
			}
			
			if ($_GET['status'] == '2') {
				$status = 2;
			}
			
			if ($_GET['status'] == '3') {
				$status = 3;
			}
			
			$input['status'] = $status;
		}
		
		$input['user_id'] = $this->user_id;
		
		$config['base_url'] = base_url().'/account/users';
		$config['total_rows'] = $this->account_mdl->count_users();
		$config['per_page'] = $per_page;
		
		$this->pagination->initialize($config);
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($url)) {
			$url = implode("&", $url);
			$data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
		}
		
		$data['data'] = $this->account_mdl->get_users($start_page, $per_page, $input);
		
		$this->template->build('account/users', $data, $title = 'Список пользователей');
	}

	function users_ban($id = '') {
		$this->_moderator();
		
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'cause','label'=>'Причина бана','rules'=>'required|max_length[255]'
			)
		);
		
		$data = array(
			'user_id'=>$id,'cause'=>htmlspecialchars($this->input->post('cause'))
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->account_mdl->add('banned', $data);
			
			redirect('account/users');
		}
		
		$this->template->build('account/users_ban', $data, $title = 'Забанить пользователя');
	}
	
	//Модератор

	function _moderator() {
		if ($this->team != 2) {
			show_error('Вы не имеете доступа к данному разделу');
		}
	}
}
