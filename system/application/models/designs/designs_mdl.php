<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Designs_mdl extends Model
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

	function del($table, $id)
	{
		$this->db->where('id', $id);

		$this->db->delete($table);
	}

	function add_options($data)
	{
		$this->db->insert('designs_options', $data);
	}

	function edit_options($design_id, $data)
	{
		$this->db->where('design_id', $design_id);

		$this->db->update('designs_options', $data);
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

		return $this->db->get('designs_comments')->row_array();
	}

	function edit_comment($id, $data) 
	{
	    $this->db->where('id', $id);

		$this->db->update('designs_comments', $data);
	}

	function del_comment($id) 
	{
	    $this->db->where('id', $id);

		$this->db->delete('designs_comments');
	}

    function check_comment($id, $user_id = '') 
	{
		$this->db->where('id', $id);

		if( $user_id ) 
		{
			$this->db->where('user_id', $user_id);
		}

		return $this->db->count_all_results('designs_comments'); 
	}
/*
|---------------------------------------------------------------
| ������ �����
|---------------------------------------------------------------
*/
	function get($id)
	{
		$this->db->where('designs.id', $id);

		$this->db->where('moder', 1);

		$this->db->select('designs.*, designs_options.*, users.username, users.userpic, users.created, users.last_login, users.surname, users.name');

		$this->db->join('users', 'users.id = designs.user_id');

		$this->db->join('designs_options', 'designs_options.design_id = designs.id', 'LEFT');

		$query = $this->db->get('designs')->row_array();

		if( !$query ) return FALSE;

		$query['date'] = date_smart($query['date']);

		$query['created'] = date_smart($query['created']);

		$query['last_login'] = date_smart($query['last_login']);

		$query['status_id'] = $query['status'];

		switch($query['status'])
		{
    		case 1: $query['status'] = '������'; break;
    		case 2: $query['status'] = '��������'; break;
    		case 3: $query['status'] = '������'; break;
		}

		$query['category_id'] = $query['category'];

		$query['category'] = $this->designs_mdl->name($query['category']);


		$query['theme'] = $this->designs_mdl->theme($query['theme']);

		$query['destination'] = $this->designs_mdl->destination($query['destination']);

		switch($query['flash'])
		{
    		case 1: $query['flash'] = '��'; break;
    		case 2: $query['flash'] = '���'; break;
		}

		switch($query['stretch'])
		{
    		case 1: $query['stretch'] = '���������'; break;
    		case 2: $query['stretch']  = '�������������'; break;
		}

		switch($query['quality'])
		{
    		case 1: $query['quality'] = '������ ��� IE'; break;
    		case 2: $query['quality'] = '��������������� �������'; break;
    		case 3: $query['quality'] = '������ ������������ W3C'; break;
		}

		switch($query['type'])
		{
    		case 1: $query['type'] = '������� �������'; break;
    		case 2: $query['type'] = '���������'; break;
		}

		switch($query['tone'])
		{
    		case 1: $query['tone'] = '�������'; break;
    		case 2: $query['tone'] = '������'; break;
		}

		switch($query['bright'])
		{
    		case 1: $query['bright'] = '���������'; break;
    		case 2: $query['bright'] = '�����'; break;
		}

		switch($query['style'])
		{
    		case 1: $query['style'] = '�����'; break;
    		case 2: $query['style'] = '������������'; break;
    		case 3: $query['style'] = '������'; break;
		}

		return $query;
	}
/*
|---------------------------------------------------------------
| ����� ��� ��������������
|---------------------------------------------------------------
*/
	function get_edit($id)
	{
		$this->db->where('id', $id);

		$this->db->join('designs_options', 'designs_options.design_id = designs.id', 'LEFT');

		$this->db->select('*');

		return $this->db->get('designs')->row_array();
	}
/*
|---------------------------------------------------------------
| ���������� ����������
|---------------------------------------------------------------
*/
	function update_views($design_id)
	{
		$ip_address = $this->input->ip_address();

		$this->db->where('design_id', $design_id);

		$this->db->where('ip_address', $ip_address);

		if( $this->db->count_all_results('designs_views') > 0 ) 
		{
			return FALSE;
		}
		else
		{
			$data = array (
				'design_id' => $design_id,
				'ip_address' => $ip_address
			);

			$this->db->insert('designs_views', $data);

			//���������� ��������
			$this->db->select('views');

			$query = $this->db->get_where('designs', array('id' => $design_id));

			$views = $query->row_array();

			$views = $views['views'] + 1;

			//���������
			$this->db->update('designs', array('views' => $views), array('id' => $design_id));
		}
	}
/*
|---------------------------------------------------------------
| ���������� ������
|---------------------------------------------------------------
*/
	function update_sales($id)
	{
		$this->db->select('sales');

		$query = $this->db->get_where('designs', array('id' => $id));

		$query = $query->row_array();

		$sales = $query['sales'] + 1;

		//���������
		$this->db->update('designs', array('sales' => $sales), array('id' => $id));
	}
/*
|---------------------------------------------------------------
| Jquery-Autocomplete - ����� ���� �����, ��� ����������� ������, ����������
|---------------------------------------------------------------
*/
	function get_tags()
	{
		$this->db->select('tag');

		$this->db->order_by('tag', 'desc');

		$this->db->distinct();

		return $this->db->get('tags')->result_array();
	}
/*
|---------------------------------------------------------------
| ������ �����
|---------------------------------------------------------------
*/
    function get_tag_cloud()
	{
		$this->db->select('tag, COUNT(tag) AS tag_count');

		$this->db->group_by('tag');

		$query = $this->db->get('tags');

		if( $query->num_rows() > 0 )
		{
			$tags = array();
	
			foreach ($query->result_array() as $row)
				$tags[$row['tag']] = $row['tag_count'];
				return $tags;
		}

		else return array();
    }
/*
|---------------------------------------------------------------
| ����� ����� ��� ������ �������
|---------------------------------------------------------------
*/
	function get_design_tags($id)
	{
		$this->db->select('*');

		$this->db->where('design_id', $id);

		$query = $this->db->get('tags')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['tag_count'] = $this->count_tags($query[$i]['tag']);//
		}
		
		return $query;

	}

	function count_tags($tag)
	{
		$this->db->where('tag', $tag);

		$this->db->where('status', 1);//������ ��������

		$this->db->join('designs', 'designs.id = tags.design_id');

        $query = $this->db->get('tags');
		
		return $query->num_rows();
	}

	function delete_design_tags($design_id)//��� ��������������
	{
		$this->db->where('design_id', $design_id);

		$this->db->delete('tags');
	}
/*
|---------------------------------------------------------------
| ����� ������ ��� ������ �������
|---------------------------------------------------------------
*/
	function get_design_colors($id)
	{
		$this->db->select('color, percent');

		$this->db->where('design_id', $id);

		return $this->db->get('colors')->result_array();
	}
/*
|---------------------------------------------------------------
| ����� �������������� ����������� ��� ������ �������
|---------------------------------------------------------------
*/
	function get_design_images($design_id)
	{
		$this->db->select('*');

		$this->db->where('design_id', $design_id);

		return $this->db->get('images')->result_array();
	}
/*
|---------------------------------------------------------------
| �������� �� ���
|---------------------------------------------------------------
*/
	function check_banned($design_id)
	{
		$this->db->select('cause');

		$query = $this->db->get_where('designs_banned', array('design_id '=> $design_id));

		if( $query->num_rows() > 0 ) 
		{
			$row = $query->row();
			return $row->cause;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| ������������� ������ ��� ��������������
|---------------------------------------------------------------
*/
	function get_associated_designs_edit($id = '')
  	{
		$this->db->select('*');

		$this->db->where('design_id', $id);

		return $this->db->get('associated')->result_array();
  	}
/*
|---------------------------------------------------------------
| ������������� ������
|---------------------------------------------------------------
*/
	function get_design_sub($design_id)
  	{
		$this->db->select('designs.id, designs.title, designs.small_image');

		$this->db->where('design_id', $design_id);

		$this->db->where('sub !=', $design_id);

		$this->db->distinct();

		$this->db->join('designs', 'associated.sub = designs.id');

		return $this->db->get('associated')->result_array();
  	}

	function delete_design_sub($design_id)//��� ��������������
	{
		$this->db->where('design_id', $design_id);

		$this->db->delete('associated');
	}
/*
|---------------------------------------------------------------
| ����� ��������
|---------------------------------------------------------------
*/
	function get_designs($start_from = FALSE, $per_page, $input = '')
  	{
		$keywords = (isset($input['keywords'])) ? $input['keywords'] : '';
		$price_1_start = (isset($input['price_1_start'])) ? $input['price_1_start'] : '';
		$price_1_end = (isset($input['price_1_end'])) ? $input['price_1_end'] : '';
		$price_2_start = (isset($input['price_2_start'])) ? $input['price_2_start'] : '';
		$price_2_end = (isset($input['price_2_end'])) ? $input['price_2_end'] : '';
		$category = (isset($input['category_array'])) ? $input['category_array'] : '';

		$user_id = (isset($input['user_id'])) ? $input['user_id'] : '';//�������
		$status = (isset($input['status'])) ? $input['status'] : '';

		$order_field = (isset($input['order_field'])) ? $input['order_field'] : '';
		$order_type = (isset($input['order_type'])) ? $input['order_type'] : '';

		$tags = (isset($input['tags'])) ? $input['tags'] : '';
		$color = (isset($input['color'])) ? $input['color'] : '';

		if( !empty($user_id) )//���� �������
		{
			$sql = "`user_id` = '$user_id'";

			if( !empty($status) ) 
			{
				$sql .= " and `status` = '$status'";
			}
		}
		else//���� �� ������� ������� ������ ��������
		{
			$sql = "`status` = '1'";
		}

		$sql .= " and `moder` = 1";// � ��������������

		if( $this->adult == 0 )//���� � ���������� �������� ����� ������ ��� ��������
		{
			$sql .= " and `adult` = '0'";//�� ������� ����� �������
		}

		$sql .= " and id NOT IN (SELECT design_id FROM ci_designs_banned)";//�� ������� ��������������� ��������

		if( !empty($color) )//����
		{
			$sql .= " and id IN (SELECT design_id FROM ci_colors WHERE `color` = '$color' )";
		}

		if( !empty($tags) )//����
		{
			$tags = explode(", ", $tags);
			
			$tags = "'" . implode("', '", $tags) . "'";//���������� implode � �������

			$sql .= " and id IN (SELECT design_id FROM ci_tags WHERE `tag` IN ($tags) )";
		}

		if( !empty($keywords) )//�������� �����
		{
			$sql .= " and (`title` LIKE '%$keywords%' or `text` LIKE '%$keywords%')";
		}

		if( !empty($category) ) 
		{
			$category = implode(", ", $category);

			$sql .= " and category IN ($category)";
		}

		if( !empty($price_1_start) )//���� �� ������� ��
		{
			$sql .= " and `price_1` >= '$price_1_start'";
		}

		if( !empty($price_1_end) )//���� �� ������� ��
		{
			$sql .= " and `price_1` <= '$price_1_end'";
		}

		if( !empty($price_2_start) )//���� ����� ��
		{
			$sql .= " and `price_2` >= '$price_2_start'";
		}

		if( !empty($price_2_end) )//���� ����� ��
		{
			$sql .= " and `price_2` <= '$price_2_end'";
		}


		if( !empty($order_field) )//����������
		{			
			$sql .= " ORDER BY $order_field $order_type";
		}
		else
		{
			$sql .= " ORDER BY `date` DESC";
		}


        $query =
                    " SELECT *".

                    " FROM ci_designs LEFT JOIN ci_designs_options ON ci_designs.id = ci_designs_options.design_id".

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
				$query[$i]['date'] = date_smart($query[$i]['date']);//���� ����������

				$query[$i]['category_id'] = $query[$i]['category'];

				$query[$i]['section'] = $this->designs_mdl->section($query[$i]['category']);

				$query[$i]['category'] = $this->designs_mdl->name($query[$i]['category']);

				switch($query[$i]['status'])
				{
					case 1: $query[$i]['status']  = '������'; break;
    				case 2: $query[$i]['status']  = '��������'; break;
    				case 3: $query[$i]['status']  = '������'; break;
				}
			}

			return $query;
        }
  	}
/*
|---------------------------------------------------------------
| ����������� �������� �� ������
|---------------------------------------------------------------
*/
	function count_designs($input = '')
  	{
		$keywords = (isset($input['keywords'])) ? $input['keywords'] : '';
		$price_1_start = (isset($input['price_1_start'])) ? $input['price_1_start'] : '';
		$price_1_end = (isset($input['price_1_end'])) ? $input['price_1_end'] : '';
		$price_2_start = (isset($input['price_2_start'])) ? $input['price_2_start'] : '';
		$price_2_end = (isset($input['price_2_end'])) ? $input['price_2_end'] : '';
		$category = (isset($input['category_array'])) ? $input['category_array'] : '';

		$user_id = (isset($input['user_id'])) ? $input['user_id'] : '';//�������
		$status = (isset($input['status'])) ? $input['status'] : '';//�������

		$order_field = (isset($input['order_field'])) ? $input['order_field'] : '';
		$order_type = (isset($input['order_type'])) ? $input['order_type'] : '';

		$tags = (isset($input['tags'])) ? $input['tags'] : '';
		$color = (isset($input['color'])) ? $input['color'] : '';

		if( !empty($user_id) )//���� �������
		{
			$sql = "`user_id` = '$user_id'";

			if( !empty($status) ) 
			{
				$sql .= " and `status` = '$status'";
			}
		}
		else//���� �� ������� ������� ������ �������� � ��������������
		{
			$sql = "`status` = '1'";
		}

		$sql .= " and `moder` = 1";// � ��������������

		if( $this->adult == 0 )//���� � ���������� �������� ����� ������ ��� ��������
		{
			$sql .= " and `adult` = '0'";//�� ������� ����� �������
		}

		$sql .= " and id NOT IN (SELECT design_id FROM ci_designs_banned)";//�� ������� ��������������� ��������

		if( !empty($color) )//����
		{
			$sql .= " and id IN (SELECT design_id FROM ci_colors WHERE `color` = '$color' )";
		}

		if( !empty($tags) )//����
		{
			$tags = explode(", ", $tags);
			
			$tags = "'" . implode("', '", $tags) . "'";//���������� implode � �������

			$sql .= " and id IN (SELECT design_id FROM ci_tags WHERE `tag` IN ($tags) )";
		}

		if( !empty($keywords) )//�������� �����
		{
			$sql .= " and (`title` LIKE '%$keywords%' or `text` LIKE '%$keywords%')";
		}

		if( !empty($category) ) 
		{
			$category = implode(", ", $category);

			$sql .= " and category IN ($category)";
		}

		if( !empty($price_1_start) )//���� �� ������� ��
		{
			$sql .= " and `price_1` >= '$price_1_start'";
		}

		if( !empty($price_1_end) )//���� �� ������� ��
		{
			$sql .= " and `price_1` <= '$price_1_end'";
		}

		if( !empty($price_2_start) )//���� ����� ��
		{
			$sql .= " and `price_2` >= '$price_2_start'";
		}

		if( !empty($price_2_end) )//���� ����� ��
		{
			$sql .= " and `price_2` <= '$price_2_end'";
		}

        $query =
                    " SELECT id".

                    " FROM ci_designs LEFT JOIN ci_designs_options ON ci_designs.id = ci_designs_options.design_id".

					" WHERE ".$sql.";";

        $query = $this->db->query($query);
		
		return $query->num_rows();
  	}
/*
|---------------------------------------------------------------
| ����� ��������� ����������� �������� ��� ������ ���������, �� �������
|---------------------------------------------------------------
*/
	function get_newest($category = '', $status = '', $limit = 10)
  	{
    	$this->db->limit($limit);

		$this->db->select('id, date, title');

    	$this->db->order_by('date', 'desc');

		$this->db->where('moder', 1);

		if( !empty($category) ) 
		{
			$this->db->where('category', $category);
		}

		if( !empty($status) ) 
		{
			$this->db->where('status', $status);
		}

		if( $this->adult == 0 )//���� � ���������� �������� ����� ������ ��� ��������
		{
			$this->db->join('designs_options', 'designs.id = designs_options.design_id', 'LEFT');
			
			$this->db->where('adult', 0);
		}

		$query = $this->db->get('designs')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);//���� ����������
		}
		
		return $query;
  	}
/*
|---------------------------------------------------------------
| ������� ������� �� �����
|---------------------------------------------------------------
*/
	function get_similar($id, $limit = 10)
  	{
        $query = 
                    " SELECT ci_designs.id, title, small_image".
                    " FROM ci_tags LEFT JOIN ci_designs ON ci_tags.design_id = ci_designs.id ".
					" WHERE design_id != ".$id."".//��������� ��� ������, �� �������� ��������� �������
					" and moder = 1".

					" and tag IN (SELECT tag FROM ci_tags WHERE design_id = ".$id.")".

					" and design_id IN (SELECT id FROM ci_designs WHERE status = 1)".//������ ���������� � ����� ������ ������

					" and design_id NOT IN (SELECT design_id FROM ci_designs_banned)".//�� ������� ���������� ��������

                    " GROUP BY id".
                    " ORDER BY rand()".//��������� �������
                    " LIMIT ".$limit."";//�����

        $query = $this->db->query($query);

        if( $query->num_rows() == 0 )
		{
			return FALSE;
        }
        else 
		{
			return $query->result_array();
        }
  	}
/*
|---------------------------------------------------------------
| ����� ��������������� �������������
|---------------------------------------------------------------
*/
	function get_members_voted($design_id, $limit = 10)
	{
		$this->db->limit($limit);

		$this->db->select('users.*');

		$this->db->where('design_id', $design_id);

		$this->db->join('users', 'users.id = votes.user_id');

		return $this->db->get('votes')->result_array();
	}
/*
|---------------------------------------------------------------
| ��������� id ��������� ������� �� ��������������� �����������
|---------------------------------------------------------------
*/
	function get_id($id = '')
	{
		$this->db->select('design_id');

		$query = $this->db->get_where('images', array('id' => $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->design_id;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| ������� ������
|---------------------------------------------------------------
*/
	function enter($id)
	{
		$this->db->update('designs', array('status' => 2), array('id' => $id));;
	}
/*
|---------------------------------------------------------------
| ������� ������
|---------------------------------------------------------------
*/
	function close($id)
	{
		$this->db->update('designs', array('status' => 3), array('id' => $id));;
	}
/*
|---------------------------------------------------------------
| �������� �������������� �����������
|---------------------------------------------------------------
*/
	function get_themes()
	{
		$this->db->select('*');

		return $this->db->get('designs_themes')->result_array();
	}

	function theme($id)
	{
		$this->db->select('name');
		$query = $this->db->get_where('designs_themes', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->name;
		}

		return FALSE;
	}

	function get_destinations()
	{
		$this->db->select('*');

		return $this->db->get('designs_destinations')->result_array();
	}

	function destination($id)
	{
		$this->db->select('name');
		$query = $this->db->get_where('designs_destinations', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->name;
		}

		return FALSE;
	}

	function get_image($id)//��� ��������������
	{
		$this->db->select('*');

		$this->db->where('id', $id);

		return $this->db->get('images')->row_array();
	}

	function get_user_id($id = '')//��������� id ������������ �������
	{
		$this->db->select('user_id');
		$query = $this->db->get_where('designs', array('id' => $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->user_id;
		}

		return FALSE;
	}

	function check($id = '', $status = '', $user_id = '')//�������� �� ������������� ������, ��� ���������� ������, �������
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

		if( $this->db->count_all_results('designs') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}

	function check_vote($design_id)
	{
		$ip = $this->input->ip_address();

		$this->db->where('design_id', $design_id);

		$this->db->where('ip', $ip);

		if( $this->db->count_all_results('votes') > 0 ) 
		{
			return FALSE;
		}

		return TRUE;
	}

	function like($id)
	{
		$this->db->select('like');
		$query = $this->db->get_where('designs', array('id' => $id));
		$result = $query->row();

		$like = $result->like + 1;

		$this->db->update('designs', array('like' => $like), array('id' => $id));

		$user_id = '';

		$user_id = (isset($this->user_id)) ? $user_id : '';

		$data = array (
			'design_id' => $id,
			'user_id' => $user_id,
			'ip' => $this->input->ip_address()
		);
			
		$this->db->insert('votes', $data);
		
		$this->update_rating($id, 1);
	}

	function dislike($id)
	{
		$this->db->select('dislike');
		$query = $this->db->get_where('designs', array('id' => $id));
		$result = $query->row();

		$dislike = $result->dislike + 1;

		$this->db->update('designs', array('dislike' => $dislike), array('id' => $id));

		$user_id = '';

		$user_id = (isset($this->user_id)) ? $user_id : '';

		$data = array (
			'design_id' => $id,
			'user_id' => $user_id,
			'ip' => $this->input->ip_address()
		);

		$this->db->insert('votes', $data);

		$this->update_rating($id, 2);
	}
/*
|---------------------------------------------------------------
| ��������� ����� �������
|---------------------------------------------------------------
*/
	function update_rating($id, $type)
	{
		$this->db->select('rating');

		$query = $this->db->get_where('designs', array('id' => $id));

		$rating = $query->row_array();

		if( $type == 1 )
		{
			$rating = $rating['rating'] + 1;
		}
		else
		{
			$rating = $rating['rating'] - 1;
		}

		//���������
		$this->db->update('designs', array('rating' => $rating), array('id' => $id));
	}
/*
|---------------------------------------------------------------
| ����� ��������, ��� ���� ������������� ������, *������*
|---------------------------------------------------------------
*/
	function get_sub()
	{
		$this->db->select('id, title, small_image');

		return $this->db->get('designs')->result_array();
	}
/*
|---------------------------------------------------------------
| ��������� � ������������ ��������
|---------------------------------------------------------------
*/
	function get_categories()//��������� � ������������ ������������� ��������������� ������ ������
	{
		$this->db->select('*');

		$query = $this->db->get('designs_categories')->result_array();

		$count = count($query);

		for($i = 0; $i < $count; $i++)
		{
			$query[$i]['number'] = $this->count_comments($query[$i]['id']);
		}
		
		return $query;
	}


	function count_comments($category)
	{
		$this->db->where('category', $category);

		$this->db->where('status', 1);

		$this->db->where('moder', 1);

		return $this->db->count_all_results('designs');  
	}
/*
|---------------------------------------------------------------
| ���������
|---------------------------------------------------------------
*/
	function name($id)
	{
		$this->db->select('name');
		$query = $this->db->get_where('designs_categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $row->name;
		}

		return FALSE;
	}

	function section($id)//������ �����
	{
		$this->db->select('parent_id');
		$query = $this->db->get_where('designs_categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			return $this->name($row->parent_id);
		}

		return FALSE;
	}

	function title($id)
	{
		$this->db->select('title');

		$query = $this->db->get_where('designs_categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->title;
		}

		return FALSE;
	}

	function design_title($id)//� ������� ������������
	{
		$this->db->select('parent_id, title');

		$query = $this->db->get_where('designs_categories', array('id '=> $id));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			
			$parent_id = $row->parent_id;

			if( $parent_id != 0 )//���� �� ������
			{
				$title = $row->title;

				$title .= ' | '.$this->name($parent_id);
				
				return $title;
			}
			
			return $row->title;//����� ������ ������� ���������
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| �������� ��������� ��� ������ ���������
|---------------------------------------------------------------
*/
	function cat_array($id)
	{
		$this->db->select('parent_id');
		$query = $this->db->get_where('designs_categories', array('id '=> $id));

		if( $query->num_rows() > 0 )
		{
			$row = $query->row();
			$parent_id = $row->parent_id;
		}
		else
		{
			return FALSE;
		}

		if( $parent_id != 0 )//���� ��������� ��������� �� �������� �������� - ������� ������� ������ � ����� ������������
		{
			$array = array($id);

			return $array;
		}

		$this->db->select('id');

		$this->db->where('parent_id', $id);//������� ��� ���������� �������� �������

		$array = $this->db->get('designs_categories')->result_array();

		$a = '';
		foreach($array as $row):
			$a .= $row['id'];
			$a .= ', ';
		endforeach;

		$a = trim($a);;

		$a = substr($a, 0, -1);

		$array = explode(", ", $a);



		return $array;
	}
/*
|---------------------------------------------------------------
| �������� ������������ ���������
|---------------------------------------------------------------
*/
	function category_check($id)
	{
		$this->db->where('id', $id);

		if( $this->db->count_all_results('designs_categories') > 0 ) 
		{ 
			return TRUE;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| ���� ���������� ���������� ������
|---------------------------------------------------------------
*/
	function last_comment($design_id = '', $user_id = '')//���� ���������� ���������� ������ �������������
	{
		$this->db->select_max('date');

		$query = $this->db->get_where('designs_comments', array('design_id' => $design_id, 'user_id' => $user_id, ));
 
		if( $query->num_rows() > 0 )
		{
			$row = $query->row();

			return $row->date;
		}

		return FALSE;
	}
/*
|---------------------------------------------------------------
| ����� ������������
|---------------------------------------------------------------
*/
	function get_comments($design_id)
	{
    	$this->db->order_by('date', 'desc');

		$this->db->select('designs_comments.*, users.username');

		$this->db->where('design_id', $design_id);

		$this->db->join('users', 'users.id = designs_comments.user_id');

		$query = $this->db->get('designs_comments')->result_array();
		
		$count = count($query);

		for($i = 0; $i < $count; $i++) 
		{
			$query[$i]['date'] = date_smart($query[$i]['date']);
		}

		return $query;
	}
/*
|---------------------------------------------------------------
| ��������, ���������� �� ������������
|---------------------------------------------------------------
*/
	function get_mailer_users($user_id)//������� ��� ��� ������� �� �������� � ����� ������������
	{
		$this->db->select('users_followers.user_id, users.username, users.surname, users.name, users.email');

		$this->db->where('follows', $user_id);

		$this->db->join('users', 'users.id = users_followers.user_id');
		
		return $this->db->get('users_followers')->result_array();
	}
/*
|---------------------------------------------------------------
| ��������, ���������� �� �������
|---------------------------------------------------------------
*/
	function get_mailer_categories($category, $user_id)//������� ��� ��� ������� �� �������� �� ��� �������
	{
		$this->db->select('categories_followers.user_id, users.username, users.surname, users.name, users.email');

		$this->db->where('category', $category);

		$this->db->where('categories_followers.user_id !=', $user_id);

		$this->db->join('users', 'users.id = categories_followers.user_id');
		
		return $this->db->get('categories_followers')->result_array();
	}
}