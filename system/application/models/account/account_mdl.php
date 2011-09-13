<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_mdl extends Model
{
/*
|---------------------------------------------------------------
| Операции с базами
|---------------------------------------------------------------
*/
	function add($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function edit($table, $id, $data)
	{
		$this->db->where('id', $id);

		$this->db->update($table, $data);
	}

	function del($table, $id = '')
	{
		$this->db->where('id', $id);

		$this->db->delete($table);
	}
/*
|---------------------------------------------------------------
| Платежи
|---------------------------------------------------------------
*/
	function get_payment($id)//Выводи платеж для просмотра
	{
		$this->db->where('payments.id', $id);

		$this->db->select('payments.*, users.username, users.userpic, users.created, users.last_login, users.surname, users.name');

		$this->db->join('users', 'users.id = payments.user_id');

		$query = $this->db->get('payments')->row_array();

		if( !$query ) return FALSE;

		$query['date'] = date_smart($query['date']);

		$query['created'] = date_smart($query['created']);

		$query['last_login'] = date_smart($query['last_login']);

		if( $query['type'] == 2 )
		{
			$query['time'] = date_await($query['time']);//Осталось
		}

		$query['status_id'] = $query['status'];

		switch($query['status'])
		{
    		case 1: $query['status']  = 'Ожидание'; break;
    		case 2: $query['status']  = 'Завершён'; break;
    		case 3: $query['status']  = 'Возвращен'; break;
		}

		return $query;
	}

	function get_payments($start_from = FALSE, $per_page, $user_id)//Вывод всех платежей
	{
		$this->db->order_by('date', 'desc');

		$this->db->select('*');

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->where('recipient_id', $user_id);

		$this->db->or_where('user_id', $user_id);

		$query = $this->db->get('payments')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);

			$query[$i]['status_id'] = $query[$i]['status'];

			$query[$i]['type_id'] = $query[$i]['type'];

			$query[$i]['user'] = $this->users_mdl->get_username($query[$i]['user_id']);
			
			$query[$i]['recipient'] = $this->users_mdl->get_username($query[$i]['recipient_id']);

			switch($query[$i]['status'])
			{
    			case 1: $query[$i]['status']  = 'Ожидание'; break;
    			case 2: $query[$i]['status']  = 'Завершён'; break;
    			case 3: $query[$i]['status']  = 'Возвращен'; break;
			}

			if( $query[$i]['type'] == 2 )
			{
				$query[$i]['time'] = date_await($query[$i]['time']);//Осталось
			}

			switch($query[$i]['type'])
			{
    			case 1: $query[$i]['type']  = 'Прямой платеж'; break;
    			case 2: $query[$i]['type']  = 'С протекцией сделки'; break;
			}
		}
		
		return $query;
	}

	function count_payments($user_id = '')
	{
		$this->db->where('user_id', $user_id);

		return $this->db->count_all_results('payments');
	}

	function check($id = '', $status = '', $user_id = '')//Проверка на существование платежа, для завершения
	{
		if( !empty($status) )
		{
			$this->db->where('status', $status);
	    }

		if( !empty($user_id) )
		{
			$this->db->where('user_id', $user_id);
	    }

	    $this->db->where('id', $id);

		if( $this->db->count_all_results('payments') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}

	function enter($id)//Завершить платеж
	{
		$this->db->update('payments', array('status' => 2), array('id' => $id));

		$this->db->select('amount, recipient_id');//Выбираем сумму платежа и получателя

		$query = $this->db->get_where('payments', array('id' => $id));

		$query = $query->row_array();

		$amount = $query['amount'];
		
		$recipient_id = $query['recipient_id'];
		
		$this->balance_mdl->plus_balance($recipient_id, $amount);//Прибавляем к балансу получателя
	}
/*
|---------------------------------------------------------------
| Подписка на рубрики
|---------------------------------------------------------------
*/
	function get_categories_followers($user_id = '')//Выводим категории на которые мы подписаны
	{
		$this->db->select('categories_followers.*, designs_categories.name, designs_categories.parent_id');

		$this->db->where('user_id', $user_id);

		$this->db->join('designs_categories', 'designs_categories.id = categories_followers.category');

		return $this->db->get('categories_followers')->result_array();
	}

	function del_categories_followers($user_id = '')//Удаляем старые рубрики
	{
		$this->db->where('user_id', $user_id);

		$this->db->delete('categories_followers');
	}

	function add_categories_followers($services = '')//Вносим новые рубрики
	{
		$this->db->insert('categories_followers', $services);
	}
/*
|---------------------------------------------------------------
| Подписка
|
| user_id пользователь который подписан
| follows пользователь на которого подписаны
|
|---------------------------------------------------------------
*/
	function subscribe_check($user_id, $follows)
	{
		$this->db->where('user_id', $user_id);

		$this->db->where('follows', $follows);
		
		return $this->db->count_all_results('users_followers');
	}

	function subscribe_del($user_id, $follows)
	{
		$this->db->where('user_id', $user_id);

		$this->db->where('follows', $follows);

		$this->db->delete('users_followers');
	}

	function get_followers($start_from = FALSE, $per_page, $user_id = '', $follows = '')
	{

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('users_followers.date', 'desc');

		$this->db->select('users.username, users.userpic, users_followers.*');


		if( !empty($user_id) )//Для профиля пользователя, выводим всех кто подписан на данного пользователя
		{
			$this->db->where('users_followers.follows', $user_id);
			
			$this->db->join('users', 'users.id = users_followers.user_id');
		}

		if( !empty($follows) )//Для аккаунта пользователя, выводим всех на кого подписан данный пользователь
		{
			$this->db->where('users_followers.user_id', $follows);
			
			$this->db->join('users', 'users.id = users_followers.follows');
		}

		return $this->db->get('users_followers')->result_array();
	}

	function count_followers($user_id = '', $follows = '') 
	{
		if( !empty($user_id) )//Для профиля пользователя, выводим всех кто подписан на данного пользователя
		{
			$this->db->where('users_followers.follows', $user_id);
			
			$this->db->join('users', 'users.id = users_followers.user_id');
		}

		if( !empty($follows) )//Для аккаунта пользователя, выводим всех на кого подписан данный пользователь
		{
			$this->db->where('users_followers.user_id', $follows);
			
			$this->db->join('users', 'users.id = users_followers.follows');
		}

		$query = $this->db->get('users_followers');

		return $query->num_rows();
	}
/*
|---------------------------------------------------------------
| Загрузки
|---------------------------------------------------------------
*/
	function get_downloads($start_from = FALSE, $per_page, $user_id = '')
	{

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('downloads.date', 'desc');

		$this->db->select('downloads.*, designs.title');

		$this->db->join('designs', 'designs.id = downloads.design_id');

		$this->db->where('downloads.user_id', $user_id);

		$query = $this->db->get('downloads')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
	
			$date = now() - $query[$i]['date'];//От текущей даты отнимаем дату создания загрузки, получаем время прошедшее с момента создания загрузки
	
			$left_date = $this->config->item('download_period') - $date;//От периода на скачивание отнимаем время прошедшее с момента создания загрзуки, Получаем остаток времени

			if( $left_date < 0 )//Если остаток времени меньше нуля то удаляем
			{
				$query[$i]['left_date'] = 'Период загрузки истёк, загрузка будет удалена.';
	
				$this->del('downloads', $query[$i]['id']);//Удаляем поле с таблицы
			}
			else
			{
				$left_date = now() + $left_date;//Прибавляем  остаток к текущему времени
				$left_date = date_await($left_date);//date_await - сколько времени до события, событие это время когда время данное на загрузку истекёт
			
				$query[$i]['left_date'] = $left_date;
			}

		}

		return $query;
	}
/*
|---------------------------------------------------------------
| Загрузка файла
|---------------------------------------------------------------
*/
	function get_download($code)
	{
		$this->db->where('code', $code);

		$this->db->select('*');

		return $this->db->get('downloads')->row_array();
	}
/*
|---------------------------------------------------------------
| Купить дизайн
|---------------------------------------------------------------
*/
	function pay_designs($array = '')
	{
		$this->db->where_in('cart.id', $array);

		$this->db->select('designs.id, designs.user_id, designs.full_image, designs.small_image, designs.title, designs.price_1, designs.price_2, cart.kind, designs.status, designs.sales');

		$this->db->join('designs', 'designs.id = cart.design_id');

		return $this->db->get('cart')->result_array();
	}

	function pay_no_auth_designs($array = '')
	{
		$this->db->where_in('cart.id', $array);

		$this->db->select('designs.id, designs.user_id, designs.full_image, designs.small_image, designs.title, designs.price_1, designs.price_2, cart.kind, designs.status, designs.sales');

		$this->db->join('designs', 'designs.id = cart.design_id');

		return $this->db->get('cart')->result_array();
	}

	function buy_check($design_id = '', $user_id = '')//Проверка на существование покупки
	{
	    if( empty($design_id) or empty($user_id) )
	    {
			return FALSE;
	    }

		$this->db->where('design_id', $design_id);

		$this->db->where('user_id', $user_id);

		if( $this->db->count_all_results('purchased') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| Корзина
|---------------------------------------------------------------
*/
	function get_cart($start_from = FALSE, $per_page, $user_id = '', $session_id = '')
	{

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('cart.date', 'desc');

		$this->db->select('designs.*, cart.*');

		$this->db->join('designs', 'designs.id = cart.design_id');

	    if( !empty($user_id) )
	    {
			$this->db->where('cart.user_id', $user_id);
	    }

	    if( !empty($session_id) )
	    {
			$this->db->where('cart.session_id', $session_id);
	    }

		$query = $this->db->get('cart')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);//Дата размещения

			$query[$i]['category_id'] = $query[$i]['category'];

			$query[$i]['section'] = $this->designs_mdl->section($query[$i]['category']);

			$query[$i]['category'] = $this->designs_mdl->name($query[$i]['category']);

			$query[$i]['status_id'] = $query[$i]['status'];

			switch($query[$i]['status'])
			{
    			case 1: $query[$i]['status']  = 'Открыт'; break;
    			case 2: $query[$i]['status']  = 'Выкуплен'; break;
    			case 3: $query[$i]['status']  = 'Закрыт'; break;
			}
		}
		
		return $query;
	}

	function count_cart($user_id = '', $session_id = '') 
	{
		$this->db->select('designs.*, cart.*');

		$this->db->join('designs', 'designs.id = cart.design_id');

	    if( !empty($user_id) )
	    {
			$this->db->where('cart.user_id', $user_id);
	    }

	    if( !empty($session_id) )
	    {
			$this->db->where('cart.session_id', $session_id);
	    }

		$query = $this->db->get('cart');

		return $query->num_rows();
	}

	function cart_check($design_id = '', $user_id = '', $session_id = '')//Проверка принадлежит ли товар в корзине пользователю
	{
	    if( empty($design_id) )
	    {
			return FALSE;
	    }

		$this->db->where('design_id', $design_id);

	    if( !empty($user_id) )
	    {
			$this->db->where('user_id', $user_id);
	    }

	    if( !empty($session_id) )
	    {
			$this->db->where('session_id', $session_id);
	    }

		if( $this->db->count_all_results('cart') > 0 ) 
		{
			return TRUE;
		}

		return FALSE;
	}

	function cart_check_del($id = '', $user_id = '', $session_id = '')//Проверка принадлежит ли товар в корзине пользователю
	{
	    if( empty($id) )
	    {
			return FALSE;
	    }

		$this->db->where('id', $id);

	    if( !empty($user_id) )
	    {
			$this->db->where('user_id', $user_id);
	    }

	    if( !empty($session_id) )
	    {
			$this->db->where('session_id', $session_id);
	    }

		if( $this->db->count_all_results('cart') > 0 ) 
		{
			return TRUE;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| Купленные
|---------------------------------------------------------------
*/
	function get_purchased($start_from = FALSE, $per_page, $user_id = '')
	{

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('purchased.date', 'desc');

		$this->db->select('designs.*, purchased.*');

		$this->db->join('designs', 'designs.id = purchased.design_id');

		$this->db->where('purchased.user_id', $user_id);

		$query = $this->db->get('purchased')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);//Дата размещения

			$query[$i]['category_id'] = $query[$i]['category'];

			$query[$i]['section'] = $this->designs_mdl->section($query[$i]['category']);

			$query[$i]['category'] = $this->designs_mdl->name($query[$i]['category']);
		}
		
		return $query;
	}

	function count_purchased($user_id = '') 
	{
		$this->db->select('designs.*, purchased.*');

		$this->db->join('designs', 'designs.id = purchased.design_id');

		$this->db->where('purchased.user_id', $user_id);

		$query = $this->db->get('purchased');

		return $query->num_rows();
	}

	function purchased_check($design_id = '', $user_id = '')
	{
	    if( empty($design_id) or empty($user_id) )
	    {
			return FALSE;
	    }

		$this->db->where('design_id', $design_id);

		$this->db->where('user_id', $user_id);

		if( $this->db->count_all_results('purchased') > 0 ) 
		{
			return TRUE;
		}

		return FALSE;
	}

	function get_file($id = '')
	{
	    if( empty($id) )
	    {
			return FALSE;
	    }

		$this->db->select('dfile');
		$query = $this->db->get_where('designs', array('id' => $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->dfile;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| История
|---------------------------------------------------------------
*/
	function get_transaction($user_id = '')
	{
		$this->db->order_by('date', 'desc');

		$this->db->select('*');

		$this->db->where('user_id', $user_id);

		$query = $this->db->get('transaction')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);
		}
		
		return $query;
	}

/*
|---------------------------------------------------------------
| Кошельки
|---------------------------------------------------------------
*/
	function get_purses($user_id = '')
	{
		$this->db->order_by('date', 'desc');

		$this->db->select('*');

		$this->db->where('user_id', $user_id);

		$query = $this->db->get('purses')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);

			$query[$i]['last_operation'] = date_smart($query[$i]['last_operation']);
		}
		
		return $query;
	}

	function purse_check($id = '', $user_id = '')
	{
	    if( empty($id) or empty($user_id) )
	    {
			return FALSE;
	    }

		$this->db->where('id', $id);

		$this->db->where('user_id', $user_id);

		if( $this->db->count_all_results('purses') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| Заявки на вывод
|---------------------------------------------------------------
*/
	function get_applications($start_from = FALSE, $per_page, $user_id = '')
	{
		$this->db->order_by('date', 'desc');

		$this->db->select('*');

		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->where('user_id', $user_id);

		$this->db->where('status', 1);//Выводим только заявки которые ожидают

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

	function cancel_applications($id, $user_id)
	{
		$this->db->select('amount');

		$query = $this->db->get_where('balance_applications', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			$this->balance_mdl->plus($user_id, $row->amount);//Прибавляем баланс обратно

			$this->db->where('id', $id);//Удаляем заявку

			$this->db->delete('balance_applications');
		}

		return FALSE;
	}

	function count_applications($user_id = '')
	{
		$this->db->where('user_id', $user_id);

		return $this->db->count_all_results('balance_applications'); 
	}

	function withdraw_check($id = '', $user_id = '')
	{
	    if( empty($id) or empty($user_id) )
	    {
			return FALSE;
	    }

		$this->db->where('id', $id);

		$this->db->where('user_id', $user_id);

		$this->db->where('status', 1);//Статус должен быть в ожидании, чтобы можно было отменить

		if( $this->db->count_all_results('balance_applications') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| Указатели
|---------------------------------------------------------------
*/
	function get_ads()
	{
		$this->db->select('*');

		return $this->db->get('ad')->result_array();
	}

	function get_ad($id = '')
	{
		$this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('ad')->row_array();
	}
/*
|---------------------------------------------------------------
| Услуги
|---------------------------------------------------------------
*/

	function get_services($user_id = '')//Выводим данные группы для редактирования
	{
		$this->db->select('services.*, categories.name, categories.parent_id');

		$this->db->where('user_id', $user_id);

		$this->db->join('categories', 'categories.id = services.category');

		return $this->db->get('services')->result_array();
	}

	function del_services($user_id = '')//Удаляем старые рубрики
	{
		$this->db->where('user_id', $user_id);

		$this->db->delete('services');
	}

	function add_services($services = '')//Вносим новые рубрики
	{
		$this->db->insert('services', $services);
	}
	
/*
|---------------------------------------------------------------
| Портфолио
|---------------------------------------------------------------
*/
	function get_portfolio($user_id)//Для вывода в профиле
	{
		$this->db->order_by('position', 'desc');

		$this->db->where('user_id', $user_id);

		$this->db->select('*');

		return $this->db->get('portfolio')->result_array();
	}

	function get_image($id)//Для редактирования
	{
		$this->db->where('id', $id);

		$this->db->select('*');

		return $this->db->get('portfolio')->row_array();
	}

	function add_porfolio($data)
	{
		$this->db->insert('portfolio', $data);
	}

	function edit_porfolio($id, $data)
	{
		$this->db->where('id', $id);

		$this->db->update('portfolio', $data);
	}

	function del_porfolio($id)
	{
		$this->db->where('id', $id);

		$this->db->delete('portfolio');
	}
	
	function check_porfolio($id, $user_id)
	{
		$this->db->where('id', $id);

		if( !empty($user_id) )
		{
			$this->db->where('user_id', $user_id);
	    }
		
		return $this->db->count_all_results('portfolio');
	}

	function up_portfolio($id, $user_id)
	{
		//Выводим позицию объекта
		$this->db->select('position');

		$query = $this->db->get_where('portfolio', array('id' => $id))->row_array();

		$position = $query['position'];


		$this->db->where('position >', $position);//Проверяем есть ли что то выше нас

		$this->db->where('user_id', $this->user_id);

		if( $this->db->count_all_results('portfolio') > 0 )
		{		

			$this->db->select_min('position');//Узнаём id объекта выше нас, выше нас по минимуму

			$query = $this->db->get_where('portfolio', array('position >' => $position))->row_array();
	
			$replace_position = $query['position'];//Позиция которая выше нас по минимуму


			$this->db->update('portfolio', array('position' => $position), array('position' => $replace_position, 'user_id' => $user_id));//Заменяем на нашу позицию

			$this->db->update('portfolio', array('position' => $replace_position), array('id' => $id));//Передвигаем наш объект выше
		}
	}

	function down_portfolio($id, $user_id)
	{
		//Выводим позицию объекта
		$this->db->select('position');

		$query = $this->db->get_where('portfolio', array('id' => $id))->row_array();
		//echo $query['position'];

		$position = $query['position'];


		$this->db->where('position <', $position);//Проверяем есть ли что то ниже нас

		$this->db->where('user_id', $this->user_id);

		if( $this->db->count_all_results('portfolio') > 0 )
		{		

			$this->db->select_max('position');//Узнаём id объекта ниже нас, ниже нас по минимуму

			$query = $this->db->get_where('portfolio', array('position <' => $position))->row_array();
	
			$replace_position = $query['position'];//Позиция которая ниже нас по минимуму



			$this->db->update('portfolio', array('position' => $position), array('position' => $replace_position, 'user_id' => $user_id));//Заменяем на нашу позицию

			$this->db->update('portfolio', array('position' => $replace_position), array('id' => $id));//Передвигаем наш объект выше
		}
	}
/*
|---------------------------------------------------------------
| Профиль
|---------------------------------------------------------------
*/
	function get_profile($user_id)
	{
		$this->db->where('user_id', $user_id);

		$this->db->select('*');

		return $this->db->get('profile')->row_array();
	}

	function edit_profile($user_id, $data)
	{
		$this->db->where('user_id', $user_id);

		$this->db->update('profile', $data);
	}






/*
|---------------------------------------------------------------
| МОДЕРАТОР
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| пользователи
|---------------------------------------------------------------
*/
	function get_users($start_from = FALSE, $per_page, $input = '')//Расширенный поиск
	{
		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
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

	function count_users()
	{
		return $this->db->count_all_results('users'); 
	}
}