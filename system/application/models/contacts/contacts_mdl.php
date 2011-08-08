<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contacts_mdl extends Model
{
// -------------------------------Сообщения-----------------------------------------
	function get_messages($start_from = FALSE, $per_page, $contact = '')//Выводим все сообщения от пользователя
	{
		$this->reading($contact);//Читаем все сообщения посланные нам

		$query = $this->db->query('SELECT * FROM `ci_messages` WHERE (`sender_id` = '.$this->user_id.' and `recipient_id` = '.$contact.') or (`sender_id` = '.$contact.' and `recipient_id` = '.$this->user_id.') ORDER BY `date` DESC LIMIT '.$start_from.', '.$per_page.';');

		$query = $query->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['sender_id'] = $this->users_mdl->get_username($query[$i]['sender_id']);

			if( $query[$i]['reading'] )
			{
				$query[$i]['reading'] = date_smart($query[$i]['reading']);
			}
		}
		
		return $query;
	}

	function reading($contact)//Читаем все сообщения которые мы получили recipient_id
	{
		$this->db->where('sender_id', $contact);

		$this->db->where('recipient_id', $this->user_id);

		$this->db->where('reading', 0);

		$this->db->update('messages', array('reading' => now()));
	}

	function send_message($data)
	{
		$this->db->insert('messages', $data);
		
		$recipient = $this->users_mdl->get_user($data['recipient_id']);//Получатель

		$sender = $this->users_mdl->get_user($data['sender_id']);//Отправитель

		$this->events->create($data['recipient_id'], 'Персональное сообщение от '.$sender['username'].'');

		$ins_data['email'] = $recipient['email'];//Отправляем уведомление получателю
		$ins_data['recipient_username'] = $recipient['username'];
		$ins_data['name'] = $sender['name'];
		$ins_data['surname'] = $sender['surname'];
		$ins_data['username'] = $sender['username'];
		$ins_data['text'] = $data['text'];

		$this->email_new_message($ins_data);
	}

	function email_new_message($data)//Отправляем уведомление о приавтном сообщении
	{
		$email = $data['email'];//email куда приходят уведомления

		if( empty($email) )
		{
			return FALSE;
		}

		$subject = 'Новое сообщение';

		$message = $this->load->view('emails/new_message', $data, TRUE);

		$this->common->email($email, $subject, $message);
	}

	function count_messages($contact = '')
	{
		$query = $this->db->query('SELECT * FROM `ci_messages` WHERE (`sender_id` = '.$this->user_id.' and `recipient_id` = '.$contact.') or (`sender_id` = '.$contact.' and `recipient_id` = '.$this->user_id.');');

		$query = $query->result_array();

		return count($query); 
	}

	function count_new_messages($user_id = '', $sender_id = '')//Новые сообщения у пользователя для вывода на главной
	{
		$this->db->where('recipient_id', $user_id);
		
		if( !empty($sender_id) )
		{
			$this->db->where('sender_id', $sender_id);
		}

		$this->db->where('reading', 0);

		return $this->db->count_all_results('messages'); 
	}
/*
|---------------------------------------------------------------
| Контакты
|---------------------------------------------------------------
*/
	function get_contacts($start_from = FALSE, $per_page, $group_id = '')//Выводим все группы пользователя
	{
		if( $start_from !== FALSE ) 
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('last_msg', 'desc');

		$this->db->where('user_id', $this->user_id);//Выводим все контакты пользователя

		$this->db->where('group_id', $group_id);

		$this->db->select('contacts.*, users.username, users.userpic, users.created, users.last_login, users.surname, users.name');

		$this->db->from('contacts');

		$this->db->join('users', 'users.id = contacts.contact');

		$query = $this->db->get()->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['created'] = date_smart($query[$i]['created']);

			$query[$i]['last_login'] = date_smart($query[$i]['last_login']);

			if( $query[$i]['last_msg'] ) 
			{
				$query[$i]['last_msg'] = date_smart($query[$i]['last_msg']);
			}

			$query[$i]['count_messages'] = $this->count_messages($query[$i]['contact']);
	
			$query[$i]['count_new_messages'] = $this->count_new_messages($this->user_id, $query[$i]['contact']);
		}
		
		return $query;
	}

	function move_contacts($id, $group_id)//Перемещение контактов
	{
		$this->db->where_in('id', $id);

		$this->db->update('contacts', array('group_id' => $group_id));
	}

	function add_contact($data)//Добавить контакт
	{
		$this->db->insert('contacts', $data);
	}

	function update_last_msg($user_id, $contact)//Обновление последнего сообщения
	{
		$this->db->where('user_id', $user_id);

		$this->db->where('contact', $contact);

		$this->db->update('contacts', array('last_msg' => now()));
	}
// -------------------------------ГРУППЫ-----------------------------------------

	function get_group($id)//Выводим данные группы для редактирования
	{
		$this->db->where_in('id', $id);

		$this->db->select('*');

		return $this->db->get('groups')->row_array();
	}

	function get_groups()//Выводим все группы пользователя
	{
		$this->db->where('user_id', $this->user_id);//Выводим все группы созданные пользователем
		$this->db->or_where('user_id', 0);//и обшии группы

		$this->db->select('*');

		$query = $this->db->get('groups')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['count_contacts'] = $this->count_contacts($query[$i]['id'], $this->user_id);
		}
		
		return $query;
	}

	function check_group($id = '', $user_id = '')
	{
		if( empty($id) )
		{
			return FALSE;
		}

		if( !empty($user_id) )
		{
			$this->db->where('user_id', $user_id);
	    }

		$this->db->where('id', $id);

		if( $this->db->count_all_results('groups') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}

	function count_contacts($group_id = '', $user_id = '', $contact = '')//Колличество контактов в группе
	{
		if( !empty($user_id) )
		{
			$this->db->where('user_id', $user_id);
	    }

		if( !empty($contact) )
		{
			$this->db->where('contact', $contact);
	    }

		if( !empty($group_id) )
		{
			$this->db->where('group_id', $group_id);
	    }

		return $this->db->count_all_results('contacts'); 
	}

	function add_group($data)
	{
		$this->db->insert('groups', $data);
	}

	function edit_group($id, $data)
	{
		$this->db->where('id', $id);

		$this->db->update('groups', $data);
	}

	function del_group($id)
	{
	    $this->db->where('id', $id);

		$this->db->delete('groups');
	}
}