<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Controller
{
	public $user_id;

	public $username;

	public $userpic;

	public $user_tariff;

	public $adult;

	public $team;

	function __construct()
	{
		parent::Controller();
		$this->load->model('categories/categories_mdl');
		$this->load->model('balance/balance_mdl');
		$this->load->model('blogs/blogs_mdl');
		$this->load->model('designs/designs_mdl');
		$this->load->helper('highslide');
		$this->load->model('account/account_mdl');
		$this->load->library('pagination');
		if( $this->users_mdl->logged_in() )
		{
			$this->user_id = $this->session->userdata('id');

			$user = $this->users_mdl->get_user_by_id($this->user_id);

			$this->username = $user->username;

			$this->userpic = $user->userpic;

			$this->team = $user->team;

			$this->user_tariff = $this->tariff->id($this->user_id);

			$this->adult = $this->settings->value($this->user_id, 'adult');
		}
		else
		{
			$this->adult = 0;
		}
	}
	/*
	 |---------------------------------------------------------------
	 | ROBOKASSA
	 |---------------------------------------------------------------
	 */
	function balance()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		// ��������������� ���������� (�����, ������ #1)
		// registration info (login, password #1)
		$mrh_login = "Openweblife";
		$mrh_pass1 = "199122x199122x";
		// ����� ������
		// number of order
		$inv_id = 1;
		// �������� ������
		// order description
		$inv_desc = "���������� �������";
		// ����� ������
		// sum of order
		$out_summ = "";
		// ������������ ������ �������
		// default payment e-currency
		$in_curr = "PCR";
		// ����
		// language
		$culture = "ru";
		// ������������ �������
		// generate signature
		$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
		// ����� ������ ������
		// payment form


		$data = array
		(
		//'robokassaUrl'          => 'https://merchant.roboxchange.com/Index.aspx',
            'robokassaUrl'          => 'http://test.robokassa.ru/Index.aspx',
            'rb_mrh_login'          => $mrh_login,
            'rb_payment_amount'     => $out_summ,
            'rb_payment_id'         => $inv_id,
            'rb_payment_desc'       => $inv_desc,
            'rb_sign'               => $crc
		);

		$this->template->build('account/balance_r', $data, $title = '���������� ������� ����� ���������');
	}

	function result_r()
	{
		// ��������������� ���������� (������ #2)
		// registration info (password #2)
		$mrh_pass2 = "199122x199122x";

		//��������� �������� �������
		//current date
		$tm=getdate(time()+9*3600);
		$date="$tm[year]-$tm[mon]-$tm[mday] $tm[hours]:$tm[minutes]:$tm[seconds]";

		// ������ ����������
		// read parameters
		$out_summ = $_REQUEST["OutSum"];
		$inv_id = $_REQUEST["InvId"];
		$crc = $_REQUEST["SignatureValue"];


		if( !empty($_REQUEST["ShpCart"]) )//������� ��� ������������
		{
			$ShpCart = $_REQUEST["ShpCart"];
		}

		if( !empty($_REQUEST["ShpCode"]) )//������� ��� ������������
		{
			$ShpCode = $_REQUEST["ShpCode"];
		}

		$crc = strtoupper($crc);

		if( !empty($ShpCart) )//������� ��� ������������
		{
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:ShpCart=".$ShpCart.":ShpCode=".$ShpCode.""));
		}
		else
		{
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));
		}



		// �������� ������������ �������
		// check signature
		if ($my_crc !=$crc)
		{
			echo "bad sign\n";
			exit();
		}

		// ������� ������� ����������� ��������
		// success
		echo "OK$inv_id\n";
	}

	function tes($code = '')
	{
		$userdata = $this->users_mdl->activate_3($code);

		$data['username'] = $userdata['username'];

		$data['password'] = $userdata['password'];

		$this->template->build('account/tes', $data, $title = '�����������');
	}

	function succes_r()
	{
		// ��������������� ���������� (������ #1)
		// registration info (password #1)
		$mrh_pass1 = "199122x199122x";

		// ������ ����������
		// read parameters
		$out_summ = $_REQUEST["OutSum"];
		$inv_id = $_REQUEST["InvId"];
		$crc = $_REQUEST["SignatureValue"];
		$crc = strtoupper($crc);

		if( !empty($_REQUEST["ShpCart"]) )//������� ��� ������������
		{
			$ShpCart = $_REQUEST["ShpCart"];
		}

		if( !empty($_REQUEST["ShpCode"]) )//������� ��� ������������
		{
			$ShpCode = $_REQUEST["ShpCode"];
		}

		if( !empty($ShpCart) )//������� ��� ������������
		{
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:ShpCart=".$ShpCart.":ShpCode=".$ShpCode.""));
		}
		else
		{
			$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));
		}


		// �������� ������������ �������
		// check signature
		if ($my_crc != $crc)
		{
			echo "bad sign\n";
			exit();
		}

		if ( !empty($ShpCart) )
		{
			$this->result_pay($ShpCart, $ShpCode);
				
			redirect('account/tes/'.$ShpCode);
		}
		else
		{

			/*
			 |---------------------------------------------------------------
			 | ���������� �����
			 |---------------------------------------------------------------
			 */
			$this->balance_mdl->plus($this->user_id, $out_summ);

			$this->transaction->create($this->user_id, '���������� �����', $out_summ);

			redirect('account');
		}
	}



	function result_pay($designs, $ShpCode)
	{
		$user_id = $this->users_mdl->get_id_by_code($ShpCode);

		$designs = $this->account_mdl->pay_no_auth_designs($designs);
		/*
		 |---------------------------------------------------------------
		 | ����� �������� ��������� ���������, ��������� � �������, ������� ��������, ���������� �������� ���������, ���������� ������ �� ����� � � �
		 |---------------------------------------------------------------
		 */
		foreach($designs as $row):

		$email = $this->users_mdl->get_email($user_id);

		$file = $this->account_mdl->get_file($row['id']);

		$file = 'files/download/'.$file;

		$this->common->email($email, $subject = '��� ������� ����', '', $file);

		$data = array (
				'user_id' => $user_id,
				'design_id' => $row['id'],
				'date' => now(),
				'kind' => $row['kind']
		);

		$this->account_mdl->add('purchased', $data);//��������� � ���������


		$this->designs_mdl->update_sales($row['id']);//����������� ����� �������

		if( $row['kind'] == '1' )
		{
			$this->balance_mdl->plus($row['user_id'], $row['price_1']);//���������� ��������� ���� �� �������
		}
		else//���� ������ �������� ��������� ������ �� �������� - 2
		{
			$this->balance_mdl->plus($row['user_id'], $row['price_2']);//���������� ��������� ���� �� �����

			$this->designs_mdl->enter($row['id']);//��������� � ��������
		}


		$this->events->create($row['user_id'], '��� ������ "'.$row['title'].'" ��� ������');//��������� �������


		/*
		 |---------------------------------------------------------------
		 | ��������� ��������� ��������
		 |---------------------------------------------------------------
		 */
		$this->events->create($row['user_id'], '������� �������', 'sell_design');#������� � ����������

		/*
		 |---------------------------------------------------------------
		 | ��������� ��������� ����������
		 |---------------------------------------------------------------
		 */
		$this->events->create($user_id, '������� �������', 'buy_design');#������� � ����������

		endforeach;
	}

	function fail_r()
	{
		show_error('�� ���������� �� ������.');
	}
	/*
	 |---------------------------------------------------------------
	 | �������
	 |---------------------------------------------------------------
	 */
	function payments($start_page = 0)//�����
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$per_page = 10;

		$start_page = intval($start_page);
		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$config['base_url'] = base_url().'/account/payments';
		$config['total_rows'] = $this->account_mdl->count_payments($this->user_id);
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		$data['data'] = $this->account_mdl->get_payments($start_page, $per_page, $this->user_id);

		$this->template->build('account/payments', $data, $title = '������ ��������');
	}

	function payments_view($id = '')//�������� �������
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$data = $this->account_mdl->get_payment($id))
		{
			show_404('page');
		}

		if( $data['user_id'] != $this->user_id and $data['recipient_id'] != $this->user_id )//���� ������ �� ��������� � ������������
		{
			redirect('account/payments');
		}

		$rules = array
		(
		array (
				'field' => 'payment_id', 
				'label' => 'ID �������',
				'rules' => 'required|callback__check_payment'
				)
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->balance_mdl->plus($data['recipient_id'], $data['amount']);//��������� �� �����

					$this->events->create($data['user_id'], '������ � ID '.$data['id'].' ��� ������');//��������� �������

					$update = array (
				'status' => 2
					);
						
					$this->account_mdl->edit('payments', $data['id'], $update);

					$username = $this->users_mdl->get_username($data['user_id']);

					$this->transaction->create($data['recipient_id'], '��������� ������� �� ������������ "'.$username.'"', $data['amount']);

					show_error('������� �������.');
				}

				$this->template->build('account/payments_view', $data, $title = '�������');
	}

	//�������� �������� �������, ���� �� ��� ���������, ���� ���� ������� ��� ��������� � ��������, ����������� �� ������ ������������
	function _check_payment($id)
	{
		$payment = $this->account_mdl->get_payment($id);//������� ��� ������ � �������

		if( $payment['type'] == 2 )
		{
			$code = $this->input->post('code');

			if( empty($code) )
			{
				$this->form_validation->set_message('_check_payment', '�� ����� ��� ���������');

				return FALSE;
			}
				
			if( $payment['code'] != $code )
			{
				$this->form_validation->set_message('_check_payment', '�� ����� ����� ��� ���������');

				return FALSE;
			}
		}

		if( $payment['recipient_id'] != $this->user_id )
		{
			$this->form_validation->set_message('_check_payment', '������ �� ������������ ���');

			return FALSE;
		}

		if( $payment['status_id'] != 1 )
		{
			$this->form_validation->set_message('_check_payment', '������ ��� �������');

			return FALSE;
		}

		return TRUE;
	}

	function transfer()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'type', 
				'label' => '��� �������',
				'rules' => 'required'
				),
				array (
				'field' => 'recipient', 
				'label' => '����������',
				'rules' => 'required|max_length[15]|callback__user_check'
				),
				array (
				'field' => 'amount', 
				'label' => '�����',
				'rules' => 'required|numeric|max_length[6]|callback__check_transfer'
				),
				array (
				'field' => 'text', 
				'label' => '�����������',
				'rules' => 'required|max_length[10000]'
				)
				);

				$data = array (
			'user_id' => $this->user_id,
			'recipient_id' => $this->input->post('recipient'),
			'date' => now(),
			'type' => $this->input->post('type'),
			'code' => '',
			'time' => $this->input->post('time'),
			'amount' => $this->input->post('amount'),
			'text' => htmlspecialchars($this->input->post('text')),
			'status' => 1
				);

				$recipient = $this->input->post('recipient');//��� �������

				$data['recipient_id'] = $this->users_mdl->get_id($recipient);

				$recipient_id = $data['recipient_id'];//��� �������

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					if( $data['type'] == 2 )
					{
						$data['code'] = random_string('alnum', 6);//������ ��� ���������

						//���� ����������� ������� ����������� 86400 - ���� ����
						$data['time'] = $data['time'] * 86400;//������� ����� ������� �� �������

						$data['time'] = NOW() + $data['time'];//���������� ������� ����
					}

					$this->account_mdl->add('payments', $data);

					$this->balance_mdl->minus($this->user_id, $data['amount']);//��������� �� �����





					if( $data['type'] == 2 )
					{
						$this->transaction->create($this->user_id, '������� ������� � ����� ��������� ������������ "'.$recipient.'"', $data['amount']);

						show_error('������� ��������. ��� ���������: '.$data['code'].'');
					}
					else
					{
						$this->transaction->create($this->user_id, '������� ������� ������������ "'.$recipient.'"', $data['amount']);

						show_error('������� ��������.');
					}
				}

				$this->template->build('account/transfer', $data, $title = '�������� �������');
	}

	function _check_transfer($amount)//��������
	{
		if( $amount > $this->balance_mdl->get($this->user_id) )
		{
			$this->form_validation->set_message('_check_transfer', '�� ����� ����� ������������ �������');
			return FALSE;
		}

		return TRUE;
	}

	function _user_check($username)
	{
		if( $this->username == $username )
		{
			$this->form_validation->set_message('_user_check', '������ ��������� ���� � �������� ����������');
			return FALSE;
		}

		if( !$this->users_mdl->username_check($username) )
		{
			$this->form_validation->set_message('_user_check', '���������� �� ������');
			return FALSE;
		}

		return TRUE;
	}

	function _check_tarrif($id)
	{
		$tariff = $this->tariff->get_tariff($id);//������� ��� ������ � ������

		$period = $this->input->post('period');

		if( $period == 1 )
		{
			$price = $tariff['price_of_month'];//��������� � �����
		}
		else
		{
			$price = $tariff['price_of_year'];//��������� � ���
		}

		if( $price > $this->balance_mdl->get($this->user_id) )
		{
			$this->form_validation->set_message('_check_tarrif', '�� ����� ����� ������������ �������');
			return FALSE;
		}

		if( $tariff['id'] == $this->user_tariff )
		{
			$this->form_validation->set_message('_check_tarrif', '������ ����� ��� ����������');
			return FALSE;
		}

		return TRUE;
	}

	function tariff_set()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'tariff', 
				'label' => 'ID ������',
				'rules' => 'required|callback__check_tarrif'
				)
				);

				$data = array (
			'tariff' => $this->input->post('tariff')
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$tariff = $this->tariff->get_tariff($data['tariff']);

					if( $this->input->post('period') == 1 )
					{
						$price = $tariff['price_of_month'];

						$time = 2629743;
					}
					else
					{

						$price = $tariff['price_of_year'];

						$time = 31556926;
					}


					$this->balance_mdl->minus($this->user_id, $price);//��������� �� ����� ������


					$date = now() + $time;//� ������� ���� ���������� ���� �������� ������, �������� ���� �� ������� ����� ����������� �����

					$data['tariff_period'] = $date;

					$this->tariff->update($this->user_id,  $data);


					/*
					 |---------------------------------------------------------------
					 | ���������� �������
					 |---------------------------------------------------------------
					 */
					$this->transaction->create($this->user_id, '��������� ������������ ������� "'.$tariff['name'].'"', $price);

					show_error('����������� ������ ����������.');
				}

				$data['data'] = $this->tariff->get_all();

				$this->template->build('account/tariff_set', $data, $title = '��������� ������������ �������');
	}

	function tariff()
	{
		if( !$this->errors->access() )
		{
			return;
		}
		/*
		 ������� ������������� �����, ������� ����� �������� �������

		 ����� ���� ���������� ��������� ���������� � ���� �� ������� ��������� �����, ������ �� ������� �����������, �������� ������

		 �������� �� ����� �������
		 */
		$rules = array
		(
		array (
				'field' => 'tariff', 
				'label' => 'ID ������',
				'rules' => 'required|callback__check_tarrif_long'
				)

				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{

					/*
					 |---------------------------------------------------------------
					 | ���������� �� �������
					 1 ������	60 ������
					 1 ���	3600 ������
					 1 ����	86400 ������
					 1 ������	604800 ������
					 1 ����� (30.44 ����) 	2629743 ������
					 1 ��� (365.24 ����) 	 31556926 ������
					 |---------------------------------------------------------------
					 */
					$tariff_period = $this->tariff->period($this->user_id);

					$tariff = $this->tariff->get_tariff($this->user_tariff);

					if( $this->input->post('period') == 1 )
					{
						$price = $tariff['price_of_month'];//�� �����

						$time = 2629743;
					}
					else
					{
						$price = $tariff['price_of_year'];//�� ���

						$time = 31556926;
					}

					$this->balance_mdl->minus($this->user_id, $price);//��������� �� ����� ������

					$tariff_period = $tariff_period + $time;

					$data = array (
				'tariff_period' => $tariff_period
					);

					$this->tariff->update($this->user_id, $data);



					$this->transaction->create($this->user_id, '��������� ������������ ������� "'.$tariff['name'].'"', $price);

					show_error('����������� ������ �������.');
				}

				$data = $this->tariff->get_tariff($this->user_tariff);//������� ��� ������ � ������

				/*
				 |---------------------------------------------------------------
				 | ����� ������� �������
				 |---------------------------------------------------------------
				 */
				$tariff_period = $this->tariff->period($this->user_id);

				$date = $tariff_period - now();//�� ����� ����� �������� ������ �������� ������� ����

				$date = $date + now();

				$data['tariff_period'] = date_await($date);



				$this->template->build('account/tariff', $data, $title = '����������� ������');
	}

	function _check_tarrif_long($id)
	{
		$tariff = $this->tariff->get_tariff($id);//������� ��� ������ � ������

		$period = $this->input->post('period');

		if( $period == 1 )
		{
			$price = $tariff['price_of_month'];//��������� � �����
		}
		else
		{
			$price = $tariff['price_of_year'];//��������� � ���
		}

		if( $price > $this->balance_mdl->get($this->user_id) )
		{
			$this->form_validation->set_message('_check_tarrif_long', '�� ����� ����� ������������ �������');
			return FALSE;
		}

		return TRUE;
	}
	/*
	 |---------------------------------------------------------------
	 | �������� �� �������
	 |---------------------------------------------------------------
	 */
	function categories_followers()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$categories_followers = $this->input->post('category');//��������� ��������

		$submit = $this->input->post('submit');//������

		if( $submit )
		{
			$this->account_mdl->del_categories_followers($this->user_id);//������� ������ ��������

			if( $categories_followers )
			{

				//������ ������ � �������
				foreach($categories_followers as $row => $value):

				$array = array (
						'user_id' => $this->user_id,
						'category' => $value,
				);

				$this->account_mdl->add_categories_followers($array);

				endforeach;
			}

		}

		$data['categories'] = $this->designs_mdl->get_categories();//��� ���������

		$data['categories_followers'] = $this->account_mdl->get_categories_followers($this->user_id);//�������� ������������

		if( $data['categories_followers'] )
		{
			$select = $data['categories_followers'];

			foreach($select as $row => $value):
			$select[$row] = $value['category'];
			endforeach;

			$data['select'] = $select;
		}

		$this->template->build('account/categories_followers', $data, $title = '�������� �� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | �������� �� ���������������� ������
	 |---------------------------------------------------------------
	 */
	function users_followers($start_page = 0)
	{
		if( !$this->errors->access() )
		{
			return;
		}

		parse_str($_SERVER['QUERY_STRING'], $_GET);

		$per_page = 50;

		$start_page = intval($start_page);

		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$config['base_url'] = base_url().'/account/cart';
		$config['total_rows'] = $this->account_mdl->count_followers($user_id = '', $this->user_id);
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		$data['data'] = $this->account_mdl->get_followers($start_page, $per_page, $user_id = '', $this->user_id);

		$this->template->build('account/users_followers', $data, $title = '�������� �� ���������������� ������');
	}
	/*
	 |---------------------------------------------------------------
	 | �����������
	 |---------------------------------------------------------------
	 */
	function subscribe($follows = '')//��������� �������� �� ��������� ���, ���� ��� ���������
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( $this->_check_subscribe($follows) )
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$data = array (
			'user_id' => $this->user_id,
			'date' => now(),
			'follows' => $follows
		);

		$this->account_mdl->add('users_followers', $data);

		redirect('account/users_followers');
	}
	/*
	 |---------------------------------------------------------------
	 | �������� ��������
	 |---------------------------------------------------------------
	 */
	function subscribe_del($follows = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$this->_check_subscribe($follows) )//���� �������� �� ������� ��������������
		{
			redirect('account/users_followers');
		}

		$this->account_mdl->subscribe_del($this->user_id, $follows);

		redirect('account/users_followers');
	}

	function _check_subscribe($follows)
	{
		if( $this->account_mdl->subscribe_check($this->user_id, $follows) )//���� ������������ ��� ��������� � �����������
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
	function cart($start_page = 0)
	{
		parse_str($_SERVER['QUERY_STRING'],$_GET);

		$per_page = 10;

		$start_page = intval($start_page);
		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		if( $this->users_mdl->logged_in() )
		{
			$user_id = $this->user_id;

			$session_id = '';

			$template = 'cart';
		}
		else
		{
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

		$this->template->build('account/'.$template.'', $data, $title = '�������');
	}

	function pay_no_auth()
	{
		//������� ������������ ����� �������� user_id

		$designs = $this->input->post('designs');

		if( empty($designs) )
		{
			show_error('�������� ������ ��� ������');
		}

		$cart = $designs; $cart = implode(", ",  $cart);


		$designs = $this->account_mdl->pay_designs($designs);

		$total_amount = $this->total_amount($designs);//�������� �����


		/*
		 |---------------------------------------------------------------
		 | ��������� ������ ������
		 |---------------------------------------------------------------
		 */
		foreach($designs as $row):

		if( $row['sales'] > 0 and $row['kind'] == 2 )//���� � ������� ������ ����� ������� � ������������ �������� �������� ������
		{

			show_error('������ � ID '.$row['id'].' ���������� ��������');
		}

		if( $row['status'] == 2 )
		{
			show_error('������ � ID '.$row['id'].' ��������');
		}

		endforeach;

		$data['total_amount'] = $total_amount;

		$data['data'] = $designs;

		$data['cart'] = $cart;

		$this->template->build('account/pay', $data, $title = '�������');
	}


	function newa()
	{
		$cart = $this->input->post('cart');
		$code = $this->input->post('code');
		$total_amount = $this->input->post('total_amount');

		// ��������������� ���������� (�����, ������ #1)
		// registration info (login, password #1)
		$mrh_login = "Openweblife";
		$mrh_pass1 = "199122x199122x";
		// ����� ������
		// number of order
		$inv_id = 1;
		// �������� ������
		// order description
		$inv_desc = "���������� �������";
		// ����� ������
		// sum of order
		$out_summ = $total_amount;
		// ������������ ������ �������
		// default payment e-currency
		$in_curr = "PCR";
		// ����
		// language
		$culture = "ru";

		$ShpCart = $cart;
		$ShpCode = $code;

		// ������������ �������
		// generate signature
		$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:ShpCart=".$ShpCart.":ShpCode=".$ShpCode."");
		// ����� ������ ������
		// payment form


		$data = array
		(
		//'robokassaUrl'          => 'https://merchant.roboxchange.com/Index.aspx',
            'robokassaUrl'          => 'http://test.robokassa.ru/Index.aspx',
            'rb_mrh_login'          => $mrh_login,
            'rb_payment_amount'     => $out_summ,
            'rb_payment_id'         => $inv_id,
            'rb_payment_desc'       => $inv_desc,
            'rb_sign'               => $crc,
			
            'cart'               => $cart,
            'code'               => $code,
		);

		$this->load->view('wdesigns/account/newa', $data);
	}
	/*
	 |---------------------------------------------------------------
	 | �������/�������� ������
	 |---------------------------------------------------------------
	 */
	function cart_del($id = '')
	{
		if( !$this->_check_cart($id) )//���� �� ���������� ������ � ������������
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$this->account_mdl->del('cart', $id);

		redirect('account/cart');
	}
	/*
	 |---------------------------------------------------------------
	 | �������/���������� ������
	 |---------------------------------------------------------------
	 */
	function cart_add()
	{
		$id = $this->input->post('id');

		$kind = $this->input->post('kind');

		if( !empty($this->user_id) )//���������������� ������������
		{
			$data = array (
				'user_id' => $this->user_id,
				'design_id' => $id,
				'date' => now(),
				'kind' => $kind
			);
		}
		else//�� ����������������
		{
			$data  = array (
				'session_id' => $this->session->userdata('session_id'),
				'design_id' => $id,
				'date' => now(),
				'kind' => $kind
			);
		}

		if( $this->_check_action_cart($id) )//���� ������ ��� ��� �������� � �������
		{
			echo '����� ��� ��������';
				
			die;
		}

		if( $this->_check_purchased($id) )//���� ������ ��� ��� ������
		{
			echo '����� ��� ������';
				
			die;
		}

		$design = $this->designs_mdl->get_edit($id);//������� ��� ���������� �� �������

		if( $design['sales'] > 0 and $kind == 2 )
		{
			echo '����� ����� ��������';
				
			die;
		}

		if( $design['user_id'] == $this->user_id )
		{
			echo '����� ����������� ���';
				
			die;
		}

		$this->account_mdl->add('cart', $data);

		echo '<a href="/account/cart/">����� ��������</a>';
	}

	function _check_action_cart($design_id)
	{
		if( !empty($this->user_id) )//���������������� ������������
		{
			$session_id = '';
		}
		else//�� ����������������
		{
			$session_id = $this->session->userdata('session_id');
		}

		if( $this->account_mdl->cart_check($design_id, $this->user_id, $session_id) )//���� ���������� ����� � ������������ � �������
		{
			return TRUE;
		}
		return FALSE;
	}

	function _check_cart($id)//��������, �������� �� id ��������
	{
		if( !empty($this->user_id) )//���������������� ������������
		{
			$session_id = '';
		}
		else//�� ����������������
		{
			$session_id = $this->session->userdata('session_id');
		}

		if( $this->account_mdl->cart_check_del($id, $this->user_id, $session_id) )//���� ���������� ����� � ������������ � �������
		{
			return TRUE;
		}
		return FALSE;
	}

	/*
	 |---------------------------------------------------------------
	 | ������ �������
	 |---------------------------------------------------------------
	 */

	/*
	 |---------------------------------------------------------------
	 | ����������� �����
	 |---------------------------------------------------------------
	 */
	function total_amount($designs = '')
	{
		$total_amount = 0;

		foreach($designs as $row):

		if( $row['kind'] == 1 ):

		$total_amount = $total_amount + $row['price_1'];

		else:

		$total_amount = $total_amount + $row['price_2'];

		endif;

		endforeach;

		return $total_amount;
	}
	/*
	 |---------------------------------------------------------------
	 | ������� �������, �� ��������� ������� � ������������
	 |---------------------------------------------------------------
	 */
	function cart_clear($designs, $user_id)
	{
		foreach($designs as $row):
		$design_id[] = $row['id'];
		endforeach;

		$this->db->where_in('design_id', $design_id);

		$this->db->where('user_id', $user_id);

		$this->db->delete('cart');
	}
	/*
	 |---------------------------------------------------------------
	 | ����� ������
	 |---------------------------------------------------------------
	 */
	function pay()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$designs = $this->input->post('designs');

		$designs = $this->account_mdl->pay_designs($designs);

		$total_amount = $this->total_amount($designs);

		if( empty($designs) )
		{
			show_error('�������� ������ ��� ������');
		}

		if( $total_amount > $this->balance_mdl->get($this->user_id) )
		{
			show_error('�� ����� ����� ������������ �������');
		}
		/*
		 |---------------------------------------------------------------
		 | ��������� ������ ������
		 |---------------------------------------------------------------
		 */
		foreach($designs as $row):

		if( $row['sales'] > 0 and $row['kind'] == 2 )//���� � ������� ������ ����� ������� � ������������ �������� �������� ������
		{

			show_error('������ � ID '.$row['id'].' ���������� ��������');
		}

		if( $row['status'] == 2 )
		{
			show_error('������ � ID '.$row['id'].' ��������');
		}

		endforeach;
		/*
		 |---------------------------------------------------------------
		 | ����� �������� ��������� ���������, ��������� � �������, ������� ��������, ���������� �������� ��������� � � �
		 |---------------------------------------------------------------
		 */
		$this->balance_mdl->minus($this->user_id, $total_amount);//��������� �� �����

		foreach($designs as $row):

		$data = array (
				'user_id' => $this->user_id,
				'design_id' => $row['id'],
				'date' => now(),
				'kind' => $row['kind']
		);

		$this->account_mdl->add('purchased', $data);//��������� � ���������



		$this->designs_mdl->update_sales($row['id']);//����������� ����� �������

		if( $row['kind'] == '1' )
		{
			$price = $row['price_1'];//�������
		}
		else//���� ������ �������� ��������� ������ �� �������� - 2
		{
			$price = $row['price_2'];//�����

			$this->designs_mdl->enter($row['id']);//��������� � ��������
		}

		$this->balance_mdl->plus($row['user_id'], $price);//���������� ��������� ������

		$this->events->create($row['user_id'], '��� ������ "'.$row['title'].'" ��� ������');//��������� �������


		/*
		 |---------------------------------------------------------------
		 | ��������
		 |---------------------------------------------------------------
		 */
		$this->events->create($row['user_id'], '������� �������', 'sell_design');#������� � ����������

		$this->transaction->create($row['user_id'], '������� �������', $price);//������� ��������
		/*
		|---------------------------------------------------------------
		| ����������
		|---------------------------------------------------------------
		*/
		$this->events->create($this->user_id, '������� �������', 'buy_design');#������� � ����������

		$this->transaction->create($this->user_id, '������� �������', $price);//������� ����������


		endforeach;

		$this->cart_clear($designs, $this->user_id);//������� ��������� ������ �� �������

		//����� ����� ������� ����������� ������ �� ������� ���� �������������

		show_error('��� ������ ��������.');
	}
	/*
	 |---------------------------------------------------------------
	 | ������
	 |---------------------------------------------------------------
	 */
	function buy($id = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$design = $this->designs_mdl->get_edit($id) )
		{
			show_404('page');
		}

		if( $design['status'] != 1 )//���� ������ ������� �������� �� ������, ����� ���� �� ��� �������� � � �
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$rules = array
		(
		array (
				'field' => 'design_id', 
				'label' => 'ID �������',
				'rules' => 'required|callback__check_buy'
				),
				array (
				'field' => 'kind', 
				'label' => '���',
				'rules' => 'required'
				)
				);

				$data = array (
			'user_id' => $this->user_id,
			'design_id' => $id,
			'date' => now(),
			'kind' => $this->input->post('kind')//1 - ������, 2 - ��������, ����� �������������� ��� 1 - ���� ������� 2 - ���� ������
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->account_mdl->add('purchased', $data);

					if( $this->input->post('kind') == '1' )//���� ������� ����� ��������� � ������ �������
					{
						$price = $design['price_1'];
					}
					else//���� ������ �������� ��������� ������ �� �������� - 2
					{
						$price = $design['price_2'];

						$this->designs_mdl->enter($id);//��������� � ��������
					}

					$this->designs_mdl->update_sales($id);//����������� ����� �������

					$this->balance_mdl->minus($data['user_id'], $price);//��������� �� �����

					$this->events->create($design['user_id'], '��� ������ "'.$design['title'].'" ��� ������');//��������� �������

					redirect('account/purchased');
				}

				$data = $design;

				$this->template->build('account/buy', $data, $title = '������');
	}

	function _check_buy($id)//������ �������� ���� ������ ��� ��� ���������, ��������� ������� �������
	{
		$design = $this->designs_mdl->get_edit($id);//������� ��� ������ � �������

		$kind = $this->input->post('kind');

		if( $kind == 1 )
		{
			$price = $design['price_1'];
		}
		else
		{
			$price = $design['price_2'];
		}

		if( $this->account_mdl->buy_check($design['id'], $this->user_id) )
		{
			$this->form_validation->set_message('_check_buy', '������ ������ ��� ������ ����');
			return FALSE;
		}

		if( $design['user_id'] == $this->user_id )
		{
			$this->form_validation->set_message('_check_buy', '������ ����������� ���');
			return FALSE;
		}

		if( $price > $this->balance_mdl->get($this->user_id) )
		{
			$this->form_validation->set_message('_check_buy', '�� ����� ����� ������������ �������');
			return FALSE;
		}

		return TRUE;
	}
	/*
	 |---------------------------------------------------------------
	 | ���������
	 |---------------------------------------------------------------
	 */
	function purchased($start_page = 0)
	{
		if( !$this->errors->access() )
		{
			return;
		}

		parse_str($_SERVER['QUERY_STRING'], $_GET);

		$per_page = 10;

		$start_page = intval($start_page);

		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$config['base_url'] = base_url().'/account/purchased';
		$config['total_rows'] = $this->account_mdl->count_purchased($this->user_id);
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		$data['data'] = $this->account_mdl->get_purchased($start_page, $per_page, $this->user_id);

		$this->template->build('account/purchased', $data, $title = '���������');
	}

	function _check_purchased($design_id)
	{
		if( $this->account_mdl->purchased_check($design_id, $this->user_id) )//���� ���������� ����� � ������������ � ��������
		{
			return TRUE;
		}
		return FALSE;
	}

	function create_download($design_id)
	{
		//��������� ������ �� ������ ����, ���� �� �� ������ ��������� ��������

		if( !$this->_check_purchased($design_id) )//���� ������ �� ��� ������
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$file = $this->account_mdl->get_file($design_id);

		$code = md5(time());

		$data = array (
			'design_id' => $design_id,
			'user_id' => $this->user_id,
			'date' => now(),
			'ip' => $this->input->ip_address(),
			'file' => $file,
			'code' => $code,
		);

		$this->account_mdl->add('downloads', $data);

		$this->template->build('account/create_download', $data, $title = '���������');
	}
	/*
	 |---------------------------------------------------------------
	 | ��������� ��������
	 |---------------------------------------------------------------
	 */
	function downloads($start_page = 0)
	{
		if( !$this->errors->access() )
		{
			return;
		}

		parse_str($_SERVER['QUERY_STRING'],$_GET);

		$per_page = 10;

		$start_page = intval($start_page);
		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$config['base_url'] = base_url().'/account/downloads';
		$config['total_rows'] = $this->account_mdl->count_purchased($this->user_id);
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		$data['data'] = $this->account_mdl->get_downloads($start_page, $per_page, $this->user_id);

		$this->template->build('account/downloads', $data, $title = '��������');
	}
	/*
	 |---------------------------------------------------------------
	 | ������� ����� � �������, ����� � ������� files/downloads/ �������� http
	 |---------------------------------------------------------------
	 */
	function download($code)
	{
		//�������� ���� �� ����, ���� ��� ����� ������
		if( !$data = $this->account_mdl->get_download($code) )
		{
			show_404('page');
		}

		//����� ������� ip ���� ip ������ �� ����� ������
		if( $data['ip'] != $this->input->ip_address()  )
		{
			show_error('Ip �� ������������.');
		}

		//����� ���������, ������������� �� ������ �� �������, ���� ��� ������� ��� ���� � ������

		$date = now() - $data['date'];//�� ������� ���� �������� ���� �������� ��������, �������� ����� ��������� � ������� �������� ��������

		if(  $date > $this->config->item('download_period') )//���� ����� ��������� � ������� �������� ����� ������ ��� �������� ����� ����������������� ������ �� ����� ������ � ������� ��������
		{
			$this->account_mdl->del('downloads', $data['id']);

			show_error('������ �������� ����, �������� ����� �������.');
		}


		/*
		 |---------------------------------------------------------------
		 | ��������
		 |---------------------------------------------------------------
		 */

		$file = 'files/download/'.$data['file'].'';//��������� ���� � �����

		$type = explode('.', $file);

		$type = $type[1];

		$fname = md5(time()).'.'.$type;//��������� �������� �����

		$fsize = filesize($file);

		$fdown = $file;//�������

		/*
		 �� ������ ��� "�� ����" ������������� ����, �������� ��������� �� ������� �� ����������. ����� ������� �� ����� ������������ "�����������" ����� � �������� �� ������������.
		 */

		// ����������� ��� ��� ���������� HTTP_RANGE
		if( getenv('HTTP_RANGE') == '' )
		{// ������ � �������� ���� �� ������ ������
			$f = fopen($fdown, 'r');

			header("HTTP/1.1 200 OK");
			header("Connection: close");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Content-Disposition: Attachment; filename=".$fname);
			header("Content-Length: ".$fsize);

			while(!feof($f))
			{

				if( connection_aborted() )
				{
					fclose($f);

					break;
				}

				echo fread($f, 10000);

				sleep(1);
			}

			fclose($f);
		}
		else
		{// �������� �������� ���������� HTTP_RANGE

			preg_match ("/bytes=(\d+)-/", getenv('HTTP_RANGE'), $m);

			$csize = $fsize - $m[1];  // ������ ���������

			$p1 = $fsize - $csize;    // �������, � ������� �������� ������ �����

			$p2 = $fsize - 1;         // ����� ���������

			// ���������� ������� ������ � �����
			$f = fopen($fdown, 'r');
			fseek ($f, $p1);

			header("HTTP/1.1 206 Partial Content");
			header("Connection: close");
			header("Content-Type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Content-Disposition: Attachment; filename=".$fname);
			header("Content-Range: bytes ".$p1."-".$p2."/".$fsize);
			header("Content-Length: ".$csize);

			while (!feof($f))
			{
				if( connection_aborted() )
				{
					fclose($f);

					break;
				}

				echo fread($f, 10000);

				sleep(1);
			}

			fclose($f);

		}
	}
	/*
	 |---------------------------------------------------------------
	 | �������� ���������� ����� �� email
	 |---------------------------------------------------------------
	 */
	function to_email($design_id)
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( $this->_check_purchased($design_id) )//���� ������ ������ ��� ������
		{
			$email = $this->users_mdl->get_email($this->user_id);

			$file = $this->account_mdl->get_file($design_id);

			$file = 'files/download/'.$file;

			$this->common->email($email, $subject = '��� ������� ����', '', $file);
				
			show_error('��������� ������ ��� ��������� ��� �� �����.');
		}
		else
		{
			redirect('account/purchased');
		}
	}
	/*
	 |---------------------------------------------------------------
	 | �������
	 |---------------------------------------------------------------
	 */
	function events($start_page = 0)
	{
		$this->load->model('events/events_mdl');

		if( !$this->errors->access() )
		{
			return;
		}

		parse_str($_SERVER['QUERY_STRING'],$_GET);

		$per_page = 10;

		$start_page = intval($start_page);
		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$status = '';

		if( !empty($_GET['status']) )
		{
			unset($status);

			$status = '';

			if( $_GET['status'] == '1' )
			{
				$status = 1;
			}

			if( $_GET['status'] == '2' )
			{
				$status = 2;
			}
		}
		else
		{
			$status = '';
		}

		$config['base_url'] = base_url().'/account/events';
		$config['total_rows'] = $this->events_mdl->count_all($this->user_id, $status);
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		if( !empty($url) )
		{
			$url = implode ("&", $url);
			$data['page_links'] = str_replace( '">', '/?'.$url.'">',$data['page_links']);
		}

		$data['data'] = $this->events_mdl->get_all($start_page, $per_page, $this->user_id, $status);


		$this->template->build('account/events', $data, $title = '�������');
	}

	function update_event()
	{
		$id = $this->input->post('id');

		if( empty($id) )
		{
			return FALSE;
		}

		$this->load->model('events/events_mdl');

		$this->events_mdl->update($id);
	}
	/*
	 |---------------------------------------------------------------
	 | ������� ��������
	 |---------------------------------------------------------------
	 */
	function transaction()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$data = array();

		$data['data'] = $this->account_mdl->get_transaction($this->user_id);

		$this->template->build('account/transaction', $data, $title = '������� ��������');
	}
	/*
	 |---------------------------------------------------------------
	 | ��������
	 |---------------------------------------------------------------
	 */
	function purses()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$data = array();

		$data['data'] = $this->account_mdl->get_purses($this->user_id);

		$this->template->build('account/purses', $data, $title = '��������');
	}

	function purses_add()
	{
		$rules = array
		(
		array (
				'field' => 'purse', 
				'label' => '�������',
				'rules' => 'required|wmr|max_length[13]'
				)
				);

				$data = array (
			'user_id' => $this->user_id,
			'date' => now(),
			'last_operation' => now(),
			'purse' => $this->input->post('purse')
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->account_mdl->add('purses', $data);
						
					redirect('account/purses');
				}

				$this->template->build('account/purses_add', $data, $title = '�������� �������');
	}

	function purses_del($id = '')//�������� ��������
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$this->_check_purses($id) )//���� �� ���������� �������� � ������������
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$this->account_mdl->del('purses', $id);

		redirect('account/purses');
	}

	function _check_purses($id = '')//��������
	{
		if( $this->account_mdl->purse_check($id, $this->user_id) )//���� ���������� ������ � ������������
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
	function withdraw($start_page = 0)
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'purse', 
				'label' => '������� Z',
				'rules' => 'required'
				),
				array (
				'field' => 'amount', 
				'label' => '�����',
				'rules' => 'required|numeric|max_length[6]|callback__check_amount'
				),
				);

				$data = array (
			'user_id' => $this->user_id,
			'date' => now(),
			'purse' => $this->input->post('purse'),
			'amount' => $this->input->post('amount'),
			'status' => 1
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->account_mdl->add('balance_applications', $data);

					$this->balance_mdl->minus($data['user_id'], $data['amount']);//��������� �� �����
						
					redirect('account/withdraw');
				}


				$per_page = 10;

				$start_page = intval($start_page);
				if( $start_page < 0 )
				{
					$start_page = 0;
				}

				$config['base_url'] = base_url().'/account/withdraw';
				$config['total_rows'] = $this->account_mdl->count_applications($this->user_id);
				$config['per_page'] = $per_page;

				$this->pagination->initialize($config);

				$data['page_links'] = $this->pagination->create_links();

				$data['data'] = $this->account_mdl->get_applications($start_page, $per_page, $this->user_id);

				$data['purses'] = $this->account_mdl->get_purses($this->user_id);

				$data['commission'] = $this->tariff->value($this->user_tariff, 'commission');//�������� - ����� �� ������

				$this->template->build('account/withdraw', $data, $title = '����� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | ������ �� �����/������ ��������
	 |---------------------------------------------------------------
	 */
	function withdraw_del($id = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$this->_check_withdraw($id) )//���� �� ���������� ������ � ������������
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$this->account_mdl->cancel_applications($id, $this->user_id);

		redirect('account/withdraw');
	}

	function _check_withdraw($id = '')//�������� �� �������� ������
	{
		if( $this->account_mdl->withdraw_check($id, $this->user_id) )//���� ������ �� ����� ����������� ������������
		{
			return TRUE;
		}

		return FALSE;
	}

	function _check_amount($amount)//�������� ��� ������
	{
		if( $amount < $this->tariff->value($this->user_tariff, 'minimum_w_a') )
		{
			$this->form_validation->set_message('_check_amount', '����������� ����� ������ '.$this->tariff->value($this->user_tariff, 'minimum_w_a').' ������');
			return FALSE;
		}

		if( $amount > $this->balance_mdl->get($this->user_id) )
		{
			$this->form_validation->set_message('_check_amount', '�� ����� ����� ������������ �������');
			return FALSE;
		}

		return TRUE;
	}
	/*
	 |---------------------------------------------------------------
	 | ������� webmoney
	 |---------------------------------------------------------------
	 */
	function balance_w()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$data = array();

		$data['purse'] = 'R344515119665';

		$this->template->build('account/balance', $data, $title = '���������� �������');
	}

	function result()
	{
		$LMI_PREREQUEST = $this->input->post('LMI_PREREQUEST');
		$LMI_PAYMENT_AMOUNT = $this->input->post('LMI_PAYMENT_AMOUNT');
		$LMI_PAYEE_PURSE = $this->input->post('LMI_PAYEE_PURSE');
		$user_id = $this->input->post('user_id');

		$purse = 'R344515119665';

		if( $LMI_PREREQUEST == 1 )
		{

			if( $LMI_PAYEE_PURSE != $purse )
			{
				$err = 1;
				echo "ERR: �� �� �������������� �� �����";
				exit;
			}

			if( !$err ) echo "YES";
		}
		else
		{
			$this->balance_mdl->plus($user_id, $LMI_PAYMENT_AMOUNT);

			$this->transaction->create($this->user_id, '���������� �����', $LMI_PAYMENT_AMOUNT);
		}
	}
	/*
	 |---------------------------------------------------------------
	 | ���������
	 |---------------------------------------------------------------
	 */
	function ad($id = '')
	{
		parse_str($_SERVER['QUERY_STRING'],$_GET);

		if( !empty($_GET['ad']) )
		{
			$ad = $_GET['ad'];

			$data['ad'] = $_GET['ad'];

			if( $ad = $this->account_mdl->get_ad($ad) )
			{
				$data['code'] = '<a href="'.base_url().'user/'.$this->username.'" target="_blank" title="'.$this->config->item('title').'"><img src="'.base_url().''.$ad['img'].'" border="0" alt="'.$this->username.' �� '.$this->config->item('site').'"></a>';
			}
		}

		$data['ads'] = $this->account_mdl->get_ads();

		$this->template->build('account/ad', $data, $title = '���������');
	}
	/*
	 |---------------------------------------------------------------
	 | �����
	 |---------------------------------------------------------------
	 */
	function blogs($start_page = 0)
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$per_page = 10;

		$start_page = intval($start_page);

		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$input = array();

		$input['user_id'] = $this->user_id;

		$config['base_url'] = base_url().'/account/blogs';
		$config['total_rows'] = $this->blogs_mdl->count_blogs($input);
		$config['per_page'] = $per_page;

		$this->pagination->initialize($config);

		$data['page_links'] = $this->pagination->create_links();

		$data['data'] = $this->blogs_mdl->get_all($start_page, $per_page, $input);

		$this->template->build('account/blogs', $data, $title = '������ �������');
	}
	/*
	 |---------------------------------------------------------------
	 | �������
	 |---------------------------------------------------------------
	 */
	function designs($start_page = 0)
	{
		if( !$this->errors->access() )
		{
			return;
		}

		parse_str($_SERVER['QUERY_STRING'], $_GET);

		$per_page = 10;

		$start_page = intval($start_page);

		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$input = array();

		if( !empty($_GET['status']) )
		{
			$status = '';

			if( $_GET['status'] == '1' )
			{
				$status = 1;
			}

			if( $_GET['status'] == '2' )
			{
				$status = 2;
			}

			if( $_GET['status'] == '3' )
			{
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

		if( !empty($url) )
		{
			$url = implode ("&", $url);
			$data['page_links'] = str_replace( '">', '/?'.$url.'">',$data['page_links']);
		}

		$data['data'] = $this->designs_mdl->get_designs($start_page, $per_page, $input);


		$this->template->build('account/designs', $data, $title = '������ ��������');
	}
	/*
	 |---------------------------------------------------------------
	 | �������
	 |---------------------------------------------------------------
	 */
	function index()
	{
		if( $this->users_mdl->logged_in() )
		{
			$template = 'index';
		}
		else
		{
			$template = 'index_no_auth';
		}

		$this->template->build('account/'.$template.'', $data = '', $title = '��� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | ���������
	 |---------------------------------------------------------------
	 */
	function settings()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$mailer = $this->input->post('mailer');//�������
		$notice = $this->input->post('notice');//�������
		$hint = $this->input->post('hint');//�������
		$adult = $this->input->post('adult');//�������
		$submit = $this->input->post('submit');//������

		if( $submit )
		{
			$data = array (
				'mailer' => $mailer,			
				'notice' => $notice,
				'hint' => $hint,
				'adult' => $adult
			);

			$this->users_mdl->edit_settings($this->user_id, $data);
		}

		$profile = $this->users_mdl->profile();

		$age = date('Y') - $profile['year'];

		$data = $this->users_mdl->get_settings($this->user_id);//�������� ��������� ��� �����������

		$data['age'] = $age;

		$this->template->build('account/settings', $data, $title = '���������');
	}
	/*
	 |---------------------------------------------------------------
	 | �������
	 |---------------------------------------------------------------
	 */
	function profile()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'surname', 
				'label' => '�������',
				'rules' => 'required|cyrillic|max_length[24]'
				),
				array (
				'field' => 'name', 
				'label' => '���',
				'rules' => 'required|cyrillic|max_length[24]'
				),
				array (
				'field' => 'sex', 
				'label' => '���',
				'rules' => 'required'
				),
				array (
				'field' => 'dob_day', 
				'label' => '���� ��������',
				'rules' => 'required'
				),
				array (
				'field' => 'dob_month', 
				'label' => '����� ��������',
				'rules' => 'required'
				),
				array (
				'field' => 'dob_year', 
				'label' => '��� ��������',
				'rules' => 'required'
				),
				array (
				'field' => 'country_id', 
				'label' => '������',
				'rules' => 'required'
				),
				array (
				'field' => 'city_id', 
				'label' => '�����',
				'rules' => 'required'
				),
				array (
				'field' => 'website', 
				'label' => 'Web-����',
				'rules' => 'max_length[64]'
				),
				array (
				'field' => 'short_descr', 
				'label' => '������� ��������',
				'rules' => 'max_length[255]'
				),
				array (
				'field' => 'full_descr', 
				'label' => '������',
				'rules' => 'max_length[10000]'
				)
				);

				$data = array (
			'surname' => ucwords(strtolower($this->input->post('surname'))),
			'name' => ucwords(strtolower($this->input->post('name'))),
			'sex' => $this->input->post('sex'),
			'day' => $this->input->post('dob_day'),
			'month' => $this->input->post('dob_month'),
			'year' => $this->input->post('dob_year'),
			'country_id' => $this->input->post('country_id'),
			'city_id' => $this->input->post('city_id'),
			'website' => prep_url($this->input->post('website')),
			'short_descr' => htmlspecialchars($this->input->post('short_descr')),
			'full_descr' => htmlspecialchars($this->input->post('full_descr'))
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->users_mdl->edit($this->user_id, $data);
				}

				$data = $this->users_mdl->profile();

				$data['created'] = date_smart($data['created']);

				$this->template->build('account/profile', $data, $title = '��������� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | ������
	 |---------------------------------------------------------------
	 */
	function password()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'old_password', 
				'label' => '������ ������',
				'rules' => 'required|callback__password_check'
				),
				array (
				'field' => 'password1', 
				'label' => '����� ������',
				'rules' => 'required|min_length[6]|max_length[24]|matches[password2]'
				),
				array (
				'field' => 'password2', 
				'label' => '������ ������',
				'rules' => 'required'
				)
				);

				$password = $this->input->post('password1');

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->users_mdl->change_password($this->user_id, $password);
				}

				$this->template->build('account/password', $data = '', $title = '������ | ��������� �������');
	}

	function _password_check($password)
	{
		if( $this->users_mdl->password_check($this->user_id, $password) )
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('_password_check', '����������� ������ ����� �������');
			return FALSE;
		}
	}
	/*
	 |---------------------------------------------------------------
	 | ������
	 |---------------------------------------------------------------
	 */
	function services()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$services = $this->input->post('category');//��������� ������

		$submit = $this->input->post('submit');//������


		if( $submit )
		{
			$this->account_mdl->del_services($this->user_id);//������� ������ �������

			if( $services )
			{
				//������ ������ � �������
				foreach($services as $row => $value):

				$array = array (
						'user_id' => $this->user_id,
						'category' => $value,
				);

				$this->account_mdl->add_services($array);

				endforeach;
			}

		}

		$this->load->model('categories/categories_mdl');//��� ��������

		$data['categories'] = $this->categories_mdl->get_categories();//��� ������

		$data['services'] = $this->account_mdl->get_services($this->user_id);//������ ������������


		if( $data['services'] )
		{
			$select = $data['services'];

			foreach($select as $row => $value):
			$select[$row] = $value['category'];
			endforeach;

			$data['select'] = $select;
		}

		$this->template->build('account/services', $data, $title = '������ | ��������� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | �������������� ������/��������������
	 |---------------------------------------------------------------
	 */
	function additional_data()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'price_1', 
				'label' => '���� �� ��� ������',
				'rules' => 'numeric|max_length[12]'
				),
				array (
				'field' => 'price_2', 
				'label' => '���� �� ����� ����� ������',
				'rules' => 'numeric|max_length[12]'
				)
				);

				$data = array (
			'price_1' => $this->input->post('price_1'),
			'price_2' => $this->input->post('price_2')
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->account_mdl->edit_profile($this->user_id, $data);
				}

				$data = $this->account_mdl->get_profile($this->user_id);

				$this->template->build('account/additional', $data, $title = '�������������� ������ | ��������� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | ���������� ������/��������������
	 |---------------------------------------------------------------
	 */
	function contact_data()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'email', 
				'label' => 'Email',
				'rules' => 'valid_email|max_length[48]'
				),
				array (
				'field' => 'icq', 
				'label' => 'ICQ',
				'rules' => 'trim|numeric|max_length[16]'
				),
				array (
				'field' => 'skype', 
				'label' => 'Skype',
				'rules' => 'trim|skype|max_length[16]'
				),
				array (
				'field' => 'telephone', 
				'label' => '�������',
				'rules' => 'trim|telephone|max_length[24]'
				)
				);

				$data = array (
			'email' => strtolower($this->input->post('email')),
			'icq' => $this->input->post('icq'),
			'skype' => $this->input->post('skype'),
			'telephone' => $this->input->post('telephone')
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->users_mdl->edit($this->user_id, $data);
				}

				$data = $this->users_mdl->profile();

				$this->template->build('account/contact', $data, $title = '���������� ������ | ��������� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | ���������
	 |---------------------------------------------------------------
	 */
	function images_add()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$this->load->library('upload');
		$this->load->library('Image_lib');

		$rules = array
		(
		array (
				'field' => 'title', 
				'label' => '���������',
				'rules' => 'required|text|max_length[64]'
				),
				array (
				'field' => 'text', 
				'label' => '������� ��������',
				'rules' => 'required|max_length[255]'
				)
				);

				if( isset($_FILES['userfile']['tmp_name']) )
				{
					$config['encrypt_name']  = TRUE;
					$config['upload_path'] = './files/portfolio/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= '1000';
					$config['max_width']  = '1600';
					$config['max_height']  = '1200';


					$this->upload->initialize($config); unset($config);

					if( $this->upload->do_upload() )
					{

						$data = $this->upload->data();

						$path  = './files/portfolio/'.$data['file_name'].'';

						$config['source_image'] = $path;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = 120;
						$config['height'] = 120;
						$config['new_image'] = './files/portfolio/'.$data['file_name'].'';
						$config['create_thumb'] = TRUE;
						$config['thumb_marker'] = '_small';

						$this->image_lib->initialize($config);

						$this->image_lib->resize();



						//������ �������� ��� ���������� ������
						$this->form_validation->set_rules($rules);

						if( $this->form_validation->run() )
						{

							$this->db->select_max('position');

							$query = $this->db->get('portfolio')->row_array();


							$data = array (
						'user_id' => $this->user_id,
						'position' => $query['position'] + 1,
						'date' => now(),
						'title' => $this->input->post('title'),
						'descr' => htmlspecialchars($this->input->post('text')),
						'small_image' => '/files/portfolio/'.$data['raw_name'].'_small'.$data['file_ext'],
						'full_image' => '/files/portfolio/'.$data['file_name']
							);

							$this->account_mdl->add_porfolio($data);
								
							redirect('users/portfolio/'.$this->username);//������������ �� �������� ������ �����������
						}

					}
					else
					{
						$data['error'] = $this->upload->display_errors();
					}

				}

				if( empty($data) )
				{
					$data = '';
				}

				$this->template->build('portfolio/add', $data, $title = '�������� ����������� | ��������� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | ���������/��������������
	 |---------------------------------------------------------------
	 */
	function images_edit($id = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$this->_check_porfolio($id) )
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$this->load->library('upload');
		$this->load->library('Image_lib');

		$rules = array
		(
		array (
				'field' => 'title', 
				'label' => '���������',
				'rules' => 'required|text|max_length[64]'
				),
				array (
				'field' => 'text', 
				'label' => '������� ��������',
				'rules' => 'required|max_length[255]'
				)
				);

				if( isset($_FILES['userfile']['tmp_name']) )
				{
					$config['encrypt_name']  = TRUE;
					$config['upload_path'] = './files/portfolio/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= '1000';
					$config['max_width']  = '1600';
					$config['max_height']  = '1200';


					$this->upload->initialize($config); unset($config);

					if( $this->upload->do_upload() )
					{

						$data = $this->upload->data();

						$path  = './files/portfolio/'.$data['file_name'].'';

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

				if( !isset($small_image) or !isset($full_image) )//���� �� ����������, ��������� ������� �����������
				{
					$data = $this->account_mdl->get_image($id);
					$small_image = $data['small_image'];
					$full_image = $data['full_image'];
				}


				//������ �������� ��� ���������� ������
				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$data = array (
				'title' => $this->input->post('title'),
				'descr' => htmlspecialchars($this->input->post('text')),
				'small_image' => $small_image,
				'full_image' => $full_image
					);

					$this->account_mdl->edit_porfolio($id, $data);
						
					redirect('users/portfolio/'.$this->username);//������������ �� �������� ������ �����������
				}

				$data = $this->account_mdl->get_image($id);

				$this->template->build('portfolio/edit', $data, $title = '������������� ����������� | ��������� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | ���������/������� �����������
	 |---------------------------------------------------------------
	 */
	function images_del($id = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$this->_check_porfolio($id) )
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$this->account_mdl->del_porfolio($id);

		redirect('users/images/'.$this->username);//������������ �� �������� ������ �����������
	}
	/*
	 |---------------------------------------------------------------
	 | ���������/����������� �����
	 |---------------------------------------------------------------
	 */
	function images_up($id = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$this->_check_porfolio($id) )
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$this->account_mdl->up_portfolio($id, $this->user_id);

		redirect('users/images/'.$this->username);//������������ �� �������� ������ �����������
	}
	/*
	 |---------------------------------------------------------------
	 | ���������/����������� ����
	 |---------------------------------------------------------------
	 */
	function images_down($id = '')
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( !$this->_check_porfolio($id) )
		{
			show_error('������� ������ ������������� �������� ���� ���������� �������� ���������.');
		}

		$this->account_mdl->down_portfolio($id, $this->user_id);

		redirect('users/images/'.$this->username);//������������ �� �������� ������ �����������
	}

	function _check_porfolio($id = '')
	{
		if( $this->account_mdl->check_porfolio($id, $this->user_id) )
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
	function userpic()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		$this->load->library('upload');
		$this->load->library('Image_lib');

		$data['userpic'] = $this->userpic;

		if( isset($_FILES['userfile']['tmp_name']) )
		{
			$config['upload_path'] = './userpics/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = TRUE;
			$config['max_size']	= '1000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->upload->initialize($config); unset($config);

			if( $this->upload->do_upload() )
			{
				$data = $this->upload->data();

				if( $this->userpic != '/userpics/standart.jpg' )//���� ����������� �� ����������� �������
				{
					unlink('.'.$this->userpic);
				}

				$path  = './userpics/'.$data['orig_name'].'';

				$config['source_image'] = $path;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 100;
				$config['height'] = 100;
				$config['new_image'] = './userpics/userpic'.$data['file_ext'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_'.$this->username;

				$this->image_lib->initialize($config);

				$this->image_lib->resize();

				unlink($path);//������� ��������

				$data = array('userpic' => '/userpics/userpic_'.$this->username.''.$data['file_ext'].'');//�������

				$this->users_mdl->edit($this->user_id, $data);
			}
			else
			{
				$data['error'] = $this->upload->display_errors();
			}

		}

		$this->template->build('account/userpic', $data, $title = '��������� �������� | ��������� �������');
	}
	/*
	 |---------------------------------------------------------------
	 | �������� �������
	 |---------------------------------------------------------------
	 */
	function delete_message()
	{
		$id = $this->input->post('id');

		if( empty($id) )
		{
			return FALSE;
		}

		$this->db->update('events', array('status' => 2), array('id' => $id));
	}
	/*
	 |---------------------------------------------------------------
	 | �������� ������� - ����� ������� ���
	 |---------------------------------------------------------------
	 */
	function delete_message_all()
	{
		$this->db->update('events', array('status' => 2), array('user_id' => $this->user_id));
	}
	/*
	 |---------------------------------------------------------------
	 | �������/�������� ��������
	 |---------------------------------------------------------------
	 */
	function userpic_del()
	{
		if( !$this->errors->access() )
		{
			return;
		}

		if( $this->userpic != '/userpics/standart.jpg' )//���� ������� �� ����������� �������
		{
			unlink('.'.$this->userpic);
		}

		$data = array('userpic' => '/userpics/standart.jpg');//������ ������� �� �����������

		$this->users_mdl->edit($this->user_id, $data);

		redirect('/account/userpic');
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
	function users($start_page = 0)
	{
		$this->_moderator();

		if( !$this->errors->access() )
		{
			return;
		}

		parse_str($_SERVER['QUERY_STRING'], $_GET);

		$per_page = 10;

		$start_page = intval($start_page);

		if( $start_page < 0 )
		{
			$start_page = 0;
		}

		$input = array();

		if( !empty($_GET['status']) )
		{
			$status = '';

			if( $_GET['status'] == '1' )
			{
				$status = 1;
			}

			if( $_GET['status'] == '2' )
			{
				$status = 2;
			}

			if( $_GET['status'] == '3' )
			{
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

		if( !empty($url) )
		{
			$url = implode ("&", $url);
			$data['page_links'] = str_replace( '">', '/?'.$url.'">',$data['page_links']);
		}

		$data['data'] = $this->account_mdl->get_users($start_page, $per_page, $input);


		$this->template->build('account/users', $data, $title = '������ �������������');
	}

	function users_ban($id = '')
	{
		$this->_moderator();

		if( !$this->errors->access() )
		{
			return;
		}

		$rules = array
		(
		array (
				'field' => 'cause', 
				'label' => '������� ����',
				'rules' => 'required|max_length[255]'
				)
				);

				$data = array (
			'user_id' => $id,
			'cause' => htmlspecialchars($this->input->post('cause'))
				);

				$this->form_validation->set_rules($rules);

				if( $this->form_validation->run() )
				{
					$this->account_mdl->add('banned', $data);
						
					redirect('account/users');
				}

				$this->template->build('account/users_ban', $data, $title = '�������� ������������');
	}

	function _moderator()//���������
	{
		if( $this->team != 2 )
		{
			show_error('�� �� ������ ������� � ������� �������');
		}
	}
}