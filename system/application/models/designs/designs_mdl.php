<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Designs_mdl extends Model {
	/**
	 * ---------------------------------------------------------------
	 *	Операции с базами
	 * ---------------------------------------------------------------
	 */

	function add($table, $data) {
		$this->db->insert($table, $data);
	}

	function edit($table, $id, $data) {
		$this->db->where('id', $id);
		
		$this->db->update($table, $data);
	}

	function del($table, $id) {
		$this->db->where('id', $id);
		
		$this->db->delete($table);
	}

	function add_options($data) {
		$this->db->insert('designs_options', $data);
	}

	function edit_options($design_id, $data) {
		$this->db->where('design_id', $design_id);
		
		$this->db->update('designs_options', $data);
	}

	function del_options($design_id) {
		$this->db->where('design_id', $design_id);
		
		$this->db->delete('designs_options');
	}

	function del_views($design_id) {
		$this->db->where('design_id', $design_id);
		
		$this->db->delete('designs_views');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Комментарий
	 * ---------------------------------------------------------------
	 */

	function get_comment($id) {
		$this->db->select('*');
		
		$this->db->where('id', $id);
		
		return $this->db->get('designs_comments')->row_array();
	}

	function edit_comment($id, $data) {
		$this->db->where('id', $id);
		
		$this->db->update('designs_comments', $data);
	}

	function del_comment($id) {
		$this->db->where('id', $id);
		
		$this->db->delete('designs_comments');
	}

	function check_comment($id, $user_id = '') {
		$this->db->where('id', $id);
		
		if ($user_id) {
			$this->db->where('user_id', $user_id);
		}
		
		return $this->db->count_all_results('designs_comments');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Полный вывод
	 * ---------------------------------------------------------------
	 */

	function get($id, $expand_values = TRUE) {
		$this->db->where('designs.id', $id);
		
		$this->db->where('moder', 1);
		
		$this->db->select('designs.*, designs_options.*, users.username, users.userpic, users.created, users.last_login, users.surname, users.name');
		
		$this->db->join('users', 'users.id = designs.user_id');
		
		$this->db->join('designs_options', 'designs_options.design_id = designs.id', 'LEFT');
		
		$query = $this->db->get('designs')->row_array();
		
		if (!$query)
			return FALSE;
			
		$query['date'] = date_smart($query['date']);
		
		$query['created'] = date_smart($query['created']);
		
		$query['last_login'] = date_smart($query['last_login']);
		
		$query['status_id'] = $query['status'];
		
		$query['category_id'] = $query['category'];
		
		$query['category'] = $this->name($query['category']);
		
		if ( empty($query['category']) and $expand_values)
			$query['category'] = 'Не указано';
			
		$query['theme'] = $this->theme($query['theme']);
		
		if ( empty($query['theme']) and $expand_values)
			$query['theme'] = 'Не указано';
			
		$query['destination'] = $this->destination($query['destination']);
		
		$query['properties'] = array(
		);
		
		if ($expand_values) {
		
			switch ($query['status']) {
				case 1:
					$query['properties']['status'] = 'Открыт';
					break;
				case 2:
					$query['properties']['status'] = 'Вызаказан';
					break;
				case 3:
					$query['properties']['status'] = 'Закрыт';
					break;
			}
			
			switch ($query['flash']) {
				case 1:
					$query['properties']['flash'] = 'С флеш';
					break;
				case 2:
					$query['properties']['flash'] = 'Без флеш';
					break;
			}
			
			switch ($query['stretch']) {
				case 1:
					$query['properties']['stretch'] = 'Тянущаяся верстка';
					break;
				case 2:
					$query['properties']['stretch'] = 'Фиксированная верстка';
					break;
			}
			
			$query['columns'] == 0 and $query['columns'] = 'Не указано';
			
			switch ($query['quality']) {
				case 1:
					$query['properties']['quality'] = 'Только для IE';
					break;
				case 2:
					$query['properties']['quality'] = 'Кроссбраузерная верстка';
					break;
				case 3:
					$query['properties']['quality'] = 'Полное соответствие W3C';
					break;
			}
			
			switch ($query['type']) {
				case 1:
					$query['properties']['type'] = 'Блочная верстка';
					break;
				case 2:
					$query['properties']['type'] = 'Табличная верстка';
					break;
			}
			
			switch ($query['tone']) {
				case 1:
					$query['properties']['tone'] = 'Светлый';
					break;
				case 2:
					$query['properties']['tone'] = 'Темный';
					break;
			}
			
			switch ($query['bright']) {
				case 1:
					$query['properties']['bright'] = 'Спокойный';
					break;
				case 2:
					$query['properties']['bright'] = 'Яркий';
					break;
			}
			
			switch ($query['style']) {
				case 1:
					$query['properties']['style'] = 'Новый';
					break;
				case 2:
					$query['properties']['style'] = 'Классический';
					break;
				case 3:
					$query['properties']['style'] = 'Старый';
					break;
			}
			
			switch ($query['adult']) {
				case 1:
					$query['properties']['adult'] = 'Только для взрослых';
					break;
			}
		}
		
		return $query;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод для редактирования
	 * ---------------------------------------------------------------
	 */

	function get_edit($id) {
		$this->db->where('id', $id);
		
		$this->db->join('designs_options', 'designs_options.design_id = designs.id', 'LEFT');
		
		$this->db->select('*');
		
		return $this->db->get('designs')->row_array();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Обновление просмотров
	 * ---------------------------------------------------------------
	 */

	function update_views($design_id) {
		$ip_address = $this->input->ip_address();
		
		$this->db->where('design_id', $design_id);
		
		$this->db->where('ip_address', $ip_address);
		
		if ($this->db->count_all_results('designs_views') > 0) {
			return FALSE;
		} else {
			$data = array(
				'design_id'=>$design_id,'ip_address'=>$ip_address
			);
			
			$this->db->insert('designs_views', $data);
			
			//Прибавляем просмотр
			$this->db->select('views');
			
			$query = $this->db->get_where('designs', array(
				'id'=>$design_id
			));
			
			$views = $query->row_array();
			
			$views = $views['views'] + 1;
			
			//Обновляем
			$this->db->update('designs', array(
				'views'=>$views
			), array(
				'id'=>$design_id
			));
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Обновление продаж
	 * ---------------------------------------------------------------
	 */

	function update_sales($id) {
		$this->db->select('sales');
		
		$query = $this->db->get_where('designs', array(
			'id'=>$id
		));
		
		$query = $query->row_array();
		
		$sales = $query['sales'] + 1;
		
		//Обновляем
		$this->db->update('designs', array(
			'sales'=>$sales
		), array(
			'id'=>$id
		));
	}
	/**
	 * ---------------------------------------------------------------
	 *	Jquery-Autocomplete - Вывод всех тегов, для выпадающего списка, уникальный
	 * ---------------------------------------------------------------
	 */

	function get_tags($like = '', $limit = 10) {
	
		$this->db->distinct();
		$this->db->select('tag');
		$this->db->like('tag', $like, 'after');
		$this->db->order_by('tag', 'desc');
		$this->db->limit($limit);
		$keyword_tags = $this->db->get('tags')->result_array();
		
		$this->db->distinct();
		$this->db->select('tag');
		$this->db->like('tag', $like, 'after');
		$this->db->order_by('tag', 'desc');
		$this->db->limit($limit);
		$color_tags = $this->db->get('color_tags')->result_array();
		
		return $keyword_tags + $color_tags;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Облако тегов
	 * ---------------------------------------------------------------
	 */

	function get_tag_cloud($design_id = FALSE) {
		if ($design_id) {
			$query = "SELECT `tag`, COUNT(`tag`) AS `tag_count` FROM `ci_tags` WHERE `design_id` = '{$design_id}' GROUP BY `tag` ORDER BY `tag_count` LIMIT 200";
		} else {
			$query = "SELECT `tag`, COUNT(`tag`) AS `tag_count` FROM `ci_tags` GROUP BY `tag` ORDER BY `tag_count` LIMIT 200";
		}
		
		$query = "SELECT `tmp`.* FROM ({$query}) AS `tmp` ORDER BY RAND() LIMIT 20";
		
		$query = $this->db->query($query);
		
		$tags = array(
		);
		
		foreach ($query->result_array() as $row) {
			$tags[$row['tag']] = $row['tag_count'];
		}
		
		return $tags;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Популярная расцветка(В поиске)
	 * ---------------------------------------------------------------
	 */

	function get_color_cloud($limit = 10, $design_id = FALSE) {
	
		if ($design_id) {
			$query = "SELECT `color`, COUNT(`color`) AS `weight` FROM `ci_colors` WHERE `design_id` = '{$design_id}' GROUP BY `color` ORDER BY `weight` DESC LIMIT 100";
		} else {
			$query = "SELECT `color`, COUNT(`color`) AS `weight` FROM `ci_colors` GROUP BY `color` ORDER BY `weight` DESC LIMIT 100";
		}
		
		$query = "SELECT `tmp`.* FROM ({$query}) AS `tmp` ORDER BY `weight` LIMIT 20";
		
		$query = $this->db->query($query)->result_array();
		
		$this->load->library('colors');
		
		$existed = array(
		);
		foreach ($query as & $row) {
			$color = $this->colors->deformat($row['color'], $is_rgb, $is_hsv);
			
			if ($is_rgb) {
				list($r,$g,$b) = $color;
				list($r,$g,$b) = array(
					$r * 16 + $r,$g * 16 + $g,$b * 16 + $b
				);
			}
			
			if ($is_hsv) {
				list($h,$s,$v) = $color;
				list($h,$s,$v) = array(
					$h * 24 % 360,$s * 16 + $s,$v * 16 + $v
				);
				list($r,$g,$b) = $this->colors->hsv2rgb($h, $s, $v);
			}
			
			$hex = sprintf('%02x%02x%02x', $r, $g, $b);
			
			if (isset($existed[$hex])) {
				$row = FALSE;
			} else {
				$existed[$hex] = 1;
				$row['color'] = $hex;
			}
		}
		
		$query = array_filter($query);
		
		$query = array_splice($query, 0, $limit);
		
		return $query;
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Цвета наиболее используемые пользователем
	 * ---------------------------------------------------------------
	 */

	function used_colors($user_id = '', $limit = 5) {
		$this->db->limit($limit);
		
		$this->db->select('color, COUNT(color) AS color_count');
		
		$this->db->join('colors', 'designs.id = colors.design_id');
		
		$this->db->where('designs.user_id', $user_id);
		
		$this->db->group_by('color');
		
		$this->db->order_by('color_count', 'desc');
		
		$query = $this->db->get('designs');
		
		$query = $query->result_array();
		
		return $query;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод тегов для полной новости
	 * ---------------------------------------------------------------
	 */

	function get_design_tags($id) {
		$this->db->select('tag');
		
		$this->db->where('design_id', $id);
		
		$query = $this->db->get('tags')->result_array();
		
		$count = count($query);
		
		foreach ($query as & $row) {
			$row = $row['tag'];
		}
		
		return $query;
		
	}

	function count_tags($tag) {
		$this->db->where('tag', $tag);
		
		//Только открытые
		$this->db->where('status', 1);
		
		$this->db->join('designs', 'designs.id = tags.design_id');
		
		$query = $this->db->get('tags');
		
		return $query->num_rows();
	}
	
	//Для редактирования

	function delete_design_tags($design_id) {
		$this->db->where('design_id', $design_id);
		
		$this->db->delete('tags');
	}

	function delete_design_categories($design_id) {
		$this->db->where('design_id', $design_id);
		
		$this->db->delete('designs_to_categories');
	}

	function get_design_categories($design_id) {
		$this->db->select('category_id');
		
		$this->db->where('design_id', $design_id);
		
		$query = array(
		);
		
		foreach ($this->db->get('designs_to_categories')->result_array() as $row) {
			$query[$row['category_id']] = $row['category_id'];
		}
		
		return $query;
		
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод цветов для полной новости
	 * ---------------------------------------------------------------
	 */

	function get_design_colors($id) {
		return $this->get_color_cloud(10, $id);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод дополнительных изображений для полной новости
	 * ---------------------------------------------------------------
	 */

	function get_design_images($design_id) {
		$this->db->select('*');
		
		$this->db->where('design_id', $design_id);
		
		return $this->db->get('images')->result_array();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Проверка на бан
	 * ---------------------------------------------------------------
	 */

	function check_banned($design_id) {
		$this->db->select('cause');
		
		$query = $this->db->get_where('designs_banned', array(
			'design_id '=>$design_id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->cause;
		}
		
		return FALSE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Сопутствующии товары для редактирования
	 * ---------------------------------------------------------------
	 */

	function get_associated_designs_edit($id = '') {
		$this->db->select('*');
		
		$this->db->where('design_id', $id);
		
		return $this->db->get('associated')->result_array();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Сопутствующии товары
	 * ---------------------------------------------------------------
	 */

	function get_design_sub($design_id) {
		$this->db->select('designs.id, designs.title, designs.small_image1');
		
		$this->db->where('design_id', $design_id);
		
		$this->db->where('sub !=', $design_id);
		
		$this->db->distinct();
		
		$this->db->join('designs', 'associated.sub = designs.id');
		
		return $this->db->get('associated')->result_array();
	}
	
	//Для редактирования

	function delete_design_sub($design_id) {
		$this->db->where('design_id', $design_id);
		
		$this->db->delete('associated');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод дизайнов
	 * ---------------------------------------------------------------
	 */
	 
	// Новое! Вывод количества дизайнов пользователя

	function count_user_designs($user_id) {
		$this->db->where('status', 1);
		
		$this->db->where('user_id', $user_id);
		
		return $this->db->count_all_results('designs');
	}
	
	// Новое! Вывод дизайнов пользователя

	function get_user_designs($user_id, $start_page, $per_page) {
		$this->db->select('*');
		
		$this->db->join('designs_to_categories', 'designs_to_categories.design_id = id');
		
		$this->db->where('user_id', $user_id);
		
		$this->db->order_by('views', 'desc');
		
		$this->db->limit($per_page, $start_page * $per_page);
		
		return $this->db->get('designs')->result_array();
	}

	function get_designs($search = array(
	), $count = FALSE) {
		$q;
		$search = array_merge(array(
			'limit'=>20,'offset'=>0
		), $search);
		
		$where = array(
		);
		$order = array(
		);
		
		if (isset($search['buy_from'])) {
			$where[] = "`price_1` >= '{$search['buy_from']}'";
		}
		
		if (isset($search['buy_to'])) {
			$where[] = "`price_1` <= '{$search['buy_to']}'";
		}
		
		if (isset($search['buyout_from'])) {
			$where[] = "`price_2` >= '{$search['buyout_from']}'";
		}
		
		if (isset($search['buyout_to'])) {
			$where[] = "`price_2` <= '{$search['buyout_to']}'";
		}
		
		if (isset($search['category'])) {
			$categories = $this->cat_array($search['category']);
			$where[] = '`id` IN (SELECT `design_id` FROM `ci_designs_to_categories` WHERE `category_id` IN (\''.implode('\', \'', $categories).'\'))';
		}
		
		if (isset($search['tags'])) {
			$tags = preg_split('/,\s*/', $_REQUEST['tags']);
			$where[] = '`id` IN (SELECT `design_id` FROM `ci_tags` WHERE `tag` IN (\''.implode('\', \'', $tags).'\'))';
		}
		
		if (isset($search['color'])) {
			$colors = array(
			);
			$this->load->library('colors');
			
			$rgb = $this->colors->hex2rgb($search['color']);
			$rgb_s = $this->colors->downsample4rgb($rgb);
			$rgb_f = $this->colors->format4rgb($rgb_s);
			$hsv = $this->colors->rgb2hsv($rgb);
			$hsv_s = $this->colors->downsample4hsv($hsv);
			$hsv_f = $this->colors->format4hsv($hsv_s);
			
			$colors = array_merge($colors, $this->colors->proxy4rgb($rgb_f), $this->colors->proxy4hsv($hsv_f));
			/*
			 foreach($colors as $row) {
			 $color = $this->colors->deformat($row, $is_rgb, $is_hsv);
			 
			 if ($is_rgb) {
			 list($r,$g,$b) = $color;
			 list($r,$g,$b) = array(
			 $r * 16 + $r,$g * 16 + $g,$b * 16 + $b
			 );
			 }
			 
			 if ($is_hsv) {
			 list($h,$s,$v) = $color;
			 list($h,$s,$v) = array(
			 $h * 24 % 360,$s * 16 + $s,$v * 16 + $v
			 );
			 list($r,$g,$b) = $this->colors->hsv2rgb($h, $s, $v);
			 }
			 
			 $hex = sprintf('%02x%02x%02x', $r, $g, $b);
			 
			 if (isset($existed[$hex])) {
			 $row = FALSE;
			 } else {
			 $existed[$hex] = 1;
			 $row = $hex;
			 }
			 if (!$row) continue;
			 ?>
			 <a class="colorBar" style="background: #<?= $row; ?>" rel="<?= $row; ?>" href="?color=<?= $row; ?>">&nbsp;&nbsp;&nbsp;</a>
			 <?php
			 }
			 */
			$where[] = '`id` IN ( SELECT `design_id` FROM `ci_colors` WHERE `color` IN (\''.implode('\', \'', $colors).'\') ORDER BY `percent` DESC )';
		}
		
		/* ci_designs_options */
		
		if (isset($search['flash'])) {
			$where[] = "`flash` = '{$search['flash']}'";
		}
		if (isset($search['stretch'])) {
			$where[] = "`stretch` = '{$search['stretch']}'";
		}
		if (isset($search['columns'])) {
			$where[] = "`columns` = '{$search['columns']}'";
		}
		if (isset($search['destination'])) {
			$where[] = "`destination` = '{$search['destination']}'";
		}
		if (isset($search['quality'])) {
			$where[] = "`quality` = '{$search['quality']}'";
		}
		if (isset($search['type'])) {
			$where[] = "`type` = '{$search['type']}'";
		}
		if (isset($search['tone'])) {
			$where[] = "`tone` = '{$search['tone']}'";
		}
		if (isset($search['bright'])) {
			$where[] = "`bright` = '{$search['bright']}'";
		}
		if (isset($search['style'])) {
			$where[] = "`style` = '{$search['style']}'";
		}
		if (isset($search['theme'])) {
			$where[] = "`theme` = '{$search['theme']}'";
		}
		if (isset($search['adult'])) {
			$where[] = "`adult` = '{$search['adult']}'";
		}
		
		$where[] = "`moder` = '1'";
		
		if (isset($search['user_id'])) {
			$where[] = "`user_id` = '{$search['user_id']}'";
		}
		
		if (isset($search['status'])) {
			$where[] = "`status` = '{$search['status']}'";
		} else {
			$where[] = "`status` = '1'";
		}
		
		$where[] = "`id` NOT IN (SELECT `design_id` FROM `ci_designs_banned`)";
		
		if (isset($search['order_by'])) {
			$dir = isset($search['order_dir']) ? strtoupper($search['order_dir']) : 'ASC';
			$order[] = "`{$search['order_by']}` {$dir}";
		} else {
			$order[] = '`id` DESC';
		}
		
		if ($count) {
			$query = 'SELECT COUNT(*) as `count` FROM `ci_designs` INNER JOIN `ci_designs_options` ON `ci_designs`.`id` = `ci_designs_options`.`design_id` WHERE '.implode(' AND ', $where);
			$row = $this->db->query($query)->row();
			return $row->count;
		}
		
		$query = 'SELECT * FROM `ci_designs` LEFT JOIN `ci_designs_options` ON `ci_designs`.`id` = `ci_designs_options`.`design_id` WHERE '.implode(' AND ', $where);
		$query .= ' ORDER BY '.implode(', ', $order);
		$query .= " LIMIT {$search['offset']}, {$search['limit']}";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() > 0) {
			$query = $query->result_array();
			
			$count = count($query);
			
			for ($i = 0; $i < $count; $i++) {
				//Дата размещения
				$query[$i]['date'] = date_smart($query[$i]['date']);
				
				$query[$i]['section'] = $this->section($query[$i]['category']);
				
				$query[$i]['category'] = $this->name($query[$i]['category']);
				
				switch ($query[$i]['status']) {
					case 1:
						$query[$i]['status'] = 'Открыт';
						break;
					case 2:
						$query[$i]['status'] = 'Вызаказан';
						break;
					case 3:
						$query[$i]['status'] = 'Закрыт';
						break;
				}
			}
			return $query;
		}
	}

	function _tags_check($tags = array(
	)) {
		if (is_string($tags)) {
			$tags = preg_split('/,\s*/', $tags);
		}
		
		$query = 'SELECT `id` FROM `ci_tags` WHERE `tag` IN (\''.implode('\', \'', $tags).'\')';
		
		$query = $this->db->query($query);
		
		return $query->num_rows() != 0;
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Колличество дизайнов по поиску
	 * ---------------------------------------------------------------
	 */

	function count_designs($search = array(
	)) {
		return $this->get_designs($search, TRUE);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод последних добавленных дизайнов для каждой категории, по статусу
	 * ---------------------------------------------------------------
	 */

	function get_newest($category = '', $status = '', $limit = 10) {
		$this->db->limit($limit);
		
		$this->db->select('id, date, title');
		
		$this->db->order_by('date', 'desc');
		
		$this->db->where('moder', 1);
		
		if (! empty($category)) {
			$this->db->where('category', $category);
		}
		
		if (! empty($status)) {
			$this->db->where('status', $status);
		}
		
		//Если в настройках отключен показ только для взрослых
		if ($this->adult == 0) {
			$this->db->join('designs_options', 'designs.id = designs_options.design_id', 'LEFT');
			
			$this->db->where('adult', 0);
		}
		
		$query = $this->db->get('designs')->result_array();
		
		$count = count($query);
		
		for ($i = 0; $i < $count; $i++) {
			//Дата размещения
			$query[$i]['date'] = date_smart($query[$i]['date']);
		}
		
		return $query;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Похожии дизайны по тегам
	 * ---------------------------------------------------------------
	 */

	function get_similar($id, $limit = 10) {
		$query = " SELECT ci_designs.id, title, small_image1 FROM ci_tags LEFT JOIN ci_designs ON ci_tags.design_id = ci_designs.id ".
		//Исключаем сам дизайн, по которому находятся похожии
		" WHERE design_id != ".$id." and moder = 1 and tag IN (SELECT tag FROM ci_tags WHERE design_id = ".$id.")".
		
		//Дизайн существует и имеет статус открыт
		" AND design_id IN (SELECT id FROM ci_designs WHERE status = 1)".
		
		//Не выводим забаненные продукты
		" AND design_id NOT IN (SELECT design_id FROM ci_designs_banned) GROUP BY id".
		//Случайный порядок
		" ORDER BY RAND()".
		//Лимит
		" LIMIT ".$limit."";
		
		$query = $this->db->query($query);
		
		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->result_array();
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод проголосовавших пользователей
	 * ---------------------------------------------------------------
	 */

	function get_members_voted($design_id, $limit = 10) {
		$this->db->limit($limit);
		
		$this->db->select('users.*');
		
		$this->db->where('design_id', $design_id);
		
		$this->db->join('users', 'users.id = votes.user_id');
		
		return $this->db->get('votes')->result_array();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Получение id основного дизайна по дополнительному изображению
	 * ---------------------------------------------------------------
	 */

	function get_id($id = '') {
		$this->db->select('design_id');
		
		$query = $this->db->get_where('images', array(
			'id'=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			return $row->design_id;
		}
		
		return FALSE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Закрыть дизайн
	 * ---------------------------------------------------------------
	 */

	function enter($id) {
		$this->db->update('designs', array(
			'status'=>2
		), array(
			'id'=>$id
		));
		;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Закрыть дизайн
	 * ---------------------------------------------------------------
	 */

	function close($id) {
		$this->db->update('designs', array(
			'status'=>3
		), array(
			'id'=>$id
		));
		;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Добавить дополнительное изображение
	 * ---------------------------------------------------------------
	 */

	function get_themes() {
		$this->db->select('*');
		
		return $this->db->get('designs_themes')->result_array();
	}

	function theme($id) {
		$this->db->select('name');
		$query = $this->db->get_where('designs_themes', array(
			'id '=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->name;
		}
		
		return FALSE;
	}

	function get_destinations() {
		$this->db->select('*');
		
		return $this->db->get('designs_destinations')->result_array();
	}

	function destination($id) {
		$this->db->select('name');
		$query = $this->db->get_where('designs_destinations', array(
			'id '=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->name;
		}
		
		return FALSE;
	}
	
	//Для редактирования

	function get_image($id) {
		$this->db->select('*');
		
		$this->db->where('id', $id);
		
		return $this->db->get('images')->row_array();
	}
	
	//получение id пользователя проекта

	function get_user_id($id = '') {
		$this->db->select('user_id');
		$query = $this->db->get_where('designs', array(
			'id'=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			return $row->user_id;
		}
		
		return FALSE;
	}
	
	//Проверка на существование товара, для добавления заявок, отзывов

	function check($id = '', $status = '', $user_id = '') {
		if (! empty($status)) {
			$this->db->where('status', $status);
		}
		
		if (! empty($user_id)) {
			$this->db->where('user_id', $user_id);
		}
		
		$this->db->where('id', $id);
		
		return $this->db->count_all_results('designs') > 0;
	}

	function check_vote($design_id) {
		$this->db->where('design_id', $design_id);
		$this->db->where('user_id', $this->session->userdata('id'));
		$this->db->where('ip', $this->input->ip_address());
		
		return $this->db->count_all_results('votes') > 0;
	}

	function like($id) {
		$this->db->select('like');
		$query = $this->db->get_where('designs', array(
			'id'=>$id
		));
		$result = $query->row();
		
		$like = $result->like + 1;
		
		$this->db->update('designs', array(
			'like'=>$like
		), array(
			'id'=>$id
		));
		
		$data = array(
			'design_id'=>$id,'user_id'=>$this->session->userdata('id'),'ip'=>$this->input->ip_address()
		);
		
		$this->db->insert('votes', $data);
		
		$this->update_rating($id, 1);
	}

	function dislike($id) {
		$this->db->select('dislike');
		$query = $this->db->get_where('designs', array(
			'id'=>$id
		));
		$result = $query->row();
		
		$dislike = $result->dislike + 1;
		
		$this->db->update('designs', array(
			'dislike'=>$dislike
		), array(
			'id'=>$id
		));
		
		$data = array(
			'design_id'=>$id,'user_id'=>$this->session->userdata('id'),'ip'=>$this->input->ip_address()
		);
		
		$this->db->insert('votes', $data);
		
		$this->update_rating($id, 2);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Обновляем общий рейтинг
	 * ---------------------------------------------------------------
	 */

	function update_rating($id, $type) {
		$this->db->select('rating');
		
		$query = $this->db->get_where('designs', array(
			'id'=>$id
		));
		
		$rating = $query->row_array();
		
		if ($type == 1) {
			$rating = $rating['rating'] + 1;
		} else {
			$rating = $rating['rating'] - 1;
		}
		
		//Обновляем
		$this->db->update('designs', array(
			'rating'=>$rating
		), array(
			'id'=>$id
		));
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод дизайнов, для поля сопутствующии товары, *скрипт*
	 * ---------------------------------------------------------------
	 */

	function get_sub() {
		$this->db->select('id, title, small_image1');
		
		return $this->db->get('designs')->result_array();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Категории с колличеством дизайнов
	 * ---------------------------------------------------------------
	 */
	//Категории с колличеством пользователей предоставляющих данную услугу

	function get_categories() {
	
		$this->db->select('*, COUNT(`design_id`) as `number`');
		
		$this->db->join('designs_to_categories', 'designs_to_categories.category_id = id', 'LEFT');
		
		$this->db->group_by('id');
		
		$query = array(
		);
		
		foreach ($this->db->get('designs_categories')->result_array() as $item) {
			$query[$item['id']] = $item;
		}
		
		foreach ($query as & $item) {
			$item['name_path'] = array(
			);
			$parent = $item;
			do {
				array_unshift($item['name_path'], $parent['name']);
			} while ($parent = $query[$parent['parent_id']]);
		}
		
		return $query;
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Категории
	 * ---------------------------------------------------------------
	 */

	function name($id) {
		$this->db->select('name');
		$query = $this->db->get_where('designs_categories', array(
			'id '=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->name;
		}
		
		return FALSE;
	}
	
	//Раздел узнаём

	function section($id) {
		$this->db->select('parent_id');
		$query = $this->db->get_where('designs_categories', array(
			'id '=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $this->name($row->parent_id);
		}
		
		return FALSE;
	}

	function title($id) {
		$this->db->select('title');
		
		$query = $this->db->get_where('designs_categories', array(
			'id '=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			return $row->title;
		}
		
		return FALSE;
	}
	
	//С выводом подкатегории

	function design_title($id) {
		$this->db->select('parent_id, title');
		
		$query = $this->db->get_where('designs_categories', array(
			'id '=>$id
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			$parent_id = $row->parent_id;
			
			//Если не раздел
			if ($parent_id != 0) {
				$title = $row->title;
				
				$title .= ' | '.$this->name($parent_id);
				
				return $title;
			}
			
			//Иначе просто выводим заголовок
			return $row->title;
		}
		
		return FALSE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Получаем категорию или массив категорий
	 * ---------------------------------------------------------------
	 */

	function cat_array($id) {
		$result = $this->db->query("SELECT `id` FROM `ci_designs_categories` WHERE `parent_id` = '{$id}' OR `id` = '{$id}'")->result_array();
		
		foreach ($result as & $row) {
			$row = $row['id'];
		}
		
		return $result;
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Проверка сущестования категории
	 * ---------------------------------------------------------------
	 */

	function category_check($id) {
		$this->db->where('id', $id);
		
		return $this->db->count_all_results('designs_categories') > 0;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Дата последнего добавления отзыва
	 * ---------------------------------------------------------------
	 */
	//Дата последнего добавления отзыва пользователем

	function last_comment($design_id = '', $user_id = '') {
		$this->db->select_max('date');
		
		$query = $this->db->get_where('designs_comments', array(
			'design_id'=>$design_id,'user_id'=>$user_id,
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			return $row->date;
		}
		
		return FALSE;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Вывод комментариев
	 * ---------------------------------------------------------------
	 */

	function get_comments($design_id) {
		$this->db->order_by('date', 'desc');
		
		$this->db->select('designs_comments.*, users.username, users.userpic');
		
		$this->db->where('design_id', $design_id);
		
		$this->db->join('users', 'users.id = designs_comments.user_id');
		
		$query = $this->db->get('designs_comments')->result_array();
		
		$count = count($query);
		
		for ($i = 0; $i < $count; $i++) {
			$query[$i]['date'] = date_smart($query[$i]['date']);
		}
		
		return $query;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Рассылки, подписчики по пользователю
	 * ---------------------------------------------------------------
	 */
	//Выводим тех кто помечен на рассылку к этому пользователю

	function get_mailer_users($user_id) {
		$this->db->select('users_followers.user_id, users.username, users.surname, users.name, users.email');
		
		$this->db->where('follows', $user_id);
		
		$this->db->join('users', 'users.id = users_followers.user_id');
		
		return $this->db->get('users_followers')->result_array();
	}
	/**
	 * ---------------------------------------------------------------
	 *	Рассылки, подписчики по рубрике
	 * ---------------------------------------------------------------
	 */
	//Выводим тех кто помечен на рассылку на эту рубрику

	function get_mailer_categories($category, $user_id) {
		$this->db->select('categories_followers.user_id, users.username, users.surname, users.name, users.email');
		
		$this->db->where('category', $category);
		
		$this->db->where('categories_followers.user_id !=', $user_id);
		
		$this->db->join('users', 'users.id = categories_followers.user_id');
		
		return $this->db->get('categories_followers')->result_array();
	}
}
