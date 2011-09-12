<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blogs_mdl extends Model
{
	/*
	 |---------------------------------------------------------------
	 | �������� � ����� ������
	 |---------------------------------------------------------------
	 */
	function add($data)
	{
		$this->db->insert('blogs', $data);
	}

	function edit($id, $data)
	{
		$this->db->where('id', $id);

		$this->db->update('blogs', $data);
	}

	function del($id)
	{
		$this->db->where('id', $id);

		$this->db->delete('blogs');
	}

	function add_comment($data)
	{
		$this->db->insert('blogs_comments', $data);
	}
	/*
	 |---------------------------------------------------------------
	 | ������ �����
	 |---------------------------------------------------------------
	 */
	function get($id)
	{
		$this->db->select('*');

		$this->db->where('id', $id);

		return $this->db->get('blogs')->row_array();
	}
	/*
	 |---------------------------------------------------------------
	 | �����������
	 |---------------------------------------------------------------
	 */
	function get_comment($id)
	{
		$this->db->select('*');

		$this->db->where('id', $id);

		return $this->db->get('blogs_comments')->row_array();
	}

	function edit_comment($id, $data)
	{
		$this->db->where('id', $id);

		$this->db->update('blogs_comments', $data);
	}

	function del_comment($id)
	{
		$this->db->where('id', $id);

		$this->db->delete('blogs_comments');
	}

	function check_comment($id, $user_id = '')
	{
		$this->db->where('id', $id);

		if( $user_id )
		{
			$this->db->where('user_id', $user_id);
		}

		return $this->db->count_all_results('blogs_comments');
	}
	/*
	 |---------------------------------------------------------------
	 | ����� ���� �������
	 |---------------------------------------------------------------
	 */
	function get_blogs()
	{
		$this->db->select('*');

		$query = $this->db->get('blogs')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['username'] = $this->users_mdl->get_username($query[$i]['user_id']);

			$query[$i]['category_id'] = $query[$i]['category'];

			$query[$i]['category'] = $this->blogs_mdl->name($query[$i]['category']);

			$query[$i]['date'] = date_smart($query[$i]['date']);

			$query[$i]['count_comments'] = $this->count_comments($query[$i]['id']);
		}

		return $query;
	}

	function get_all($start_from = FALSE, $per_page, $input = '')//����� �������
	{
		$category = (isset($input['category'])) ? $input['category'] : '';

		$user_id = (isset($input['user_id'])) ? $input['user_id'] : '';

		if( $start_from !== FALSE )
		{
			$this->db->limit($per_page, $start_from);
		}

		$this->db->order_by('date', 'desc');

		if( $category )
		{
			$this->db->where('category', $category);
		}

		if( $user_id )
		{
			$this->db->where('user_id', $user_id);
		}

		return $this->get_blogs();
	}
	/*
	 |---------------------------------------------------------------
	 | ������� ��� ������������ ���������
	 |---------------------------------------------------------------
	 */
	function count_all($input = '')
	{
		$category = (isset($input['category'])) ? $input['category'] : '';

		$user_id = (isset($input['user_id'])) ? $input['user_id'] : '';

		if( $category )
		{
			$this->db->where('category', $category);
		}

		if( $user_id )
		{
			$this->db->where('user_id', $user_id);
		}

		return $this->db->count_all_results('blogs');
	}

	function get_comments($blog_id)
	{
		$this->db->order_by('date', 'desc');

		$this->db->select('blogs_comments.*, users.username, users.userpic');

		$this->db->where('blog_id', $blog_id);

		$this->db->join('users', 'users.id = blogs_comments.user_id');

		$query = $this->db->get('blogs_comments')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);
		}

		return $query;
	}

	function count_comments($blog)//���������� ������������ � ������
	{
		$this->db->where_in('blog_id', $blog);

		return $this->db->count_all_results('blogs_comments');
	}

	function check($id, $user_id = '')
	{
		$this->db->where('id', $id);

		if( $user_id )
		{
			$this->db->where('user_id', $user_id);
		}

		return $this->db->count_all_results('blogs');
	}

	function count_blogs($user_id)//���������� ������� � ������������
	{
		if( empty($user_id) )
		{
			return FALSE;
		}

		if( $user_id )
		{
			$this->db->where_in('user_id', $user_id);
		}

		return $this->db->count_all_results('blogs');
	}
	/*
	 |---------------------------------------------------------------
	 | ���������
	 |---------------------------------------------------------------
	 */

	function get_categories()//��� �������
	{
		$this->db->select('*');

		return $this->db->get('blogs_categories')->result_array();
	}

	function name($id)
	{
		$this->db->select('name');

		$query = $this->db->get_where('blogs_categories', array('id '=> $id));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->name;
		}

		return FALSE;
	}

	function category_check($id)
	{
		$this->db->where('id', $id);

		if( $this->db->count_all_results('blogs_categories') > 0 )
		{
			return TRUE;
		}

		return FALSE;
	}
}