<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account_mdl extends Model
{
	/*
	 |---------------------------------------------------------------
	 | �������� � ������
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
	 | �������
	 |---------------------------------------------------------------
	 */
	function get_payment($id)//������ ������ ��� ���������
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
			$query['time'] = date_await($query['time']);//��������
		}

		$query['status_id'] = $query['status'];

		switch($query['status'])
		{
			case 1: $query['status']  = '��������'; break;
			case 2: $query['status']  = '�������'; break;
			case 3: $query['status']  = '���������'; break;
		}

		return $query;
	}

	function get_payments($start_from = FALSE, $per_page, $user_id)//����� ���� ��������
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
				case 1: $query[$i]['status']  = '��������'; break;
				case 2: $query[$i]['status']  = '�������'; break;
				case 3: $query[$i]['status']  = '���������'; break;
			}

			if( $query[$i]['type'] == 2 )
			{
				$query[$i]['time'] = date_await($query[$i]['time']);//��������
			}

			switch($query[$i]['type'])
			{
				case 1: $query[$i]['type']  = '������ ������'; break;
				case 2: $query[$i]['type']  = '� ���������� ������'; break;
			}
		}

		return $query;
	}

	function count_payments($user_id = '')
	{
		$this->db->where('user_id', $user_id);

		return $this->db->count_all_results('payments');
	}

	function check($id = '', $status = '', $user_id = '')//�������� �� ������������� �������, ��� ����������
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

	function enter($id)//��������� ������
	{
		$this->db->update('payments', array('status' => 2), array('id' => $id));

		$this->db->select('amount, recipient_id');//�������� ����� ������� � ����������

		$query = $this->db->get_where('payments', array('id' => $id));

		$query = $query->row_array();

		$amount = $query['amount'];

		$recipient_id = $query['recipient_id'];

		$this->balance_mdl->plus_balance($recipient_id, $amount);//���������� � ������� ����������
	}
	/*
	 |---------------------------------------------------------------
	 | �������� �� �������
	 |---------------------------------------------------------------
	 */
	function get_categories_followers($user_id = '')//������� ��������� �� ������� �� ���������
	{
		$this->db->select('categories_followers.*, designs_categories.name, designs_categories.parent_id');

		$this->db->where('user_id', $user_id);

		$this->db->join('designs_categories', 'designs_categories.id = categories_followers.category');

		return $this->db->get('categories_followers')->result_array();
	}

	function del_categories_followers($user_id = '')//������� ������ �������
	{
		$this->db->where('user_id', $user_id);

		$this->db->delete('categories_followers');
	}

	function add_categories_followers($services = '')//������ ����� �������
	{
		$this->db->insert('categories_followers', $services);
	}
	/*
	 |---------------------------------------------------------------
	 | ��������
	 |
	 | user_id ������������ ������� ��������
	 | follows ������������ �� �������� ���������
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


		if( !empty($user_id) )//��� ������� ������������, ������� ���� ��� �������� �� ������� ������������
		{
			$this->db->where('users_followers.follows', $user_id);
				
			$this->db->join('users', 'users.id = users_followers.user_id');
		}

		if( !empty($follows) )//��� �������� ������������, ������� ���� �� ���� �������� ������ ������������
		{
			$this->db->where('users_followers.user_id', $follows);
				
			$this->db->join('users', 'users.id = users_followers.follows');
		}

		return $this->db->get('users_followers')->result_array();
	}

	function count_followers($user_id = '', $follows = '')
	{
		if( !empty($user_id) )//��� ������� ������������, ������� ���� ��� �������� �� ������� ������������
		{
			$this->db->where('users_followers.follows', $user_id);
				
			$this->db->join('users', 'users.id = users_followers.user_id');
		}

		if( !empty($follows) )//��� �������� ������������, ������� ���� �� ���� �������� ������ ������������
		{
			$this->db->where('users_followers.user_id', $follows);
				
			$this->db->join('users', 'users.id = users_followers.follows');
		}

		$query = $this->db->get('users_followers');

		return $query->num_rows();
	}
	/*
	 |---------------------------------------------------------------
	 | ��������
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

			$date = now() - $query[$i]['date'];//�� ������� ���� �������� ���� �������� ��������, �������� ����� ��������� � ������� �������� ��������

			$left_date = $this->config->item('download_period') - $date;//�� ������� �� ���������� �������� ����� ��������� � ������� �������� ��������, �������� ������� �������

			if( $left_date < 0 )//���� ������� ������� ������ ���� �� �������
			{
				$query[$i]['left_date'] = '������ �������� ����, �������� ����� �������.';

				$this->del('downloads', $query[$i]['id']);//������� ���� � �������
			}
			else
			{
				$left_date = now() + $left_date;//����������  ������� � �������� �������
				$left_date = date_await($left_date);//date_await - ������� ������� �� �������, ������� ��� ����� ����� ����� ������ �� �������� ������
					
				$query[$i]['left_date'] = $left_date;
			}

		}

		return $query;
	}
	/*
	 |---------------------------------------------------------------
	 | �������� �����
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
	 | ������ ������
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

	function buy_check($design_id = '', $user_id = '')//�������� �� ������������� �������
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
	 | �������
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
			$query[$i]['date'] = date_smart($query[$i]['date']);//���� ����������

			$query[$i]['category_id'] = $query[$i]['category'];

			$query[$i]['section'] = $this->designs_mdl->section($query[$i]['category']);

			$query[$i]['category'] = $this->designs_mdl->name($query[$i]['category']);

			$query[$i]['status_id'] = $query[$i]['status'];

			switch($query[$i]['status'])
			{
				case 1: $query[$i]['status']  = '������'; break;
				case 2: $query[$i]['status']  = '��������'; break;
				case 3: $query[$i]['status']  = '������'; break;
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

	function cart_check($design_id = '', $user_id = '', $session_id = '')//�������� ����������� �� ����� � ������� ������������
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

	function cart_check_del($id = '', $user_id = '', $session_id = '')//�������� ����������� �� ����� � ������� ������������
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
	 | ���������
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
			$query[$i]['date'] = date_smart($query[$i]['date']);//���� ����������

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
	 | �������
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
	 | ��������
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
	 | ������ �� �����
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

		$this->db->where('status', 1);//������� ������ ������ ������� �������

		$query = $this->db->get('balance_applications')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);

			$query[$i]['status_id'] = $query[$i]['status'];

			switch($query[$i]['status'])
			{
				case 1: $query[$i]['status']  = '��������'; break;
				case 2: $query[$i]['status']  = '�������'; break;
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

			$this->balance_mdl->plus($user_id, $row->amount);//���������� ������ �������

			$this->db->where('id', $id);//������� ������

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

		$this->db->where('status', 1);//������ ������ ���� � ��������, ����� ����� ���� ��������

		if( $this->db->count_all_results('balance_applications') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}
	/*
	 |---------------------------------------------------------------
	 | ���������
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
	 | ������
	 |---------------------------------------------------------------
	 */

	function get_services($user_id = '')//������� ������ ������ ��� ��������������
	{
		$this->db->select('services.*, categories.name, categories.parent_id');

		$this->db->where('user_id', $user_id);

		$this->db->join('categories', 'categories.id = services.category');

		return $this->db->get('services')->result_array();
	}

	function del_services($user_id = '')//������� ������ �������
	{
		$this->db->where('user_id', $user_id);

		$this->db->delete('services');
	}

	function add_services($services = '')//������ ����� �������
	{
		$this->db->insert('services', $services);
	}

	/*
	 |---------------------------------------------------------------
	 | ���������
	 |---------------------------------------------------------------
	 */
	function get_portfolio($user_id)//��� ������ � �������
	{
		$this->db->order_by('position', 'desc');

		$this->db->where('user_id', $user_id);

		$this->db->select('*');

		return $this->db->get('portfolio')->result_array();
	}

	function get_image($id)//��� ��������������
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
		//������� ������� �������
		$this->db->select('position');

		$query = $this->db->get_where('portfolio', array('id' => $id))->row_array();

		$position = $query['position'];


		$this->db->where('position >', $position);//��������� ���� �� ��� �� ���� ���

		$this->db->where('user_id', $this->user_id);

		if( $this->db->count_all_results('portfolio') > 0 )
		{

			$this->db->select_min('position');//����� id ������� ���� ���, ���� ��� �� ��������

			$query = $this->db->get_where('portfolio', array('position >' => $position))->row_array();

			$replace_position = $query['position'];//������� ������� ���� ��� �� ��������


			$this->db->update('portfolio', array('position' => $position), array('position' => $replace_position, 'user_id' => $user_id));//�������� �� ���� �������

			$this->db->update('portfolio', array('position' => $replace_position), array('id' => $id));//����������� ��� ������ ����
		}
	}

	function down_portfolio($id, $user_id)
	{
		//������� ������� �������
		$this->db->select('position');

		$query = $this->db->get_where('portfolio', array('id' => $id))->row_array();
		//echo $query['position'];

		$position = $query['position'];


		$this->db->where('position <', $position);//��������� ���� �� ��� �� ���� ���

		$this->db->where('user_id', $this->user_id);

		if( $this->db->count_all_results('portfolio') > 0 )
		{

			$this->db->select_max('position');//����� id ������� ���� ���, ���� ��� �� ��������

			$query = $this->db->get_where('portfolio', array('position <' => $position))->row_array();

			$replace_position = $query['position'];//������� ������� ���� ��� �� ��������



			$this->db->update('portfolio', array('position' => $position), array('position' => $replace_position, 'user_id' => $user_id));//�������� �� ���� �������

			$this->db->update('portfolio', array('position' => $replace_position), array('id' => $id));//����������� ��� ������ ����
		}
	}
	/*
	 |---------------------------------------------------------------
	 | �������
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
	 | ���������
	 |---------------------------------------------------------------
	 */

	/*
	 |---------------------------------------------------------------
	 | ������������
	 |---------------------------------------------------------------
	 */
	function get_users($start_from = FALSE, $per_page, $input = '')//����������� �����
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