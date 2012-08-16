<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_mdl extends Model
{
	function add($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function edit($table, $id, $data)
	{
		$this->db->where('id', $id);

		$this->db->update($table, $data);
	}

	function del($table, $array = '')
	{
		$this->db->where_in('id', $array);

		$this->db->delete($table);
	}

	function editban($user_id, $data)
	{
		$this->db->where('user_id', $user_id);

		$this->db->update('banned', $data);
	}

	function delban($user_id)
	{
		$this->db->where('user_id', $user_id);

		$this->db->delete('banned');
	}

	function get_list($table)//Для списков и вывода услуг в аккаунта - services
	{
		$this->db->select('*');

		return $this->db->get($table)->result_array();
	}

	function get_events($input = '')  
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		$this->db->join('users', 'users.id = events.user_id');

    	$query = $this->db->get('events')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date('H:i', $query[$i]['date']);
		}

		return $query;
	}

	function login($username, $password) 
	{
		if( empty($username) || empty($password) )
		{
			return FALSE;
		}

		$password = $this->hash_password_db($password);

		$this->db->where('username', $username);
		$this->db->where('password', $password);
    	$this->db->select('id, password');
    	$this->db->limit(1);

		$query = $this->db->get('administrator');

		$result = $query->row();

		if( $query->num_rows() == 1 )
		{
			$this->session->set_userdata('administrator', $result->id);

			$this->session->set_userdata('administratorpassword', $this->hash_password_session($result->password));//Сохраняем пароль пользователя в сессии захешированный

			return TRUE;
		}

		return FALSE;
    }

	function hash_password_session($password)//Хэшируем пароль для сессии, пароль + IP
	{
		$password = md5($password.$_SERVER['REMOTE_ADDR']);

		return $password;
	}

	function hash_password_db($password)//Хэш пароля в базе, пароль + слово
	{
		$password = md5($password.'cms');

		return $password;
	}

	function logged_in()
	{
		if( $this->session->userdata('administrator') )//Если есть сессиия
		{
			$password = $this->session->userdata('administratorpassword');
			
			if( $this->check_password($password) )
			{
				return TRUE;
			}
			
			return FALSE;
		}

		return FALSE;
	}

	function check_current_password($password)//Проверяем ip, для защиты от перехвата сессии
	{
		$password = $this->hash_password_db($password);

    	$this->db->select('password');

		$query = $this->db->get('administrator');

		$result = $query->row();

		if( $query->num_rows() == 1 )
		{
			if( $password == $result->password )
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	function check_password($password)//Проверяем ip, для защиты от перехвата сессии
	{
    	$this->db->select('password');

		$query = $this->db->get('administrator');

		$result = $query->row();

		if( $query->num_rows() == 1 )
		{
			if( $password == $this->hash_password_session($result->password) )
			{
				return TRUE;
			}
		}

		return FALSE;
	}
/**
* ---------------------------------------------------------------
*  категории дизайнов
* ---------------------------------------------------------------
*/
	function get_designs_categories()//Для списков и вывода услуг в аккаунта - services
	{
		$this->db->select('id, name, parent_id');

		return $this->db->get('designs_categories')->result_array();
	}

	function get_designs_category($id)//Категория
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('designs_categories')->row_array();
	}

	function logout()//Выход
	{
		$this->session->unset_userdata('administrator');
	}
/**
* ---------------------------------------------------------------
*  Заявки на вывод
* ---------------------------------------------------------------
*/
	function get_report($id)//Категория
	{
	    $this->db->where('id', $id);

		$this->db->select('text');

		return $this->db->get('reports')->row_array();
	}

	function close_reports($reports = '')//Закрыть дизайн
	{
		$this->db->where_in('id', $reports);

		$this->db->update('reports', array('status' => 2));
	}

	function get_new_reports($limit = 10)
	{
		$this->db->limit($limit);

		$this->db->where('reports.status', 1);

		$this->db->select('reports.*, users.username, designs.title');

		$this->db->join('designs', 'designs.id = reports.design_id');

		$this->db->join('users', 'users.id = reports.user_id');

    	return $this->db->get('reports')->result_array();
	}

	function count_new_reports()
	{
		$this->db->where('status', 1);

		return $this->db->count_all_results('reports');
	}

	function get_reports($start_from = FALSE, $per_page, $input = '')
	{
		$status = (isset($input['status'])) ? $input['status'] : '';

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		if( !empty($status) )
		{
			$this->db->where('reports.status', $status);
		}

		$this->db->select('reports.*, users.username, designs.title');

		$this->db->join('designs', 'designs.id = reports.design_id');

		$this->db->join('users', 'users.id = reports.user_id');

    	$query = $this->db->get('reports')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			switch($query[$i]['status'])
			{
    			case 1: $query[$i]['status']  = 'Открыт'; break;
    			case 2: $query[$i]['status']  = 'Закрыт'; break;
			}

			$query[$i]['date'] = date_smart($query[$i]['date']);
		}

		return $query;
	}

	function count_reports()  
	{
		return $this->db->count_all_results('reports');
	}
/**
* ---------------------------------------------------------------
*  Заявки на вывод
* ---------------------------------------------------------------
*/
	function get_application($id)//Категория
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('balance_applications')->row_array();
	}

	function get_applications($start_from = FALSE, $per_page, $input = '')//Расширенный поиск
	{
		$status = (isset($input['status'])) ? $input['status'] : '';

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		if( !empty($status) )
		{
			$this->db->where('status', $status);
		}

		$this->db->select('balance_applications.*, users.username');

		$this->db->join('users', 'users.id = balance_applications.user_id');

    	$query = $this->db->get('balance_applications')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);

			$query[$i]['status_id'] = $query[$i]['status'];

			switch($query[$i]['status'])
			{
    			case 1: $query[$i]['status']  = 'Ожидание'; break;
    			case 2: $query[$i]['status']  = 'Завершён'; break;
			}
		}

		return $query;
	}

	function count_applications($input = '')  
	{
		$status = (isset($input['status'])) ? $input['status'] : '';

		if( !empty($status) )
		{
			$this->db->where('status', $status);
		}

		return $this->db->count_all_results('balance_applications');
	}
/**
* ---------------------------------------------------------------
*  История операций
* ---------------------------------------------------------------
*/
	function get_transaction($start_from = FALSE, $per_page, $input = '')//Расширенный поиск
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';
		$sort = (isset($input['sort'])) ? $input['sort'] : '';


		$order_field = (isset($input['order_field'])) ? $input['order_field'] : '';
		$order_type = (isset($input['order_type'])) ? $input['order_type'] : '';


		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->select('transaction.*, users.username');

		$this->db->join('users', 'users.id = transaction.user_id');

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		//Промежуток
		if( !empty($sort) )
		{
			$this->db->like('descr', $sort);
		}

		if( !empty($order_field) )//Сортировка
		{
			$this->db->order_by($order_field, $order_type);
		}

    	$query = $this->db->get('transaction')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);
		}

		return $query;
	}

	function total_sum_transaction($input = '')  
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';
		$sort = (isset($input['sort'])) ? $input['sort'] : '';

		$this->db->select_sum('amount');

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		//Промежуток
		if( !empty($sort) )
		{
			$this->db->like('descr', $sort);
		}

		$query = $this->db->get('transaction');
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->amount;
		}

		return FALSE;
	}

	function count_transaction($input = '')  
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		return $this->db->count_all_results('transaction');
	}
/**
* ---------------------------------------------------------------
*  История операций
* ---------------------------------------------------------------
*/
	function get_purchased($start_from = FALSE, $per_page, $input = '')//Расширенный поиск
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		$order_field = (isset($input['order_field'])) ? $input['order_field'] : '';
		$order_type = (isset($input['order_type'])) ? $input['order_type'] : '';

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->select('purchased.*, designs.title, designs.price_1, designs.price_2, designs.user_id AS seller_id');

		$this->db->join('designs', 'designs.id = purchased.design_id');

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('purchased.date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('purchased.date <=', $date_end);
		}

		if( !empty($order_field) )//Сортировка
		{
			$this->db->order_by($order_field, $order_type);
		}

    	$query = $this->db->get('purchased')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);
			
			$query[$i]['buyer'] = $this->users_mdl->get_username($query[$i]['user_id']);

			$query[$i]['seller'] = $this->users_mdl->get_username($query[$i]['seller_id']);


			if( $query[$i]['kind'] == 1 )
			{
				$query[$i]['price'] = $query[$i]['price_1'];
			}
			else
			{
				$query[$i]['price'] = $query[$i]['price_2'];
			}

			switch($query[$i]['kind'])
			{
    			case 1: $query[$i]['kind']  = 'Покупка'; break;
    			case 2: $query[$i]['kind']  = 'Выкуп'; break;
			}
		}

		return $query;
	}

	function count_purchased($input = '')  
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('purchased.date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('purchased.date <=', $date_end);
		}

		return $this->db->count_all_results('purchased');
	}
/**
* ---------------------------------------------------------------
*  Общая статистика сервиса
* ---------------------------------------------------------------
*/
	function info_count_addition($input = '')  
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		$this->db->select_sum('amount');

		$this->db->where('descr', 'Пополнение счета');//Пока

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		$query = $this->db->get('transaction');
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			if( !empty($row->amount) )
			{
				return $row->amount;
			}
			else
			{
				return 0;
			}
		}

		return FALSE;
	}

	function info_count_output($input = '')  
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		$this->db->select_sum('amount');

		$this->db->where('descr', 'Вывод средств');//Пока

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		$query = $this->db->get('transaction');
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			if( !empty($row->amount) )
			{
				return $row->amount;
			}
			else
			{
				return 0;
			}
		}

		return FALSE;
	}

	function info_count_users($input = '')  
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		$this->db->where('active', 1);

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('created >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('created <=', $date_end);
		}

		return $this->db->count_all_results('users');
	}

	function info_count_designs($input = '', $user_id = '')//Всего дизайнов
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		if( !empty($status) )//Статус
		{
			$this->db->where('status', $status);
		}

		if( !empty($user_id) )//Пользователь
		{
			$this->db->where('user_id', $user_id);
		}

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		return $this->db->count_all_results('designs');
	}

	function info_count_purchased($input = '', $kind = '', $user_id = '')//Всего покупок
	{
		$date_start = (isset($input['date_start'])) ? $input['date_start'] : '';
		$date_end = (isset($input['date_end'])) ? $input['date_end'] : '';

		if( !empty($kind) )//Вид
		{
			$this->db->where('kind', $kind);
		}

		if( !empty($user_id) )//Пользователь
		{
			$this->db->where('user_id', $user_id);
		}

		//Промежуток
		if( !empty($date_start) )
		{
			$this->db->where('date >=', $date_start);
		}

		if( !empty($date_end) )
		{
			$this->db->where('date <=', $date_end);
		}

		return $this->db->count_all_results('purchased');
	}

	function info_count_resources($balance = '')//Всего средств в обороте, подсчитываем всю сумму баланса у всех пользователей
	{
		if( !empty($balance) )//Если задан минимум, то считаем сумму только у тех пользователей, которые достигли минимума
		{
			$this->db->where('balance >=', $balance);
		}

		$this->db->select_sum('balance');

		$query = $this->db->get('users');
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->balance;
		}

		return FALSE;
	}
/**
* ---------------------------------------------------------------
*  Категории
* ---------------------------------------------------------------
*/

	function get_help_category($id)//Категория
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('help_categories')->row_array();
	}
/**
* ---------------------------------------------------------------
*  Категории
* ---------------------------------------------------------------
*/

	function get_category($id)//Категория
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('categories')->row_array();
	}

/**
* ---------------------------------------------------------------
*  Профиль
* ---------------------------------------------------------------
*/
	function access()
	{
		$this->db->select('*');

		$this->db->where('id', 1);

		return $this->db->get('administrator')->row_array();
	}

/**
* ---------------------------------------------------------------
*  Пользователи
* ---------------------------------------------------------------
*/
	function get_user($id)//Получение одного пользователя по логину для профиля
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		$query = $this->db->get('users')->row_array();
		
		if( !$query ) return FALSE;

		$query['created'] = date_smart($query['created']);
		$query['last_login'] = date_smart($query['last_login']);

		$query['age'] = date_age($query['day'], $query['month'], $query['year']);


		switch($query['sex'])
		{
    		case 1: $query['sex']  = 'Мужской'; break;
    		case 2: $query['sex']  = 'Женский'; break;
		}
	
		return $query;
	}

	function get_users($start_from = FALSE, $per_page, $input)//Расширенный поиск
	{
		$keywords = (isset($input['keywords'])) ? $input['keywords'] : '';

		$order_field = (isset($input['order_field'])) ? $input['order_field'] : '';
		$order_type = (isset($input['order_type'])) ? $input['order_type'] : '';

		if( !empty($order_field) )//Сортировка
		{
			$this->db->order_by($order_field, $order_type);
		}
		else
		{
			$this->db->order_by('created', 'desc');
		}

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		if( !empty($keywords) )//Ключевые слова
		{
			$this->db->like('username', $keywords);
		}

		$this->db->select('*');

    	$query = $this->db->get('users')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['created'] = date_smart($query[$i]['created']);
	
			$query[$i]['last_login'] = date_smart($query[$i]['last_login']);
		}

		return $query;
	}


	function count_users($input)  
	{
		$keywords = (isset($input['keywords'])) ? $input['keywords'] : '';
		$age_start = (isset($input['age_start'])) ? $input['age_start'] : '';
		$age_end = (isset($input['age_end'])) ? $input['age_end'] : '';
		$country_id = (isset($input['country_id'])) ? $input['country_id'] : '';
		$city_id = (isset($input['city_id'])) ? $input['city_id'] : '';
		$price_1_start = (isset($input['price_1_start'])) ? $input['price_1_start'] : '';
		$price_1_end = (isset($input['price_1_end'])) ? $input['price_1_end'] : '';
		$price_2_start = (isset($input['price_2_start'])) ? $input['price_2_start'] : '';
		$price_2_end = (isset($input['price_2_end'])) ? $input['price_2_end'] : '';
		$category_array = (isset($input['category_array'])) ? $input['category_array'] : '';

		if( !empty($keywords) )//Ключевые слова
		{
			$this->db->like('username', $keywords);
		}

		return $this->db->count_all_results('users');
	}
/**
* ---------------------------------------------------------------
*  Дизайны
* ---------------------------------------------------------------
*/

	function close_designs($designs = '')//Закрыть дизайн
	{
		$this->db->where_in('id', $designs);

		$this->db->update('designs', array('status' => 3));
	}

	function moder_designs($designs = '')//Модерирование
	{
		$this->db->where_in('id', $designs);

		$this->db->update('designs', array('moder' => 1));
	}

	function design_category($id)//Категория
	{
		$this->db->select('category');
		$query = $this->db->get_where('designs', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->category;
		}

		return FALSE;
	}

	function count_designs($input = '')  
	{
		$status = (isset($input['status'])) ? $input['status'] : '';

		if( !empty($status) ) 
		{
			$this->db->where('status', $status);
		}

		return $this->db->count_all_results('designs'); 
	}

	function get_designs($start_from, $per_page, $input = '')
	{
		$status = (isset($input['status'])) ? $input['status'] : '';

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('date', 'desc');

		$this->db->select('*');

		if( !empty($status) ) 
		{
			$this->db->where('status', $status);
		}

		$query = $this->db->get('designs')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);

			$query[$i]['category'] = $this->categories_mdl->name($query[$i]['category']);
		
			switch($query[$i]['status'])
			{
    			case 1: $query[$i]['status']  = 'Открыт'; break;
    			case 2: $query[$i]['status']  = 'Выкуплен'; break;
    			case 3: $query[$i]['status']  = 'Закрыт'; break;
			}
		}
		
		return $query;
	}

	function mailer($mailer, $data)//Рассылка
	{	
		$count = 0;

		foreach ($mailer as $row)
		{
			$email = $row['email'];

			$subject = $data['title'];

			$message = $data['text'];

			$file = $data['file'];

			$this->common->email($email, $subject, $message, $file);

			$count++;
		}

		return $count;
	}

	function get_mailer()//Выводим тех кто помечен на рассылку
	{
		$this->db->select('users_settings.mailer, users.username, users.surname, users.name, users.email');

		$this->db->where('users_settings.mailer', 1);

		$this->db->from('users_settings');

		$this->db->join('users', 'users.id = users_settings.user_id');
		
		return $this->db->get()->result_array();
	}

/**
* ---------------------------------------------------------------
*  Страницы
* ---------------------------------------------------------------
*/

	function get_page($id)//Страница
	{
	    $this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('pages')->row_array();
	}

	function get_pages($start_from = FALSE, $per_page)//Страницы
	{
		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->select('*');

		return $this->db->get('pages')->result_array();
	}

	function count_pages()
	{
		return $this->db->count_all_results('pages'); 
	}
/**
* ---------------------------------------------------------------
*  Настройки
* ---------------------------------------------------------------
*/

	function get_rating()
	{
		$this->db->select('*');

		$query = $this->db->get('rating');

		$data = $query->result_array();

		$array = array();

		foreach($data as $row):

			$array[$row['param']] = $row['value'];

		endforeach;

		return $array;
	}
/**
* ---------------------------------------------------------------
*  Настройки
* ---------------------------------------------------------------
*/
	function get_settings()
	{
		$this->db->select('*');

		$query = $this->db->get('settings');

		$data = $query->result_array();

		$array = array();

		foreach($data as $row):

			$array[$row['param']] = $row['value'];

		endforeach;

		return $array;
	}

	function edit_settings($data)
	{
		foreach($data as $row => $value):

			$this->db->update('settings', array('value' => $value), array('param' =>  $row));

		endforeach;
	}

	function edit_rating($data)
	{
		foreach($data as $row => $value):

			$this->db->update('rating', array('value' => $value), array('param' =>  $row));

		endforeach;
	}
}