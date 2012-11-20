<?php 
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Designs extends Controller {
	public $user_id;
	
	public $username;
	
	public $userpic;
	
	public $adult;
	
	public $team;

	function __construct() {
		parent::Controller();
		$this->load->library('pagination');
		$this->load->model('blogs/blogs_mdl');
		$this->load->model('designs/designs_mdl');
		$this->load->helper('highslide');
		if ($this->users_mdl->logged_in()) {
			$this->user_id = $this->session->userdata('id');
			
			$user = $this->users_mdl->get_user_by_id($this->user_id);
			$this->username = $user->username;
			$this->userpic = $user->userpic;
			$this->team = $user->team;
			$this->adult = $this->settings->value($this->user_id, 'adult');
		} else {
			$this->adult = 0;
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Главная
	 * ---------------------------------------------------------------
	 */

	function main() {
		$title = $this->config->item('title');
		
		// TODO Выводим последнии 20 дизайнов, сделать через настройку
		$data['data'] = $this->designs_mdl->get_designs(0, 10);
		
		/**
		 * Блок
		 */
		$this->load->model('news/news_mdl');
		
		//Новости сервиса
		$data['news'] = $this->news_mdl->get_newest(3);
		
		//Всего дизайнов
		$data['count_designs'] = $this->designs_mdl->count_designs();
		
		//Всего пользователей
		$data['count_users'] = $this->users_mdl->count_users();
		
		//Топ 10 пользователей
		$data['top_users'] = $this->users_mdl->get_top_users();
		
		//Новые исполнители
		$data['newest_users'] = $this->users_mdl->get_newest_users();
		
		//Пользовательский рейтинг
		$data['top_designs'] = $this->designs_mdl->get_designs(array(
			'order_by'=>'rating','order_dir'=>'desc','limit'=>4,'offset'=>0,
		));
		
		$data['descr'] = $this->config->item('description');
		$data['keywords'] = $this->config->item('keywords');
		
		//Популярные дизайны
		$data['tagcloud'] = $this->tagcloud();
		
		$this->template->build('designs/main', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Дизайны
	 * ---------------------------------------------------------------
	 */

	function index($offset = 0) {
		$title = 'Дизайны сайта. Купить шаблон для сайта, Купить дизайн сайта';
		
		$search = array(
			'offset'=>intval($offset)
		);
		
		if (! empty($_REQUEST['limit'])) {
			$search['limit'] = min(20, intval($_REQUEST['limit']));
		}
		
		if (! empty($_REQUEST['category']) and $this->_category_check($_REQUEST['category'])) {
			$search['category'] = $_REQUEST['category'];
			$title = $this->designs_mdl->design_title($_REQUEST['category']).' | '.$title;
		}
		
		//Сортировка
		switch (! empty($_REQUEST['order_by'])) {
			default:
			case ($_REQUEST['order_by'] == 'title'):
				$search['order_by'] = 'title';
				break;
			case ($_REQUEST['order_by'] == 'buy_price'):
				$search['order_by'] = 'buy_price';
				break;
			case ($_REQUEST['order_by'] == 'buyout_price'):
				$search['order_by'] = 'buyout_price';
				break;
			case ($_REQUEST['order_by'] == 'rating'):
				$search['order_by'] = 'rating';
				break;
			case ($_REQUEST['order_by'] == 'sales'):
				$search['order_by'] = 'sales';
				break;
		}
		
		//Тип сортировки
		switch (! empty($_REQUEST['order_dir'])) {
			default:
			case ($_REQUEST['order_dir'] == 'asc'):
				$search['order_dir'] = 'asc';
				break;
			case ($_REQUEST['order_dir'] == 'desc'):
				$search['order_dir'] = 'desc';
				break;
		}
		
		$data['data'] = $this->designs_mdl->get_designs($search);
		$total_rows = $this->designs_mdl->count_designs($search);
		$data['total_rows'] = $total_rows;
		
		$this->pagination->initialize(array(
			'base_url'=>base_url().'/designs/search/','total_rows'=>$total_rows,'per_page'=>20,
		));
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($data['url'])) {
			$data['page_links'] = str_replace('">', '/?'.$data['url'].'">', $data['page_links']);
		}
		
		$data['search'] = $search;
		/**
		 * Блок
		 */
		// Категории
		$data['categories'] = $this->designs_mdl->get_categories();
		$data['colorbars'] = $this->designs_mdl->get_color_cloud();
		$this->template->build('designs/index', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Поиск
	 * ---------------------------------------------------------------
	 */

	function search($offset = 0) {
		$title = 'Поиск дизайнов сайта';
		
		$search = array(
			'offset'=>intval($offset)
		);
		
		if (! empty($_REQUEST['limit'])) {
			$search['limit'] = min(20, intval($_REQUEST['limit']));
		}
		
		if (! empty($_REQUEST['category']) and $this->_category_check($_REQUEST['category'])) {
			$search['category'] = $_REQUEST['category'];
			$title = $this->designs_mdl->design_title($_REQUEST['category']).' | '.$title;
		}
		
		//empty($_REQUEST['tags']) or $search['tags'] = preg_split('/,\s*/', $_REQUEST['tags']);
		//empty($_REQUEST['colors']) or $search['colors'] = preg_split('/,\s*/', $_REQUEST['colors']);
		
		// XXX fuck!
		empty($_REQUEST['tags']) or $search['tags'] = $_REQUEST['tags'];
		empty($_REQUEST['color']) or $search['color'] = $_REQUEST['color'];
		
		empty($_REQUEST['buy_from']) or $search['buy_from'] = $_REQUEST['buy_from'];
		empty($_REQUEST['buy_to']) or $search['buy_to'] = $_REQUEST['buy_to'];
		empty($_REQUEST['buyout_from']) or $search['buyout_from'] = $_REQUEST['buyout_from'];
		empty($_REQUEST['buyout_to']) or $search['buyout_to'] = $_REQUEST['buyout_to'];
		
		//Сортировка
		switch (! empty($_REQUEST['order_by'])) {
			default:
			case ($_REQUEST['order_by'] == 'title'):
				$search['order_by'] = 'title';
				break;
			case ($_REQUEST['order_by'] == 'buy_price'):
				$search['order_by'] = 'buy_price';
				break;
			case ($_REQUEST['order_by'] == 'buyout_price'):
				$search['order_by'] = 'buyout_price';
				break;
			case ($_REQUEST['order_by'] == 'rating'):
				$search['order_by'] = 'rating';
				break;
			case ($_REQUEST['order_by'] == 'sales'):
				$search['order_by'] = 'sales';
				break;
		}
		
		//Тип сортировки
		switch (! empty($_REQUEST['order_dir'])) {
			default:
			case ($_REQUEST['order_dir'] == 'asc'):
				$search['order_dir'] = 'asc';
				break;
			case ($_REQUEST['order_dir'] == 'desc'):
				$search['order_dir'] = 'desc';
				break;
		}
		
		$data['data'] = $this->designs_mdl->get_designs($search);
		$total_rows = $this->designs_mdl->count_designs($search);
		$data['total_rows'] = $total_rows;
		
		$this->pagination->initialize(array(
			'base_url'=>base_url().'/designs/search/','total_rows'=>$total_rows,'per_page'=>20,
		));
		
		$data['page_links'] = $this->pagination->create_links();
		
		if (! empty($data['url'])) {
			$data['page_links'] = str_replace('">', '/?'.$data['url'].'">', $data['page_links']);
		}
		
		$data['search'] = $search;
		/**
		 * Блок
		 */
		// Категории
		$data['categories'] = $this->designs_mdl->get_categories();
		$data['colorbars'] = $this->designs_mdl->get_color_cloud();
		$this->template->build('designs/search', $data, $title);
	}
	/**
	 * ---------------------------------------------------------------
	 *	Добавить дополнительные изображения
	 * ---------------------------------------------------------------
	 */

	function images_add($design_id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если не существует дизайна со статусом открыт у пользователя
		if (!$this->_check_action($design_id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->load->library('upload');
		$this->load->library('Image_lib');
		
		if (!$this->errors->access()) {
			return;
		}
		
		$rules = array(
			array(
				'field'=>'title','label'=>'Заголовок','rules'=>'required|text|max_length[64]'
			),array(
				'field'=>'text','label'=>'Краткое описание','rules'=>'required|max_length[255]'
			)
		);
		
		if (isset($_FILES['userfile']['tmp_name'])) {
			$config['encrypt_name'] = TRUE;
			$config['upload_path'] = './files/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['max_size'] = '1000';
			$config['max_width'] = '1600';
			$config['max_height'] = '1200';
			
			$this->upload->initialize($config);
			unset($config);
			
			if ($this->upload->do_upload()) {
			
				$data = $this->upload->data();
				
				$path = './files/images/'.$data['file_name'].'';
				
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 120;
				$config['new_image'] = './files/images/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_small';
				
				$this->image_lib->initialize($config);
				
				$this->image_lib->resize();
				
				//Дальше работаем над остальными полями
				$this->form_validation->set_rules($rules);
				
				if ($this->form_validation->run()) {
					$data = array(
						'design_id'=>$design_id,'date'=>now(),'title'=>$this->input->post('title'),
							'descr'=>htmlspecialchars($this->input->post('text')),'small_image'=>'/files/images/'.$data['raw_name'].'_small'.$data['file_ext'],
							'full_image'=>'/files/images/'.$data['file_name']
					);
					
					$this->designs_mdl->add('images', $data);
					
					//Перекидываем на страницу вывода изображений
					redirect('designs/'.$design_id.'.html');
				}
				
			} else {
				$data['error'] = $this->upload->display_errors();
			}
			
		}
		
		if ( empty($data)) {
			$data = '';
		}
		
		$this->template->build('designs/images_add', $data, $title = 'Добавить изображение | Дизайн');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Редактировать дополнительное изображение
	 * ---------------------------------------------------------------
	 */

	function images_edit($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		$designdata = $this->designs_mdl->get_image($id);
		
		//Для проверки + для редиректа
		$design_id = $designdata['design_id'];
		
		//Если не существует дизайна со статусом открыт у пользователя
		if (!$this->_check_action($design_id)) {
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
			$config['upload_path'] = './files/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['max_size'] = '1000';
			$config['max_width'] = '1600';
			$config['max_height'] = '1200';
			
			$this->upload->initialize($config);
			unset($config);
			
			if ($this->upload->do_upload()) {
				$data = $this->upload->data();
				
				$path = './files/images/'.$data['file_name'].'';
				
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 120;
				$config['height'] = 120;
				$config['new_image'] = './files/images/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_small';
				
				$this->image_lib->initialize($config);
				
				$this->image_lib->resize();
				
				$small_image = '/files/images/'.$data['raw_name'].'_small'.$data['file_ext'];
				$full_image = '/files/images/'.$data['file_name'];
			}
			
		}
		
		//Если не существует, оставляем прошлые изображения
		if (!isset($small_image) or !isset($full_image)) {
			$small_image = $designdata['small_image'];
			$full_image = $designdata['full_image'];
		}
		
		//Дальше работаем над остальными полями
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$data = array(
				'title'=>$this->input->post('title'),'descr'=>htmlspecialchars($this->input->post('text')),
					'small_image'=>$small_image,'full_image'=>$full_image
			);
			
			$this->designs_mdl->edit('images', $id, $data);
			
			//Перекидываем на страницу вывода изображений
			redirect('designs/'.$design_id.'.html');
		}
		
		$this->template->build('designs/images_edit', $designdata, $title = 'Редактировать изображение | Дизайн');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Удалить изображение, находим id дизайна а затем делаем проверку
	 * ---------------------------------------------------------------
	 */

	function images_del($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		$design_id = $this->designs_mdl->get_id($id);
		
		//Если не существует дизайна со статусом ожидание
		if (!$this->_check_action($design_id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->designs_mdl->del('images', $id);
		
		redirect('/designs/'.$design_id.'.html');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Пользовательское голосование
	 * ---------------------------------------------------------------
	 */

	function vote() {
		$id = $this->input->post('id');
		
		$type = $this->input->post('type');
		
		if ( empty($id)) {
			return FALSE;
		}
		
		$data = $this->designs_mdl->get_edit($id);
		
		//Если дизайн уже был добавлен в корзину
		if ($this->user_id == $data['user_id']) {
			echo 'Дизайн принадлежит вам!';
			die;
		}
		
		if ($this->designs_mdl->check_vote($id)) {
			echo 'Вы уже голосовали!';
			die;
		}
		
		if ($type == 1) {
			$this->designs_mdl->like($id);
		} else {
			$this->designs_mdl->dislike($id);
		}
		
		$data = $this->designs_mdl->get_edit($id);
		
		print('
							<p>Оценка дизайна:</p>
							<a href="#" onclick="vote('.$id.', 1)" class="plus">+</a>
							<span>'.$data['rating'].'</span>
							<a href="#" onclick="vote('.$id.', 2)" class="minus">-</a>');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Просмотр
	 * ---------------------------------------------------------------
	 */

	function view($id = '') {
		if (!$data = $this->designs_mdl->get($id)) {
			show_404('page');
		}
		
		if ($cause = $this->_check_banned($data['id'])) {
			show_error('Дизайн заблокирован.<br><br>Причина: '.$cause.'');
		}
		
		$this->load->helper('tinymce');
		
		//Смайлы
		$this->load->helper('smiley');
		//Создание таблиц
		$this->load->library('table');
		
		$this->designs_mdl->update_views($id);
		
		/**
		 * Блок
		 */
		//Дизайны данной категории
		$data['newest_designs'] = $this->designs_mdl->get_newest($data['category_id'], $data['status_id']);
		
		//Похожии дизайны
		$data['similar_designs'] = $this->designs_mdl->get_similar($id);
		
		//Проголосовавшии пользователи
		$data['members_voted'] = $this->designs_mdl->get_members_voted($id);
		
		//Тэги дизайна
		$data['tags'] = $this->designs_mdl->get_design_tags($id);
		
		//Расцветка дизайна
		$data['colors'] = $this->designs_mdl->get_design_colors($id);
		
		//Дополнительные изображения
		$data['images'] = $this->designs_mdl->get_design_images($id);
		
		//Сопутствующии товары
		$data['sub'] = $this->designs_mdl->get_design_sub($id);
		
		/**
		 * Комментарии
		 */
		if ($this->input->post('newcomment') and $this->users_mdl->logged_in()) {
		
			//Если комментатор добавляет не автор
			if ($data['user_id'] != $this->user_id) {
			
				//От текущей даты отнимаем дату последнего добавления отзыва
				$date = now() - $this->designs_mdl->last_comment($id, $this->user_id);
				
				//Если остаток даты меньше чем заданный в настройках
				if ($date < $this->config->item('comments_add')) {
					$left_date = $this->config->item('comments_add') - $date;
					$left_date = now() + $left_date;
					$left_date = date_await($left_date);
					
					show_error('Следующий комментарий вы сможете добавить через '.$left_date.'');
				}
				
			}
			
			$rules = array(
				array(
					'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
				)
			);
			
			$data_comment = array(
				'date'=>now(),'design_id'=>$id,'user_id'=>$this->user_id,'text'=>$this->input->post('text')
			);
			
			$this->form_validation->set_rules($rules);
			
			if ($this->form_validation->run()) {
				$this->designs_mdl->add('designs_comments', $data_comment);
				
				redirect('designs/'.$id.'.html');
			}
		}
		
		$comments['data'] = $this->designs_mdl->get_comments($id);
		
		//Смайлы
		$image_array = get_clickable_smileys('/img/smileys/');
		
		$col_array = $this->table->make_columns($image_array, 20);
		
		$comments['smiley'] = $this->table->generate($col_array);
		
		//Популярные дизайны
		$data['tagcloud'] = $this->tagcloud();
		//категории
		$data['categories'] = $this->designs_mdl->get_categories();
		
		$data['comments'] = $this->load->view('wdesigns/designs/comments', $comments, TRUE);
		
		$data['user_is_owner'] = ($data['user_id'] == $this->user_id);
		
		$this->template->build('designs/view', $data, $title = ''.$data['title'].' | Дизайны сайта');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Облако тегов
	 * ---------------------------------------------------------------
	 */

	function tagcloud() {
		$tagcloud = $this->designs_mdl->get_tag_cloud();
		
		asort($tagcloud);
		
		$min = reset($tagcloud);
		$max = end($tagcloud);
		
		$minSize = 1;
		$maxSize = 5;
		$out = '';
		$outPages = '';
		$tagsCount = 0;
		
		// здесь можно задать сортировку элементов
		// большие метки в начале
		arsort($tagcloud);
		
		foreach ($tagcloud as $tag=>$count) {
			$fontSize = round((($count - $min) / ($max - $min)) * ($maxSize - $minSize) + $minSize);
			$tagsCount++;
			if (!($tagsCount % 9)) {
				$out .= "<li><a class=\"size".$fontSize."\" href=\"/designs/search/?tags=".$tag."\"><span>".$tag."</span></a></li>";
				$outPages .= "<li><ul class=\"tagsCloudBlock\">".$out."</ul></li>";
				$out = '';
			} else {
				$out .= "<li><a class=\"size".$fontSize."\" href=\"/designs/search/?tags=".$tag."\"><span>".$tag."</span></a></li>";
			}
			
		}
		
		//добавил нужные обертки
		return $outPages;
	}
	/**
	 * ---------------------------------------------------------------
	 *	Отправить жалобу
	 * ---------------------------------------------------------------
	 */

	function send_report() {
		$id = $this->input->post('id');
		$text = $this->input->post('text');
		
		$data = array(
			'design_id'=>$id,'user_id'=>$this->user_id,'date'=>now(),'text'=>$text,'status'=>1
		);
		
		$this->designs_mdl->add('reports', $data);
	}
	/**
	 * ---------------------------------------------------------------
	 *	jquery-autocomplete
	 * ---------------------------------------------------------------
	 */
	//Все существующии тэги

	function tags() {
		$tags = $this->designs_mdl->get_tags($_REQUEST['term'], 10);
		
		foreach ($tags as & $tag) {
			$tag = $tag['tag'];
		}
		
		sort($tags);
		
		echo json_encode($tags);
	}
	
	//Все существующии дизайны, для поля сопутствующии товары

	function sub() {
		parse_str($_SERVER['QUERY_STRING'], $_GET);
		
		$q = strtolower($_GET["q"]);
		
		if (!$q)
			return;
			
		$designs = $this->designs_mdl->get_sub();
		
		foreach ($designs as $row) {
			if (strpos(strtolower($row['id']), $q) !== false) {
				echo "".$row['id']."|".$row['title']."|".$row['small_image']."\n";
			}
		}
	}
	/**
	 * ---------------------------------------------------------------
	 *	Добавить дизайн
	 * ---------------------------------------------------------------
	 */

	function add() {
		if (!$this->errors->access()) {
			return;
		}
		
		$this->load->library('upload');
		$this->load->library('Image_lib');
		$this->load->helper('text');
		
		$rules = array(
			array(
				'field'=>'title','label'=>'Заголовок','rules'=>'required|text|max_length[64]'
			),array(
				'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
			),array(
				'field'=>'category_id','label'=>'Категория','rules'=>'required'
			),array(
				'field'=>'price_1','label'=>'Цена','rules'=>'required|numeric'
			),array(
				'field'=>'price_2','label'=>'Цена выкупа','rules'=>'required|numeric'
			),array(
				'field'=>'source','label'=>'Исходники','rules'=>'required'
			),array(
				'field'=>'tags','label'=>'Тэги','rules'=>'required|callback__tags_check'
			),/**
			 * ---------------------------------------------------------------
			 *	Дополнительные параметры, для запоминания
			 * ---------------------------------------------------------------
			 */array(
				'field'=>'sub','label'=>'Сопутствующие товары','rules'=>'max_length[64]'
			),array(
				'field'=>'flash','label'=>'Флэш','rules'=>'numeric'
			),array(
				'field'=>'stretch','label'=>'Стретч','rules'=>'numeric'
			),array(
				'field'=>'columns','label'=>'Количество колонок','rules'=>'numeric'
			),array(
				'field'=>'destination','label'=>'Назначение сайта','rules'=>'numeric'
			),array(
				'field'=>'quality','label'=>'Тех Качество','rules'=>'numeric'
			),array(
				'field'=>'type','label'=>'Тип Верстки','rules'=>'numeric'
			),array(
				'field'=>'tone','label'=>'Тон','rules'=>'numeric'
			),array(
				'field'=>'bright','label'=>'Яркость','rules'=>'numeric'
			),array(
				'field'=>'style','label'=>'Стиль','rules'=>'numeric'
			),array(
				'field'=>'theme','label'=>'Тема','rules'=>'numeric'
			),array(
				'field'=>'adult','label'=>'Только для взрослых','rules'=>'numeric'
			)
		);
		
		$this->form_validation->set_rules($rules);
		
		$form_validation = $this->form_validation->run();
		/**
		 * ---------------------------------------------------------------
		 *	Загрузка изображения
		 * ---------------------------------------------------------------
		 */
		if (isset($_FILES['userfile']['tmp_name']) and $form_validation) {
			$config['encrypt_name'] = TRUE;
			$config['upload_path'] = './files/designs/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '2000';
			//$config['max_width'] = '2048';
			//$config['max_height'] = '2048';
			
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload()) {
				$data = $this->upload->data();
				
				$path = './files/designs/'.$data['file_name'].'';
				
				// resizing thumb
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 200;
				$config['height'] = 200;
				$config['new_image'] = './files/designs/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_small';
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				// croping thumb
				$thumb = $this->image_lib->full_dst_path;
				$config['source_image'] = $thumb;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 138;
				$config['height'] = 88;
				$config['new_image'] = $thumb;
				$config['create_thumb'] = FALSE;
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
				
				// Creating BW thumb
				$thumb = $this->image_lib->full_dst_path;
				$config['source_image'] = $thumb;
				$config['width'] = 138;
				$config['height'] = 88;
				$config['new_image'] = $thumb;
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = 'bw';
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->grayscale();
				
				// resizing big thumb
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 400;
				$config['height'] = 400;
				$config['new_image'] = './files/designs/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_mid';
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				// CROPING BIG THUMB
				$thumb = $this->image_lib->full_dst_path;
				$config['source_image'] = $thumb;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = 358;
				$config['height'] = 288;
				$config['new_image'] = $thumb;
				$config['create_thumb'] = FALSE;
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
				
				//Налаживаем водяной знак
				if ($this->input->post('watermark')) {
					$config['source_image'] = $path;
					$config['wm_type'] = 'overlay';
					$config['wm_overlay_path'] = './img/watermark/watermark.png';
					$config['wm_vrt_alignment'] = 'bottom';
					$config['wm_hor_alignment'] = 'right';
					$config['create_thumb'] = FALSE;
					$this->image_lib->initialize($config);
					$this->image_lib->watermark();
				}
				
			} else {
				$data['error'] = $this->upload->display_errors();
			}
		}
		/**
		 * ---------------------------------------------------------------
		 *	Загрузка файла
		 * ---------------------------------------------------------------
		 */
		if (isset($_FILES['file']['tmp_name']) and $form_validation) {
			//Если не существует папки у пользователя
			if (!file_exists('./files/download/'.$this->username.'')) {
				mkdir('./files/download/'.$this->username.'', 0777, true);
			}
			
			$config['encrypt_name'] = TRUE;
			$config['upload_path'] = './files/download/'.$this->username.'/';
			$config['allowed_types'] = '7z|gz|zip|rar|psd|ai|png';
			$config['max_size'] = '100000';
			
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload("file")) {
				$data_file = $this->upload->data();
				
				$path = './files/download/'.$this->username.'/'.$data_file['file_name'].'';
			} else {
				$data['error'] = $this->upload->display_errors();
			}
			
		}
		
		//Дальше работаем над остальными полями
		//Форма должна пройти валидацию и пройти все загрузки без ошибок
		if ($form_validation and !isset($data['error'])) {
			$full_image = 'files/designs/'.$data['file_name'].'';
			
			//Модерация
			$moder = $this->config->item('moder');
			
			$data = array(
				'user_id'=>$this->user_id,'date'=>now(),'title'=>$this->input->post('title'),
					'text'=>htmlspecialchars($this->input->post('text')),
				//Описание для SE
				'descr'=>character_limiter(htmlspecialchars($this->input->post('text')), 255),
					'category'=>$this->input->post('category_id'),'price_1'=>$this->input->post('price_1'),
					'price_2'=>$this->input->post('price_2'),'source'=>htmlspecialchars($this->input->post('source')),
					'small_image'=>'/files/designs/'.$data['raw_name'].'_small'.$data['file_ext'],
					'smallbw_image'=>'/files/designs/'.$data['raw_name'].'_smallbw'.$data['file_ext'],
					'mid_image'=>'/files/designs/'.$data['raw_name'].'_mid'.$data['file_ext'],'full_image'=>'/files/designs/'.$data['file_name'],
					'dfile'=>$this->username.'/'.$data_file['file_name'],'status'=>1,'moder'=>$moder
			);
			
			$this->designs_mdl->add('designs', $data);
			
			$design_id = $this->db->insert_id();
			
			//Сохраняем переменную для рассылки по рубрикам
			$category = $data['category'];
			
			/**
			 * ---------------------------------------------------------------
			 *	Цвета
			 * ---------------------------------------------------------------
			 */
			 
			$this->load->library('colors');
			
			if ($this->colors->loadImage($full_image)) {
				$histogram = $this->colors->getStat();
			}
			
			$a = array(
			);
			foreach ($histogram as $value=>$count) {
				$a[] = "('{$design_id}', '{$value}', '{$count}')";
			}
			
			$a = implode(', ', $a);
			
			$query = "INSERT INTO ci_colors (design_id, color, percent) VALUES {$a}";
			
			$query = $this->db->query($query);
			
			/**
			 * ---------------------------------------------------------------
			 *	Тэги
			 * ---------------------------------------------------------------
			 */
			 
			$color_tags = array(
			);
			
			foreach ($this->db->query('SELECT `tag`, `color`, `range` FROM `ci_color_tags`')->result_object() as $color_tag) {
			
				$colors = array_merge($this->colors->proxy4rgb($color_tag->color, $color_tag->range), $this->colors->proxy4hsv($color_tag->color, $color_tag->range));
				
				foreach ($histogram as $value=>$count) {
					if (array_search($value, $colors) !== FALSE) {
						$color_tags[] = $color_tag->tag;
					}
				}
			}
			
			$tags = preg_split('/[\s,]+/', strtolower($this->input->post('tags')));
			
			$tags = array_merge($tags, $color_tags);
			
			$tags = array_unique($tags);
			
			$tags = array_filter($tags);
			$a = array(
			);
			foreach ($tags as $value) {
				$a[] = "('{$design_id}', '{$value}')";
			}
			
			$a = implode(', ', $a);
			
			$query = "INSERT INTO ci_tags (design_id, tag) VALUES ".$a;
			
			$query = $this->db->query($query);
			
			/**
			 * ---------------------------------------------------------------
			 *	Сопутствующии товары
			 * ---------------------------------------------------------------
			 */
			 
			$sub = $this->input->post('sub');
			if (! empty($sub)) {
				$sub = preg_split('/[\s,]+/', strtolower($sub));
				
				$sub = array_unique($sub);
				
				$sub = array_filter($sub);
				$a = array(
				);
				//Вставка данных
				foreach ($sub as $row=>$value) {
					$a[] = "('{$design_id}', '{$value}')";
				}
				
				$a = implode(', ', $a);
				
				$query = "INSERT INTO ci_associated (design_id, sub) VALUES ".$a;
				
				$query = $this->db->query($query);
			}
			/**
			 * ---------------------------------------------------------------
			 *	Дополнительные параметры, отдельная таблица
			 * ---------------------------------------------------------------
			 */
			$data = array(
				'design_id'=>$design_id,'flash'=>$this->input->post('flash'),'stretch'=>$this->input->post('stretch'),
					'columns'=>$this->input->post('columns'),'destination'=>$this->input->post('destination'),
					'quality'=>$this->input->post('quality'),'type'=>$this->input->post('type'),
					'tone'=>$this->input->post('tone'),'bright'=>$this->input->post('bright'),'style'=>$this->input->post('style'),
					'theme'=>$this->input->post('theme'),'adult'=>$this->input->post('adult')
			);
			if ( empty($data['destination']))
				$data['destination'] = NULL;
			;
			if ( empty($data['theme']))
				$data['theme'] = NULL;
			//var_dump($data);
			//die;
			$this->designs_mdl->add_options($data);
			/**
			 * ---------------------------------------------------------------
			 *	Рассылка/По пользователю/По рубрикам
			 * ---------------------------------------------------------------
			 */
			//По пользователю выбираем всех пользователей(user_id) которые следуют за follows и рассылаем
			$mailer = $this->designs_mdl->get_mailer_users($this->user_id);
			
			foreach ($mailer as $row) {
				$data = array(
					'username'=>$row['username'],'follows_username'=>$this->username,'design_id'=>$design_id
				);
				
				$subject = 'Рассылка';
				
				$message = $this->load->view('emails/new_design_users_followers', $data, TRUE);
				
				$this->common->email($row['email'], $subject, $message);
			}
			//По рубрике выбираем всех пользователей(user_id) которые подписаны на рубрику(category) и рассылаем
			$mailer = $this->designs_mdl->get_mailer_categories($category, $this->user_id);
			
			foreach ($mailer as $row) {
				$data = array(
					'username'=>$row['username'],'design_id'=>$design_id
				);
				
				$subject = 'Рассылка';
				
				$message = $this->load->view('emails/new_design_categories_followers', $data, TRUE);
				
				$this->common->email($row['email'], $subject, $message);
			}
			
			/**
			 * ---------------------------------------------------------------
			 *	Повышение репутации
			 * ---------------------------------------------------------------
			 */
			$this->events->create($this->user_id, 'Продукт добавлен', 'add_design');#Событие с репутацией
			
			if ($moder == 0) {
				show_error('Дизайн успешно добавлен, после модерации он будет доступен пользователям на главной странице сервиса.');
			} else {
				redirect('designs/'.$design_id.'.html');
			}
		}
		
		$data['categories'] = $this->designs_mdl->get_categories();
		
		$data['themes'] = $this->designs_mdl->get_themes();
		
		$data['destinations'] = $this->designs_mdl->get_destinations();
		
		$this->template->build('designs/add', $data, $title = 'Добавить дизайн');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Редактирование дизайна
	 * ---------------------------------------------------------------
	 */

	function edit($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если не существует дизайна со статусом ожидание У ПОЛЬЗОВАТЕЛЯ
		if (!$this->_check_action($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->load->library('upload');
		$this->load->library('Image_lib');
		$this->load->helper('text');
		
		$rules = array(
			array(
				'field'=>'title','label'=>'Заголовок','rules'=>'required|text|max_length[64]'
			),array(
				'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
			),array(
				'field'=>'category_id','label'=>'Категория','rules'=>'required'
			),array(
				'field'=>'price_1','label'=>'Цена','rules'=>'required|numeric'
			),array(
				'field'=>'price_2','label'=>'Цена выкупа','rules'=>'required|numeric'
			),array(
				'field'=>'source','label'=>'Исходники','rules'=>'required'
			),array(
				'field'=>'tags','label'=>'Тэги','rules'=>'required|callback__tags_check'
			)
		);
		
		$this->form_validation->set_rules($rules);
		
		$form_validation = $this->form_validation->run();
		
		if (isset($_FILES['userfile']['tmp_name']) and $form_validation) {
			$config['encrypt_name'] = TRUE;
			$config['upload_path'] = './files/designs/';
			$config['allowed_types'] = 'jpg|png|jpeg|JPG';
			$config['max_size'] = '2000';
			$config['max_width'] = '1800';
			$config['max_height'] = '1800';
			
			$this->upload->initialize($config);
			unset($config);
			
			if ($this->upload->do_upload()) {
				$data = $this->upload->data();
				
				$path = './files/designs/'.$data['file_name'].'';
				
				// RESIZING THUMB
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 200;
				$config['height'] = 200;
				$config['new_image'] = './files/designs/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_small';
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				// CROPING THUMB
				$thumb = $this->image_lib->full_dst_path;
				$config['source_image'] = $thumb;
				$config['maintain_ratio'] = false;
				$config['width'] = 138;
				$config['height'] = 88;
				$config['new_image'] = $thumb;
				$config['create_thumb'] = false;
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
				
				// Creating BW thumb
				$thumb = $this->image_lib->full_dst_path;
				$config['source_image'] = $thumb;
				$config['width'] = 138;
				$config['height'] = 88;
				$config['new_image'] = $thumb;
				$config['create_thumb'] = true;
				$config['thumb_marker'] = 'bw';
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->grayscale();
				
				// RESIZING BIG THUMB
				$config['source_image'] = $path;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 400;
				$config['height'] = 400;
				$config['new_image'] = './files/designs/'.$data['file_name'].'';
				$config['create_thumb'] = TRUE;
				$config['thumb_marker'] = '_mid';
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				
				// CROPING BIG THUMB
				$thumb = $this->image_lib->full_dst_path;
				$config['source_image'] = $thumb;
				$config['maintain_ratio'] = false;
				$config['width'] = 358;
				$config['height'] = 288;
				$config['new_image'] = $thumb;
				$config['create_thumb'] = false;
				$this->image_lib->initialize($config);
				$this->image_lib->crop();
				
				//Налаживаем водяной знак
				if ($this->input->post('watermark')) {
					$config['source_image'] = $path;
					$config['wm_type'] = 'overlay';
					$config['wm_overlay_path'] = './img/watermark/watermark.png';
					$config['wm_vrt_alignment'] = 'bottom';
					$config['wm_hor_alignment'] = 'right';
					$config['create_thumb'] = FALSE;
					$this->image_lib->initialize($config);
					$this->image_lib->watermark();
				}
				
				$small_image = '/files/designs/'.$data['raw_name'].'_small'.$data['file_ext'];
				$smallbw_image = '/files/designs/'.$data['raw_name'].'_smallbw'.$data['file_ext'];
				$mid_image = '/files/designs/'.$data['raw_name'].'_mid'.$data['file_ext'];
				$full_image = '/files/designs/'.$data['file_name'];
			}
		}
		
		//Если не существует, оставляем прошлые изображения
		if (!isset($small_image) or !isset($full_image)) {
			$data = $this->designs_mdl->get_edit($id);
			$small_image = $data['small_image'];
			$smallbw_image = $data['smallbw_image'];
			$mid_image = $data['mid_image'];
			$full_image = $data['full_image'];
		}
		/**
		 * ---------------------------------------------------------------
		 *	Загрузка файла
		 * ---------------------------------------------------------------
		 */
		if (isset($_FILES['file']['tmp_name']) and $form_validation) {
			//Если не существует папки у пользователя
			if (!file_exists(''.$_SERVER['DOCUMENT_ROOT'].'/files/download/'.$this->username.'')) {
				mkdir(''.$_SERVER['DOCUMENT_ROOT'].'/files/download/'.$this->username.'', 0777, true);
			}
			
			$config['encrypt_name'] = TRUE;
			$config['upload_path'] = './files/download/'.$this->username.'/';
			$config['allowed_types'] = 'zip|rar';
			$config['max_size'] = '100000';
			
			$this->upload->initialize($config);
			
			if ($this->upload->do_upload("file")) {
				$data_file = $this->upload->data();
				
				$path = './files/download/'.$this->username.'/'.$data_file['file_name'].'';
				
				$dfile = $this->username.'/'.$data_file['file_name'];
			}
		}
		
		//Если не существует, оставляем прошлый файл
		if (!isset($dfile)) {
			$data = $this->designs_mdl->get_edit($id);
			$dfile = $data['dfile'];
		}
		
		//Дальше работаем над остальными полями
		if ($form_validation and empty($data['error'])) {
		
			$data = array(
				'title'=>$this->input->post('title'),'text'=>htmlspecialchars($this->input->post('text')),
				//Описание для SE
				'descr'=>character_limiter(htmlspecialchars($this->input->post('text')), 255),
					'category'=>$this->input->post('category_id'),'price_1'=>$this->input->post('price_1'),
					'price_2'=>$this->input->post('price_2'),'source'=>htmlspecialchars($this->input->post('source')),
					'small_image'=>$small_image,'smallbw_image'=>$smallbw_image,'mid_image'=>$mid_image,
					'full_image'=>$full_image,'dfile'=>$dfile,'status'=>1
			);
			
			$this->designs_mdl->edit('designs', $id, $data);
			/**
			 * ---------------------------------------------------------------
			 *	Дополнительные параметры, отдельная таблица
			 * ---------------------------------------------------------------
			 */
			$data = array(
				'flash'=>$this->input->post('flash'),'stretch'=>$this->input->post('stretch'),
					'columns'=>$this->input->post('columns'),'destination'=>$this->input->post('destination'),
					'quality'=>$this->input->post('quality'),'type'=>$this->input->post('type'),
					'tone'=>$this->input->post('tone'),'bright'=>$this->input->post('bright'),'style'=>$this->input->post('style'),
					'theme'=>$this->input->post('theme'),'adult'=>$this->input->post('adult')
			);
			
			$this->designs_mdl->edit_options($id, $data);
			
			/**
			 * ---------------------------------------------------------------
			 *	Сопутствующии товары, удаляем старые добавляем новые
			 * ---------------------------------------------------------------
			 */
			$this->designs_mdl->delete_design_sub($id);
			
			//Обработка данных
			$a = '';
			
			$sub = $this->input->post('sub');
			
			//Удаляем пробелы в начале и конце
			$sub = trim($sub);
			
			//удаляем все пробелы, для точной проверки уникальности
			while (strpos($sub, ' ') !== false) {
				$sub = str_replace(' ', '', $sub);
			}
			;
			
			//Убираем запятую в конце
			$sub = eregi_replace("\,+$", "", $sub);
			
			//Создаём массив
			$sub = explode(",", $sub);
			
			//только уникальные значения
			$sub = array_unique($sub);
			
			//Вставка данных
			foreach ($sub as $row=>$value) {
				$a[] = "('".$id."', '".trim($value)."')";
			}
			
			$a = implode(", ", $a);
			
			$query = "INSERT INTO ci_associated (design_id, sub) VALUES ".$a;
			
			$query = $this->db->query($query);
			/**
			 * ---------------------------------------------------------------
			 *	Тэги, удаляем старые добавляем новые
			 * ---------------------------------------------------------------
			 */
			$this->designs_mdl->delete_design_tags($id);
			
			$a = '';
			
			$tags = $this->input->post('tags');
			
			//Удаляем пробелы в начале и конце
			$tags = trim($tags);
			
			//все буквенные символы переведены в нижний регистр, для точной проверки уникальности
			$tags = strtolower($tags);
			
			//удаляем все пробелы, для точной проверки уникальности
			while (strpos($tags, ' ') !== false) {
				$tags = str_replace(' ', '', $tags);
			}
			;
			
			//Убираем запятую в конце
			$tags = eregi_replace("\,+$", "", $tags);
			
			//Создаём массив
			$tags = explode(",", $tags);
			
			//Удаляем неуникальные элементы
			$tags = array_unique($tags);
			
			foreach ($tags as $row=>$value) {
				$a[] = "('".$id."', '".trim($value)."')";
			}
			
			$a = implode(", ", $a);
			
			$query = "INSERT INTO ci_tags (design_id, tag) VALUES ".$a;
			
			$query = $this->db->query($query);
			
			redirect('designs/'.$id.'.html');
		}
		
		$data = $this->designs_mdl->get_edit($id);
		
		$data['categories'] = $this->designs_mdl->get_categories();
		
		$data['themes'] = $this->designs_mdl->get_themes();
		
		$data['destinations'] = $this->designs_mdl->get_destinations();
		
		//Также вывести тэги и id сопутствующих товаров
		$data['tags'] = $this->designs_mdl->get_design_tags($id);
		
		$data['sub'] = $this->designs_mdl->get_associated_designs_edit($id);
		
		$this->template->build('designs/edit', $data, $title = 'Редактировать дизайн');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Закрытие дизайна
	 * ---------------------------------------------------------------
	 */

	function close($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		//Если не существует продукта со статусом ожидание
		if (!$this->_check_action($id)) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		//Закрываем проект
		$this->designs_mdl->close($id);
		
		redirect('designs/'.$id.'.html');
	}
	/**
	 * ---------------------------------------------------------------
	 *	Функции, проверки
	 * ---------------------------------------------------------------
	 */

	function _check_banned($user_id) {
		if ($cause = $this->designs_mdl->check_banned($user_id)) {
			return $cause;
		}
		
		return FALSE;
	}

	function _tags_check($tags) {
		//Удаляем пробелы в начале и конце
		$tags = trim($tags);
		
		//Убираем запятую в конце
		$tags = eregi_replace("\,+$", "", $tags);
		
		//Создаём массив
		$tags = explode(",", $tags);
		
		if (count($tags) < 1) {
			$this->form_validation->set_message('_tags_check', 'Должно быть не менее одного тега');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	//Проверка, действия над продуктом - удаление, редактирование, закрытие, добавление доп изображений

	function _check_design($id) {
		//Если существует продукт со статусом ожидание, возвращаем истину
		if ($this->designs_mdl->check($id, 1)) {
			return TRUE;
		}
		return FALSE;
	}
	
	//Проверка, действия над продуктом - удаление, редактирование, закрытие, добавление доп изображений

	function _check_action($id) {
		//Если существует продукт со статусом ожидание и принадлежит пользователю, возвращаем истину
		if ($this->designs_mdl->check($id, 1, $this->user_id)) {
			return TRUE;
		}
		return FALSE;
	}

	function _category_check($category) {
		if ($this->designs_mdl->category_check($category)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	МОДЕРАТОР
	 * ---------------------------------------------------------------
	 */
	 
	 /**
	 * ---------------------------------------------------------------
	 *	ЗАБАНИТЬ
	 * ---------------------------------------------------------------
	 */

	function send_ban() {
		//МОДЕРАТОР
		if ($this->team != 2) {
			exit;
		}
		
		$id = $this->input->post('id');
		
		$text = $this->input->post('text');
		
		$data = array(
			'design_id'=>$id,'cause'=>$text
		);
		
		$this->designs_mdl->add('designs_banned', $data);
	}
	
	/**
	 * ---------------------------------------------------------------
	 *	Редактирование комментария
	 * ---------------------------------------------------------------
	 */

	function comments_edit($id) {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$data = $this->designs_mdl->get_comment($id)) {
			show_404('page');
		}
		
		if (!$this->_check_comment($id, $data['user_id'])) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$rules = array(
			array(
				'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
			)
		);
		
		$commentdata = array(
			'text'=>htmlspecialchars($this->input->post('text'))
		);
		
		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run()) {
			$this->designs_mdl->edit_comment($id, $commentdata);
			
			redirect('designs/'.$data['design_id'].'.html');
		}
		
		$this->template->build('designs/comments_edit', $data, $title = 'Редактировать комментарий');
	}

	function comments_del($id = '') {
		if (!$this->errors->access()) {
			return;
		}
		
		if (!$data = $this->designs_mdl->get_comment($id)) {
			show_404('page');
		}
		
		if (!$this->_check_comment($id, $data['user_id'])) {
			show_error('Неверно указан идентификатор действия либо выполнение действия запрещено.');
		}
		
		$this->designs_mdl->del_comment($id);
		
		redirect('designs/'.$data['design_id'].'.html');
	}
	
	//Проверка редактирования модератором, $id - ид блога, $user_id пользователь чей блог

	function _check_comment($id = '', $user_id = '') {
		$userdata = $this->users_mdl->get_user($user_id);
		
		//Если коммент модератора
		if ($userdata['team'] == 2) {
			if (!$this->_check_action_comment($id)) {
				return FALSE;
			}
		}
		//коммент обычного пользователя (может редактировать модератор)
		else {
		
			//ЕСЛИ НЕ МОДЕРАТОР, проверяем
			if ($this->team != 2) {
				if (!$this->_check_action_comment($id)) {
					return FALSE;
				}
			}
			
		}
		
		return TRUE;
	}

	function _check_action_comment($id = '') {
		//Если найдена запись и она принадлежит пользователю
		if ($this->designs_mdl->check_comment($id, $this->user_id)) {
			return TRUE;
		}
		
		return FALSE;
	}
}
