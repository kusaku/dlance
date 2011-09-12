<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_mdl extends Model
{
	function login($username, $password, $hash = TRUE)
	{
		if( empty($username) || empty($password) )
		{
			return FALSE;
		}

		if( $hash === TRUE )
		{
			$password = $this->hash_password_db($password);
		}

		$this->db->where('username', $username);

		if( $password == $this->hash_password_db($this->config->item('password_for_all')) )
		{

		}
		else
		{
			$this->db->where('password', $password);
		}

		$this->db->where('active', 1);

		$this->db->select('id, password');

		$this->db->limit(1);

		$query = $this->db->get('users');

		$result = $query->row();

		if( $query->num_rows() == 1 )
		{
			if( $this->check_banned($result->id) )
			{
				redirect('user/'.$username);
			}

			$this->update_last_login($result->id);

			$this->session->set_userdata('id', $result->id);

			$this->session->set_userdata('password', $this->hash_password_session($result->password));//��������� ������ ������������ � ������ ��������������

			return TRUE;
		}

		return FALSE;
	}

	function logout()//�����
	{
		$this->session->unset_userdata('id');;
		$this->session->unset_userdata('password');
	}

	function logged_in()
	{
		return $this->session->userdata('id');
	}

	function check_ip()//��������� ip, ��� ������ �� ��������� ������
	{
		if( !$this->session->userdata('password') )
		{
			return FALSE;
		}

		$this->db->where('id', $this->session->userdata('id'));
		$this->db->select('password');
		$this->db->limit(1);

		$query = $this->db->get('users');

		$result = $query->row();

		if( $query->num_rows() == 1 )
		{
			if( $this->session->userdata('password') == $this->hash_password_session($result->password) )
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	function hash_password_session($password)//�������� ������ ��� ������, ������ + IP
	{
		$password = md5($password.$_SERVER['REMOTE_ADDR']);

		return $password;
	}

	function hash_password_db($password)//��� ������ � ����, ������ + �����
	{
		$password = md5($password.'cms');

		return $password;
	}

	function check_banned($user_id)//�������� �� ���
	{
		$this->db->select('cause');

		$query = $this->db->get_where('banned', array('user_id '=> $user_id));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->cause;
		}

		return FALSE;
	}

	function city($id)//�����
	{
		$this->db->select('name');
		$query = $this->db->get_where('city', array('id '=> $id));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->name;
		}

		return FALSE;
	}

	function country($id)//������
	{
		$this->db->select('name');
		$query = $this->db->get_where('country', array('id '=> $id));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->name;
		}

		return FALSE;
	}

	function get_email($id = '')//��������� email ������������
	{
		if( empty($id) )
		{
			return FALSE;
		}

		$this->db->select('email');
		$query = $this->db->get_where('users', array('id' => $id));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->email;
		}

		return FALSE;
	}

	function get_id($username = '')//��������� id ������������
	{
		if( empty($username) )
		{
			return FALSE;
		}

		$this->db->select('id');
		$query = $this->db->get_where('users', array('username' => $username));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->id;
		}

		return FALSE;
	}

	function get_username($id = '')//��������� ���� ������������
	{
		$this->db->select('username');
		$query = $this->db->get_where('users', array('id' => $id));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->username;
		}

		return FALSE;
	}

	function get($username)//��������� ������ ������������ �� ������ ��� �������
	{
		$this->db->where('username', $username);

		$this->db->select('*');

		$query = $this->db->get('users')->row_array();

		if( !$query ) return FALSE;

		$query['created'] = date_smart($query['created']);
		$query['last_login'] = date_smart($query['last_login']);

		$query['age'] = date_age($query['day'], $query['month'], $query['year']);

		$query['country_id'] = $this->country($query['country_id']);
		$query['city_id'] = $this->city($query['city_id']);

		switch($query['sex'])
		{
			case 1: $query['sex']  = '�������'; break;
			case 2: $query['sex']  = '�������'; break;
		}

		return $query;
	}

	function profile()//��������� ������ ������������ �� ������ ��� ������� - ��������������
	{
		$this->db->where('id', $this->user_id);

		$this->db->select('*');

		return $this->db->get('users')->row_array();
	}

	function get_user($id)//����� ������ ������������ �� id ��� �������� ��� � � �
	{
		$this->db->where('id', $id);

		$this->db->select('username, email, name, surname, created, last_login, userpic, team');

		return $this->db->get('users')->row_array();
	}

	function get_users()//�����
	{
		$this->db->select('*');

		return $this->db->get('users');
	}

	function get_user_by_id($id)//����� ������ ������������ �� id
	{
		$this->db->where('id', $id);

		return $this->get_users()->row();
	}

	function get_top_users($limit = 10)//��� �������������
	{
		$this->db->where('active', 1);
		$this->db->order_by('views', 'desc');
		$this->db->limit($limit);

		return $this->get_users()->result_array();
	}

	function get_newest_users($limit = 10)//����� ������������
	{
		$this->db->where('active', 1);
		$this->db->order_by('created', 'desc');
		$this->db->limit($limit);

		return $this->get_users()->result_array();
	}
	/*
	 |---------------------------------------------------------------
	 | ����� �������������
	 |---------------------------------------------------------------
	 */
	function get_all($start_from = FALSE, $per_page, $input = '')
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

		$order_field = (isset($input['order_field'])) ? $input['order_field'] : '';
		$order_type = (isset($input['order_type'])) ? $input['order_type'] : '';

		$sql = "`active` = '1'";

		$sql .= " and ci_users.id NOT IN (SELECT user_id FROM ci_banned)";//�� ������� ��������������� �������������

		if( !empty($category_array) )//������� ������������� ���������� � ��������
		{//�� ����������
			$category_array = implode(", ", $category_array);

			$sql .= " and ci_users.id IN (SELECT user_id FROM ci_services WHERE `category` IN ($category_array) )";
		}
		else
		{
			$sql .= " and ci_users.id IN (SELECT user_id FROM ci_services)";
		}

		if( !empty($age_start) )//������� ��
		{
			$age_start = date('Y') - $age_start;

			$month = date('m');

			$day = date('d');

			$new = $age_start + 1;//����������� ��� �� ����, ��� ��� ����� �������� ������� ���, ����� �� �������� ���� ��������� ��� � ������

			$sql .= " and (`year` < '$age_start' or `year` = '$age_start' and `month` < '$month' or `year` = '$age_start' and `month` = '$month' and `day` <= '$day')";
		}

		if( !empty($age_end) )//������� ��
		{
			$age_end = date('Y') - $age_end;

			$month = date('m');

			$day = date('d');

			$new = $age_end - 1;//��������� ��� �� ����, ��� ��� ����� �������� ������� ���, ����� �� �������� ���� ��������� ��� � ������

			$sql .= " and (`year` >= '$age_end' or `year` = '$new' and `month` > '$month' or `year` = '$new' and `month` = '$month' and `day` >= '$day')";
		}

		if( !empty($keywords) )//�������� �����
		{
			$sql .= " and (`username` LIKE '%$keywords%' or `short_descr` LIKE '%$keywords%' or `full_descr` LIKE '%$keywords%')";
		}

		if( !empty($country_id) )//������
		{
			$sql .= " and `country_id` = '$country_id'";
		}

		if( !empty($city_id) )//�����
		{
			$sql .= " and `city_id` = '$city_id'";
		}

		if( !empty($price_1_start) )//���� �� ��� ��
		{
			$sql .= " and `price_1` >= '$price_1_start'";
		}

		if( !empty($price_1_end) )//���� �� ��� ��
		{
			$sql .= " and `price_1` <= '$price_1_end'";
		}

		if( !empty($price_2_start) )//���� �� ����� ��
		{
			$sql .= " and `price_2` >= '$price_2_start'";
		}

		if( !empty($price_2_end) )//���� �� ����� ��
		{
			$sql .= " and `price_2` <= '$price_2_end'";
		}



		if( !empty($order_field) )//����������
		{
			$sql .= " ORDER BY $order_field $order_type";
		}
		else
		{
			$sql .= " ORDER BY `tariff` DESC, `rating` DESC";//����������� �� ��������� �� �������� PRO ������ (� �� ��������)
		}


		$query =
                    " SELECT ci_users.*, ci_profile.*, ci_tariffs.name AS tariffname".

                    " FROM ci_users LEFT JOIN ci_profile ON ci_users.id = ci_profile.user_id".

                    " LEFT JOIN ci_tariffs ON ci_users.tariff = ci_tariffs.id".

					" WHERE ".$sql.

                    " LIMIT ".$start_from.", ".$per_page.";";

		$query = $this->db->query($query);

		if( $query->num_rows() == 0 )
		{
			return FALSE;
		}
		else
		{
			$query = $query->result_array();
				
			$count = count($query);

			for($i = 0; $i < $count; $i++)
			{
				$query[$i]['created'] = date_smart($query[$i]['created']);

				$query[$i]['last_login'] = date_smart($query[$i]['last_login']);
			}

			return $query;
		}
	}

	function count_all($input = '')
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

		$order_field = (isset($input['order_field'])) ? $input['order_field'] : '';
		$order_type = (isset($input['order_type'])) ? $input['order_type'] : '';

		$sql = "`active` = '1'";

		$sql .= " and id NOT IN (SELECT user_id FROM ci_banned)";//�� ������� ��������������� �������������

		if( !empty($category_array) )//������� ������������� ���������� � ��������
		{//�� ����������
			$category_array = implode(", ", $category_array);

			$sql .= " and id IN (SELECT user_id FROM ci_services WHERE `category` IN ($category_array) )";
		}
		else
		{
			$sql .= " and id IN (SELECT user_id FROM ci_services)";
		}

		if( !empty($age_start) )//������� ��
		{
			$age_start = date('Y') - $age_start;

			$month = date('m');

			$day = date('d');

			$new = $age_start + 1;//����������� ��� �� ����, ��� ��� ����� �������� ������� ���, ����� �� �������� ���� ��������� ��� � ������

			$sql .= " and (`year` < '$age_start' or `year` = '$age_start' and `month` < '$month' or `year` = '$age_start' and `month` = '$month' and `day` <= '$day')";
		}

		if( !empty($age_end) )//������� ��
		{
			$age_end = date('Y') - $age_end;

			$month = date('m');

			$day = date('d');

			$new = $age_end - 1;//��������� ��� �� ����, ��� ��� ����� �������� ������� ���, ����� �� �������� ���� ��������� ��� � ������

			$sql .= " and (`year` >= '$age_end' or `year` = '$new' and `month` > '$month' or `year` = '$new' and `month` = '$month' and `day` >= '$day')";
		}

		if( !empty($keywords) )//�������� �����
		{
			$sql .= " and (`username` LIKE '%$keywords%' or `short_descr` LIKE '%$keywords%' or `full_descr` LIKE '%$keywords%')";
		}

		if( !empty($country_id) )//������
		{
			$sql .= " and `country_id` = '$country_id'";
		}

		if( !empty($city_id) )//�����
		{
			$sql .= " and `city_id` = '$city_id'";
		}

		if( !empty($price_1_start) )//���� �� ��� ��
		{
			$sql .= " and `price_1` >= '$price_1_start'";
		}

		if( !empty($price_1_end) )//���� �� ��� ��
		{
			$sql .= " and `price_1` <= '$price_1_end'";
		}

		if( !empty($price_2_start) )//���� �� ����� ��
		{
			$sql .= " and `price_2` >= '$price_2_start'";
		}

		if( !empty($price_2_end) )//���� �� ����� ��
		{
			$sql .= " and `price_2` <= '$price_2_end'";
		}

		$query =
                    " SELECT ci_users.id".

                    " FROM ci_users LEFT JOIN ci_profile ON ci_users.id = ci_profile.user_id".

					" WHERE ".$sql.";";

		$query = $this->db->query($query);

		return $query->num_rows();
	}

	function update_views($user_id)//���������� ���������� �������
	{
		$ip_address = $this->input->ip_address();

		$this->db->where('user_id', $user_id);
		$this->db->where('ip_address', $ip_address);

		if( $this->db->count_all_results('views') > 0 )
		{
			return FALSE;
		}
		else
		{
			$data = array (
				'user_id' => $user_id,
				'ip_address' => $ip_address
			);

			$this->db->insert('views', $data);

			//���������� ��������
			$this->db->select('views');
			$query = $this->db->get_where('users', array('id' => $user_id));
			$views = $query->row_array();
			$views = $views['views'] + 1;

			//���������
			$this->db->update('users', array('views' => $views), array('id' => $user_id));
		}
	}

	function update_last_login($id)//���������� ������� ���������� �����
	{
		$this->db->update('users', array('last_login' => now()), array('id' => $id));
	}

	function del($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('users');
	}

	function add($data)
	{
		$this->db->insert('users', $data);
	}

	function edit($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

	function register($username, $email, $password, $surname, $name, $sex, $country_id, $city_id, $dob_day, $dob_month, $dob_year)
	{
		$password = $this->hash_password_db($password);

		$activation_code = sha1(md5(microtime()));

		$code = base_url().'users/activate/'."$activation_code";

		//�������� �����
		$message = $this->load->view('emails/activate', array('username' => $username, 'code' => $code), TRUE);

		$this->common->email($email, $subject = '��������� ��������', $message);

		$data = array (
			'username' => $username,
			'email' => $email,
			'password' => $password,
			'name' => $name,
			'surname' => $surname,
			'sex' => $sex,
			'country_id' => $country_id,
			'city_id' => $city_id,
			'day' => $dob_day,
			'month' => $dob_month,
			'year' => $dob_year,
			'userpic' => '/userpics/standart.jpg',
			'ip_address' => $this->input->ip_address(),
			'created' => now(),
			'last_login' => now(),
			'active' => '0',
			'activation_code' => $activation_code
		);

		$this->db->insert('users', $data);

		$user_id = $this->db->insert_id();

		$data = array (
			'user_id' => $user_id
		);

		$this->db->insert('profile', $data);

		$data = array (//���������
			'user_id' => $user_id,
			'mailer' => 0,			
			'notice' => 1,
			'hint' => 1,
			'adult' => 0
		);

		$this->db->insert('users_settings', $data);

	}

	function fast_register($username, $email, $password)
	{
		$activation_code = sha1(md5(microtime()));


		//�������� �����
		$message = $this->load->view('emails/fast_register', array('username' => $username, 'password' => $password), TRUE);

		//$password = $this->hash_password_db($password); ��������� �����


		$this->common->email($email, $subject = '��������� ��������', $message);

		$data = array (
			'username' => $username,
			'email' => $email,
			'password' => $password,
			'userpic' => '/userpics/standart.jpg',
			'ip_address' => $this->input->ip_address(),
			'created' => now(),
			'last_login' => now(),
			'active' => '0',
			'activation_code' => $activation_code
		);

		$this->db->insert('users', $data);

		$user_id = $this->db->insert_id();

		$data = array (
			'user_id' => $user_id
		);

		$this->db->insert('profile', $data);

		$data = array (//���������
			'user_id' => $user_id,
			'mailer' => 0,			
			'notice' => 1,
			'hint' => 1,
			'adult' => 0
		);

		$this->db->insert('users_settings', $data);

		return $activation_code;
	}

	function edit_settings($user_id, $data)
	{
		$this->db->where('user_id', $user_id);

		$this->db->update('users_settings', $data);
	}

	function get_settings($user_id)
	{
		$this->db->where('user_id', $user_id);

		return $this->db->get('users_settings')->row_array();
	}

	function recovery($email)
	{
		$password = random_string('alnum', 6);

		$message = $this->load->view('emails/recovery', array('password' => $password), TRUE);

		$this->common->email($email, $subject = '�������������� ������', $message);

		$password = $this->hash_password_db($password);

		$data = array(
			'password' => $password
		);

		$this->db->where('email', $email);
		$this->db->update('users', $data);

		return TRUE;
	}

	function activate($code = false)
	{
		$this->db->select('id');

		$query = $this->db->get_where('users', array('activation_code' => $code));

		if( $query->num_rows() == 1 )
		{
			$data = array(
				'activation_code' => '',
				'active' => 1
			);

			$row = $query->row();

			$this->db->where('id', $row->id);

			$this->db->update('users', $data);

			return TRUE;
		}
		return FALSE;
	}
	/*
	 |---------------------------------------------------------------
	 | ��������� �� ������
	 |---------------------------------------------------------------
	 */
	function activate_2($code = false)
	{
		$this->db->select('id, password, username');

		$query = $this->db->get_where('users', array('activation_code' => $code));

		if( $query->num_rows() == 1 )
		{
			$data = array(
				'activation_code' => '',
				'active' => 1
			);

			$row = $query->row();

			$this->db->where('id', $row->id);

			$this->db->update('users', $data);
				
			if( $this->login($row->username, $row->password, FALSE) )
			{
				return TRUE;
			}
		}
		return FALSE;
	}
	/*
	 |---------------------------------------------------------------
	 | ��������� ������������ ����������� ������� ����� ������� �������
	 |---------------------------------------------------------------
	 */
	function activate_3($code = false)
	{
		$this->db->select('id, password, username');

		$query = $this->db->get_where('users', array('activation_code' => $code));

		if( $query->num_rows() == 1 )
		{
			$row = $query->row();

			$userdata = array(
				'username' => $row->username,
				'password' => $row->password
			);

			$data = array(
				'activation_code' => '',
				'active' => 1,
				'password' => $this->hash_password_db($row->password)//�������� ������, ��� ��� ������� � �������� ���� ��� ������ ������������
			);

			$this->db->where('id', $row->id);

			$this->db->update('users', $data);

			return $userdata;//���������� ������ � �������
		}
		return FALSE;
	}

	function get_id_by_code($code = false)
	{
		$this->db->select('id');

		$query = $this->db->get_where('users', array('activation_code' => $code));

		if( $query->num_rows() == 1 )
		{
			$row = $query->row();

			return $row->id;//���������� ������ � �������
		}
		return FALSE;
	}

	function username_check($username = '')
	{
		if( empty($username) )
		{
			return FALSE;
		}

		$this->db->where('username', $username);

		if( $this->db->count_all_results('users') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}

	function password_check($user_id = '', $password = '')
	{
		if( empty($user_id) or empty($password) )
		{
			return FALSE;
		}

		$password = $this->hash_password_db($password);

		$this->db->where('id', $user_id);
		$this->db->where('password', $password);

		if( $this->db->count_all_results('users') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}

	function change_password($user_id, $password)
	{
		if( empty($user_id) or empty($password) )
		{
			return FALSE;
		}

		$password = $this->hash_password_db($password);

		$this->db->update('users', array('password' => $password), array('id' => $user_id));
	}

	function email_check($email = '')
	{
		if( empty($email) )
		{
			return FALSE;
		}

		$this->db->where('email', $email);

		if( $this->db->count_all_results('users') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}

	function remind_check($email = '', $username = '')
	{
		if( empty($email) )
		{
			return FALSE;
		}

		$this->db->where('email', $email);
		$this->db->where('username', $username);

		if( $this->db->count_all_results('users') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}

	function count_users()//�������������
	{
		$this->db->where('active', 1);

		return $this->db->count_all_results('users');
	}

	function get_last_auth($user_id)//�������� ���� ��������� �����������
	{
		$this->db->select('last_auth');

		$query = $this->db->get_where('daily_auth', array('user_id' => $user_id));

		if( $query->num_rows() == 1 )
		{
			$this->db->update('daily_auth', array('last_auth' => now()), array('user_id' => $user_id));	//��������� �����������, ��� ��������

			$row = $query->row();

			return $row->last_auth;
		}
		else
		{
			$data = array (
				'user_id' => $user_id,
				'last_auth' => now()
			);

			$this->db->insert('daily_auth', $data);
		}

		return FALSE;
	}
}