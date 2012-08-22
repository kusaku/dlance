<?php 
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
  
class Administrator extends Controller {

  function __construct() {
    parent::Controller();
    $this->load->library('pagination');
    $this->load->model('categories/categories_mdl');
    $this->load->model('tariff/tariff_mdl');
    $this->load->model('help/help_mdl');
    $this->load->model('news/news_mdl');
    $this->load->model('blogs/blogs_mdl');
    $this->load->model('admin/admin_mdl');
    $this->load->helper('tinymce');
  }
  /**
   * ---------------------------------------------------------------
   *  Авторизация
   * ---------------------------------------------------------------
   */

  function auth_check() {
    $rules = array(
      array(
        'field'=>'login','label'=>'Логин','rules'=>'required|trim|callback__login_check'
      ),array(
        'field'=>'pass','label'=>'Пароль','rules'=>'required|trim'
      )
    );
    
    $data = array(
      'username'=>$this->input->post('login'),'password'=>$this->input->post('pass')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run() or $this->admin_mdl->logged_in()) {
      $res['status'] = "OK";
    } else {
      $res['auth_err'] = validation_errors();
    }
    
    echo json_encode($res);
  }

  function login() {
    if ($this->admin_mdl->logged_in()) {
      redirect('administrator/');
    } else {
      $this->load->view('admin/login', $data = '', $title = 'Авторизация пользователя');
    }
    
  }

  function _login_check($username) {
    if ($this->admin_mdl->login($username, $this->input->post('pass'))) {
      return TRUE;
    }
    
    $this->form_validation->set_message('_login_check', 'Неверно введён логин или пароль');
    return FALSE;
  }

  function logout() {
    $this->admin_mdl->logout();
    
    redirect('administrator/login');
  }
  /**
   * ---------------------------------------------------------------
   *  Категории
   * ---------------------------------------------------------------
   */

  function designs_categories() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'descr','label'=>'Описание','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'keywords','label'=>'Ключевые слова','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'projects_descr','label'=>'Описание для проектов','rules'=>'required|max_length[10000]'
      ),array(
        'field'=>'users_descr','label'=>'Описание для каталога пользователей','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'descr'=>$this->input->post('descr'),
        'keywords'=>$this->input->post('keywords'),'parent_id'=>$this->input->post('category'),
        'projects_descr'=>$this->input->post('projects_descr'),'users_descr'=>$this->input->post('users_descr')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('categories', $data);
      
    }
    
    $data['categories'] = $this->admin_mdl->get_designs_categories();
    
    $this->template->build_admin('designs_categories', $data, $title = 'Категории');
  }

  function designs_categories_add() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[255]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'parent_id'=>$this->input->post('category'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('designs_categories', $data);
      
      redirect('administrator/designs_categories');
      ;
    }
    
    $data['categories'] = $this->admin_mdl->get_designs_categories();
    
    $this->template->build_admin('designs_categories_add', $data, $title = 'Добавить категорию');
  }

  function designs_categories_edit($id = '') {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[255]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'parent_id'=>$this->input->post('category'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('designs_categories', $id, $data);
    }
    
    if (!$data = $this->admin_mdl->get_designs_category($id)) {
      redirect('administrator/designs_categories');
    }
    
    $data['categories'] = $this->admin_mdl->get_designs_categories();
    
    $this->template->build_admin('designs_categories_edit', $data, $title = 'Редактировать категорию');
  }

  function designs_categories_action() {
    $categories = $this->input->post('categories');
    
    $action = $this->input->post('action');
    
    if ($action == 'delete') {
      //Удаляем
      $this->admin_mdl->del('designs_categories', $categories);
    }
    
    redirect('administrator/designs_categories');
  }
  /**
   * ---------------------------------------------------------------
   *  Просмотр рассылки
   * ---------------------------------------------------------------
   */

  function categories_followers($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $url = '';
    
    $input = array(
    );
    
    //Результатов на страницу
    if (! empty($_GET['result']) and is_numeric($_GET['result'])) {
      $input['per_page'] = $_GET['result'];
      $url['result'] = 'result='.$_GET['result'];
      
      $per_page = $input['per_page'];
    }
    
    //Ключевые слова
    if (! empty($_GET['keywords'])) {
      $input['keywords'] = $_GET['keywords'];
      $url['keywords'] = 'keywords='.$_GET['keywords'];
    }
    
    //Для прикрепдения к ссылке сортировки
    $data['url'] = $url;
    
    //Сортировка
    if (! empty($_GET['order_field'])) {
      $input['order_field'] = $_GET['order_field'];
      $url['order_field'] = 'order_field='.$_GET['order_field'];
    }
    
    //Тип сортировки
    if (! empty($_GET['order_type'])) {
      $input['order_type'] = $_GET['order_type'];
      $url['order_type'] = 'order_type='.$_GET['order_type'];
    } else {
      $input['order_type'] = 'desc';
    }
    
    $config['base_url'] = base_url().'/administrator/categories_followers/';
    $config['total_rows'] = $this->admin_mdl->count_users($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    //Вывод
    $data['data'] = $this->admin_mdl->get_users($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      
      //Присоединяем к ссылкам на страницы, поисковые GET параметры
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    if (! empty($data['url'])) {
      $data['url'] = implode("&", $data['url']);
    }
    
    $data['input'] = array(
      'keywords'=>(isset($input['keywords'])) ? $input['keywords'] : '',
      'order_field'=>(isset($input['order_field'])) ? $input['order_field'] : '',
      //Если не задан ордер тип, ставим desc
      'order_type'=>(isset($input['order_type'])) ? $input['order_type'] : 'desc',
      'result'=>$per_page,
    );
    
    $this->template->build_admin('categories_followers', $data, $title = 'Пользователи');
  }
  /**
   * ---------------------------------------------------------------
   *  Главная/Статистика
   * ---------------------------------------------------------------
   */

  function events($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    //Текущий год
    $year = date('Y');
    
    //Текущий год для создания массива
    $cur_year = $year;
    
    //Текущий месяц
    $month = date('m');
    
    //Текущий месяц для создания массива
    $cur_month = $month;
    
    //Массив с годами, для поля селект
    $array = array(
    );
    
    for ($y = 2010; $y < $cur_year + 1; $y++) {
      $array[] = $y;
    }
    
    if (! empty($_GET['year'])) {
      $year = $_GET['year'];
      
      //Если года в get запросе нету, оставляем текущий год
      if (!in_array($year, $array)) {
        $year = $cur_year;
      }
    }
    
    //Массив со статистикой, для графика
    $data = $this->_statistic($year);
    
    //Массив с годами, для поля селект
    $data['years'] = $array;
    
    $data['input'] = array(
      'year'=>$year,
    );
    
    //Получаем сколько всего дней в текущем месяце заданного года
    $total_days = days_in_month($cur_month, $cur_year);
    
    $days = array(
    );
    
    $events = array(
    );
    
    for ($d = 1; $d < $total_days + 1; $d++) {
      $days[] = $d;
      
      //Начальная дата
      $input['date_start'] = mktime(0, 0, 0, $cur_month, $d, $cur_year);
      
      //Конечная дата
      $input['date_end'] = mktime(23, 59, 59, $cur_month, $d, $cur_year);
      
      $events[$d] = $this->admin_mdl->get_events($input);
      
    }
    
    //Массив с месяцами, для поля селект
    $data['days'] = $days;
    
    //Массив с месяцами, для поля селект
    $data['events'] = $events;
    
    $this->template->build_admin('events', $data, $title = 'События');
  }

  function _events($year = '') {
    for ($m = 0; $m < 13; $m++) {
      //Начальная дата
      $input['date_start'] = mktime(0, 0, 0, $m, 1, $year);
      
      //Получаем сколько всего дней в текущем месяце заданного года
      $day = days_in_month($m, $year);
      
      //Конечная дата
      $input['date_end'] = mktime(23, 59, 59, $m, $day, $year);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $products[$m] = $this->admin_mdl->info_count_designs($input);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $purchased[$m] = $this->admin_mdl->info_count_purchased($input);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $purchased_2[$m] = $this->admin_mdl->info_count_purchased($input, 2);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $users[$m] = $this->admin_mdl->info_count_users($input);
    }
    
    $data['products'] = $products;
    
    $data['purchased'] = $purchased;
    
    $data['purchased_2'] = $purchased_2;
    
    $data['users'] = $users;
    
    return $data;
  }
  /**
   * ---------------------------------------------------------------
   *  Главная/Статистика
   * ---------------------------------------------------------------
   */

  function index($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    //Текущий год
    $year = date('Y');
    
    //Текущий год для создания массива
    $cur_year = $year;
    
    //Массив с годами, для поля селект
    $array = array(
    );
    
    for ($y = 2010; $y < $cur_year + 1; $y++) {
      $array[] = $y;
    }
    
    if (! empty($_GET['year'])) {
      $year = $_GET['year'];
      
      //Если года в get запросе нету, оставляем текущий год
      if (!in_array($year, $array)) {
        $year = $cur_year;
      }
    }
    
    //Массив со статистикой, для графика
    $data = $this->_statistic($year);
    
    //Массив с годами, для поля селект
    $data['years'] = $array;
    
    $data['input'] = array(
      'year'=>$year,
    );
    
    //Сейчас
    $today = now();
    //Прошлый день
    $day = now() - 86400;
    //Прошлая неделя
    $week = now() - 604800;
    //Прошлый месяц
    $month = now() - 2629743;
    //Прошлый год
    $year = now() - 31556926;
    
    //Конечная дата
    $input['date_end'] = $today;
    
    //Начальная дата
    $input['date_start'] = $day;
    //Прошлый день
    $data['users_day'] = $this->admin_mdl->info_count_users($input);
    //Прошлый день
    $data['designs_day'] = $this->admin_mdl->info_count_designs($input);
    
    //Начальная дата
    $input['date_start'] = $week;
    //Прошлая неделя
    $data['users_week'] = $this->admin_mdl->info_count_users($input);
    //Прошлая неделя
    $data['designs_week'] = $this->admin_mdl->info_count_designs($input);
    
    //Начальная дата
    $input['date_start'] = $month;
    //Прошлый месяц
    $data['users_month'] = $this->admin_mdl->info_count_users($input);
    //Прошлый месяц
    $data['designs_month'] = $this->admin_mdl->info_count_designs($input);
    
    //Начальная дата
    $input['date_start'] = $year;
    //Прошлый год
    $data['users_year'] = $this->admin_mdl->info_count_users($input);
    //Прошлый год
    $data['designs_year'] = $this->admin_mdl->info_count_designs($input);
    
    $this->template->build_admin('index', $data, $title = 'Статистика');
  }

  function _statistic($year = '') {
    //Выводим статистику за каждый месяц
    for ($m = 0; $m < 13; $m++) {
      //Начальная дата
      $input['date_start'] = mktime(0, 0, 0, $m, 1, $year);
      
      //Получаем сколько всего дней в текущем месяце заданного года
      $day = days_in_month($m, $year);
      
      //Конечная дата
      $input['date_end'] = mktime(23, 59, 59, $m, $day, $year);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $products[$m] = $this->admin_mdl->info_count_designs($input);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $purchased[$m] = $this->admin_mdl->info_count_purchased($input);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $purchased_2[$m] = $this->admin_mdl->info_count_purchased($input, 2);
      
      //Получаем колличество продуктов за заданный промежуток времени
      $users[$m] = $this->admin_mdl->info_count_users($input);
    }
    
    $data['products'] = $products;
    
    $data['purchased'] = $purchased;
    
    $data['purchased_2'] = $purchased_2;
    
    $data['users'] = $users;
    
    return $data;
  }
  /**
   * ---------------------------------------------------------------
   *  История операций
   * ---------------------------------------------------------------
   */

  function transaction($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $url = '';
    
    $input = array(
    );
    
    //Результатов на страницу
    if (! empty($_GET['result']) and is_numeric($_GET['result'])) {
      $input['per_page'] = $_GET['result'];
      $url['result'] = 'result='.$_GET['result'];
      
      $per_page = $input['per_page'];
    }
    
    //Результатов на страницу
    if (! empty($_GET['sort'])) {
      $input['sort'] = $_GET['sort'];
      
      $url['sort'] = 'sort='.$_GET['sort'];
    }
    
    if (! empty($_GET['range'])) {
      $input['range'] = $_GET['range'];
      
      $range = explode("-", $input['range']);
      
      $date_start = $range[0];
      $date_end = $range[1];
      
      $date_start = explode(".", $date_start);
      
      //Преобразование в числовой тип
      $day = $date_start[0] + 0;
      $month = $date_start[1] + 0;
      $year = $date_start[2] + 0;
      
      $input['date_start'] = mktime(0, 0, 0, $month, $day, $year);
      
      $date_end = explode(".", $date_end);
      
      $day = $date_end[0] + 0;
      $month = $date_end[1] + 0;
      $year = $date_end[2] + 0;
      
      $input['date_end'] = mktime(23, 59, 59, $month, $day, $year);
      
      $url['range'] = 'range='.$_GET['range'];
    }
    
    //Для прикрепдения к ссылке сортировки
    $data['url'] = $url;
    
    //Сортировка
    if (! empty($_GET['order_field'])) {
      $input['order_field'] = $_GET['order_field'];
      $url['order_field'] = 'order_field='.$_GET['order_field'];
    }
    
    //Тип сортировки
    if (! empty($_GET['order_type'])) {
      $input['order_type'] = $_GET['order_type'];
      $url['order_type'] = 'order_type='.$_GET['order_type'];
    } else {
      $input['order_type'] = 'desc';
    }
    
    $config['base_url'] = base_url().'administrator/transaction/';
    $config['total_rows'] = $this->admin_mdl->count_transaction($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['data'] = $this->admin_mdl->get_transaction($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['total_sum'] = $this->admin_mdl->total_sum_transaction($input);
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    /**
     * Блок
     */
    $data['input'] = array(
      'range'=>(isset($input['range'])) ? $input['range'] : '','sort'=>(isset($input['sort'])) ? $input['sort'] : '',
      'order_field'=>(isset($input['order_field'])) ? $input['order_field'] : '',
      //Если не задан ордер тип, ставим desc
      'order_type'=>(isset($input['order_type'])) ? $input['order_type'] : 'desc',
      'result'=>$per_page,
    );
    
    //Сейчас
    $data['today'] = date("d.m.Y", time());
    //Прошлый день
    $data['day'] = date("d.m.Y", time() - 86400);
    //Прошлая неделя
    $data['week'] = date("d.m.Y", time() - 604800);
    //Прошлый месяц
    $data['month'] = date("d.m.Y", time() - 2629743);
    //Прошлый год
    $data['year'] = date("d.m.Y", time() - 31556926);
    
    $this->template->build_admin('transaction', $data, $title = 'История операций');
  }
  /**
   * ---------------------------------------------------------------
   *  История операций
   * ---------------------------------------------------------------
   */

  function purchased($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $url = '';
    
    $input = array(
    );
    
    //Результатов на страницу
    if (! empty($_GET['result']) and is_numeric($_GET['result'])) {
      $input['per_page'] = $_GET['result'];
      $url['result'] = 'result='.$_GET['result'];
      
      $per_page = $input['per_page'];
    }
    
    if (! empty($_GET['range'])) {
      $input['range'] = $_GET['range'];
      
      $range = explode("-", $input['range']);
      
      $date_start = $range[0];
      $date_end = $range[1];
      
      $date_start = explode(".", $date_start);
      
      //Преобразование в числовой тип
      $day = $date_start[0] + 0;
      $month = $date_start[1] + 0;
      $year = $date_start[2] + 0;
      
      $input['date_start'] = mktime(0, 0, 0, $month, $day, $year);
      
      $date_end = explode(".", $date_end);
      
      $day = $date_end[0] + 0;
      $month = $date_end[1] + 0;
      $year = $date_end[2] + 0;
      
      $input['date_end'] = mktime(23, 59, 59, $month, $day, $year);
      
      $url['range'] = 'range='.$_GET['range'];
    }
    
    //Для прикрепдения к ссылке сортировки
    $data['url'] = $url;
    
    //Сортировка
    if (! empty($_GET['order_field'])) {
      $order_field = $_GET['order_field'];
      
      if ($order_field == 'kind' or $order_field == 'buyer' or $order_field == 'seller') {
      
        switch ($order_field) {
          case 'buyer':
            $order_field = 'user_id';
            break;
          case 'seller':
            $order_field = 'seller_id';
            break;
        }
        
        $input['order_field'] = $order_field;
        $url['order_field'] = 'order_field='.$order_field;
      }
    }
    
    //Тип сортировки
    if (! empty($_GET['order_type'])) {
      $input['order_type'] = $_GET['order_type'];
      $url['order_type'] = 'order_type='.$_GET['order_type'];
    } else {
      $input['order_type'] = 'desc';
    }
    
    $config['base_url'] = base_url().'administrator/purchasing/';
    $config['total_rows'] = $this->admin_mdl->count_purchased($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['data'] = $this->admin_mdl->get_purchased($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    /**
     * Блок
     */
    $data['input'] = array(
      'range'=>(isset($input['range'])) ? $input['range'] : '',
      'order_field'=>(isset($input['order_field'])) ? $input['order_field'] : '',
      //Если не задан ордер тип, ставим desc
      'order_type'=>(isset($input['order_type'])) ? $input['order_type'] : 'desc',
      'result'=>$per_page,
    );
    
    //Сейчас
    $data['today'] = date("d.m.Y", time());
    //Прошлый день
    $data['day'] = date("d.m.Y", time() - 86400);
    //Прошлая неделя
    $data['week'] = date("d.m.Y", time() - 604800);
    //Прошлый месяц
    $data['month'] = date("d.m.Y", time() - 2629743);
    //Прошлый год
    $data['year'] = date("d.m.Y", time() - 31556926);
    
    $this->template->build_admin('purchased', $data, $title = 'Покупки дизайнов');
  }
  /**
   * ---------------------------------------------------------------
   *  Статистика сервиса
   * ---------------------------------------------------------------
   */

  function statistic($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $url = '';
    
    $input = array(
    );
    
    //Результатов на страницу
    if (! empty($_GET['result']) and is_numeric($_GET['result'])) {
      $input['per_page'] = $_GET['result'];
      $url['result'] = 'result='.$_GET['result'];
      
      $per_page = $input['per_page'];
    }
    
    if (! empty($_GET['range'])) {
      $input['range'] = $_GET['range'];
      
      $range = explode("-", $input['range']);
      
      $date_start = $range[0];
      $date_end = $range[1];
      
      $date_start = explode(".", $date_start);
      
      //Преобразование в числовой тип
      $day = $date_start[0] + 0;
      $month = $date_start[1] + 0;
      $year = $date_start[2] + 0;
      
      $input['date_start'] = mktime(0, 0, 0, $month, $day, $year);
      
      $date_end = explode(".", $date_end);
      
      $day = $date_end[0] + 0;
      $month = $date_end[1] + 0;
      $year = $date_end[2] + 0;
      
      $input['date_end'] = mktime(23, 59, 59, $month, $day, $year);
      
      $url['range'] = 'range='.$_GET['range'];
    }
    
    $config['base_url'] = base_url().'administrator/transaction/';
    $config['total_rows'] = $this->admin_mdl->count_transaction($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['data'] = $this->admin_mdl->get_transaction($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    /**
     * Блок
     */
    $data['input'] = array(
      'range'=>(isset($input['range'])) ? $input['range'] : '',
      'result'=>$per_page,
    );
    
    //Сейчас
    $data['today'] = date("d.m.Y", time());
    //Прошлый день
    $data['day'] = date("d.m.Y", time() - 86400);
    //Прошлая неделя
    $data['week'] = date("d.m.Y", time() - 604800);
    //Прошлый месяц
    $data['month'] = date("d.m.Y", time() - 2629743);
    //Прошлый год
    $data['year'] = date("d.m.Y", time() - 31556926);
    
    $this->template->build_admin('statistic', $data, $title = 'Статистика сервиса');
  }
  /**
   * ---------------------------------------------------------------
   *  Жалобы
   * ---------------------------------------------------------------
   */

  function reports($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $input = '';
    
    //Статус
    if (! empty($_GET['status'])) {
      $input['status'] = $_GET['status'];
      $url['status'] = 'status='.$_GET['status'];
    }
    
    $config['base_url'] = base_url().'administrator/reports/';
    $config['total_rows'] = $this->admin_mdl->count_reports($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['data'] = $this->admin_mdl->get_reports($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    $this->template->build_admin('reports', $data, $title = 'Жалобы');
  }

  function reports_action() {
    $reports = $this->input->post('reports');
    
    $action = $this->input->post('action');
    
    if ($action == 'close') {
      $this->admin_mdl->close_reports($reports);
    }
    
    if ($action == 'delete') {
      $this->admin_mdl->del('reports', $reports);
    }
    
    redirect('administrator/reports');
  }

  function reports_close() {
    $id = $this->input->post('id');
    
    $this->admin_mdl->close_reports($id);
  }

  function reports_view() {
    $id = $this->input->post('id');
    
    $report = $this->admin_mdl->get_report($id);
    
    echo $report['text'];
  }
  
  /**
   * ---------------------------------------------------------------
   *  Заявки на вывод
   * ---------------------------------------------------------------
   */

  function applications($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $input = '';
    
    //Статус
    if (! empty($_GET['status'])) {
      $input['status'] = $_GET['status'];
      $url['status'] = 'status='.$_GET['status'];
    }
    
    $config['base_url'] = base_url().'administrator/applications/';
    $config['total_rows'] = $this->admin_mdl->count_applications($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['data'] = $this->admin_mdl->get_applications($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    $this->template->build_admin('applications', $data, $title = 'Заявки на вывод');
  }

  function applications_done($id) {
    $data = array(
      'status'=>2
    );
    
    $this->admin_mdl->edit('balance_applications', $id, $data);
    
    $application = $this->admin_mdl->get_application($id);
    
    /**
     * ---------------------------------------------------------------
     *  Записываем историю
     * ---------------------------------------------------------------
     */
    $data = array(
      'user_id'=>$application['user_id'],'date'=>now(),'amount'=>$application['amount'],
        'descr'=>'Вывод средств'
    );
    
    $this->admin_mdl->add('transaction', $data);
    
    redirect('administrator/applications');
  }
  /**
   * ---------------------------------------------------------------
   *  Профиль администратора
   * ---------------------------------------------------------------
   */

  function profile() {
    $rules = array(
      array(
        'field'=>'username','label'=>'Логин','rules'=>'required|min_length[3]|max_length[50]'
      ),array(
        'field'=>'password','label'=>'Пароль','rules'=>'required|min_length[3]|max_length[50]'
      ),array(
        'field'=>'current_password','label'=>'Текущий пароль','rules'=>'required|min_length[3]|max_length[50]|callback__current_password_check'
      )
    );
    
    $password = $this->input->post('password');
    
    $password = $this->admin_mdl->hash_password_db($password);
    
    $data = array(
      'username'=>$this->input->post('username'),'password'=>$password
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('administrator', 1, $data);
    }
    
    $this->template->build_admin('profile', $data, $title = 'Профиль администратора');
  }

  function _current_password_check($password) {
    if ($this->admin_mdl->check_current_password($password)) {
      return TRUE;
    }
    
    $this->form_validation->set_message('_current_password_check', 'Неверно введён текущий пароль');
    return FALSE;
  }
  /**
   * ---------------------------------------------------------------
   *  Рейтинг
   * ---------------------------------------------------------------
   */

  function rating() {
    $rules = array(
      array(
        'field'=>'auth','label'=>'Авторизация','rules'=>'numeric'
      ),array(
        'field'=>'send_message','label'=>'Отправление сообщения','rules'=>'numeric'
      ),array(
        'field'=>'receipt_message','label'=>'Получение сообщения','rules'=>'numeric'
      ),array(
        'field'=>'plus_balance','label'=>'Увеличение баланса','rules'=>'numeric'
      ),array(
        'field'=>'minus_balance','label'=>'Уменьшение баланса','rules'=>'numeric'
      ),array(
        'field'=>'sell_design','label'=>'Продажа дизайна','rules'=>'numeric'
      ),array(
        'field'=>'buy_design','label'=>'Покупка дизайна','rules'=>'numeric'
      ),array(
        'field'=>'add_positive_review','label'=>'Отправка отзыва(+)','rules'=>'numeric'
      ),array(
        'field'=>'add_negative_review','label'=>'Отправка отзыва(-)','rules'=>'numeric'
      ),
      array(
        'field'=>'receipt_positive_review','label'=>'Получение отзыва(+)','rules'=>'numeric'
      ),array(
        'field'=>'receipt_negative_review','label'=>'Получение отзыва(-)','rules'=>'numeric'
      ),array(
        'field'=>'add_design','label'=>'Добавление дизайна','rules'=>'numeric'
      )
    );
    
    $data = array(
      'auth'=>$this->input->post('auth'),'send_message'=>$this->input->post('send_message'),
        'receipt_message'=>$this->input->post('receipt_message'),'plus_balance'=>$this->input->post('plus_balance'),
        'minus_balance'=>$this->input->post('minus_balance'),'sell_design'=>$this->input->post('sell_design'),
        'buy_design'=>$this->input->post('buy_design'),'add_positive_review'=>$this->input->post('add_positive_review'),
        'add_negative_review'=>$this->input->post('add_negative_review'),'receipt_positive_review'=>$this->input->post('receipt_positive_review'),
        'receipt_negative_review'=>$this->input->post('receipt_negative_review'),
        'add_design'=>$this->input->post('add_design')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit_rating($data);
    }
    
    $data = $this->admin_mdl->get_rating();
    
    $this->template->build_admin('rating', $data, $title = 'Настройка рейтинга');
  }
  /**
   * ---------------------------------------------------------------
   *  Общая статистика сервиса
   * ---------------------------------------------------------------
   */

  function info() {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $input = array(
    );
    
    if (! empty($_GET['range'])) {
      $input['range'] = $_GET['range'];
      
      $range = explode("-", $input['range']);
      
      $date_start = $range[0];
      $date_end = $range[1];
      
      $date_start = explode(".", $date_start);
      
      //Преобразование в числовой тип
      $day = $date_start[0] + 0;
      $month = $date_start[1] + 0;
      $year = $date_start[2] + 0;
      
      $input['date_start'] = mktime(0, 0, 0, $month, $day, $year);
      
      $date_end = explode(".", $date_end);
      
      $day = $date_end[0] + 0;
      $month = $date_end[1] + 0;
      $year = $date_end[2] + 0;
      
      $input['date_end'] = mktime(23, 59, 59, $month, $day, $year);
    }
    
    $data = array(
      //Пользователей
      'users'=>$this->admin_mdl->info_count_users($input),
      
      //Дизайнов
      'designs'=>$this->admin_mdl->info_count_designs($input),
      'designs_purchased'=>$this->admin_mdl->info_count_designs($input),
      
      //Пополнено
      'addition'=>$this->admin_mdl->info_count_addition($input),
      
      //Выведено
      'output'=>$this->admin_mdl->info_count_output($input),
      
      //Всего средств
      'resources'=>$this->admin_mdl->info_count_resources(),
      
      //Всего средств готово к выводу
      'resources_2'=>$this->admin_mdl->info_count_resources($this->config->item('minimum_w_a')),
    );
    
    /**
     * Блок
     */
    $data['input'] = array(
      'range'=>(isset($input['range'])) ? $input['range'] : '',
    );
    
    //Сейчас
    $data['today'] = date("d.m.Y", time());
    //Прошлый день
    $data['day'] = date("d.m.Y", time() - 86400);
    //Прошлая неделя
    $data['week'] = date("d.m.Y", time() - 604800);
    //Прошлый месяц
    $data['month'] = date("d.m.Y", time() - 2629743);
    //Прошлый год
    $data['year'] = date("d.m.Y", time() - 31556926);
    
    $this->template->build_admin('info', $data, $title = 'Развернутая статистика сервиса');
  }

  function settings() {
    $rules = array(
      array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|text|max_length[255]'
      ),array(
        'field'=>'description','label'=>'Краткое описание','rules'=>'required|text|max_length[255]'
      ),array(
        'field'=>'keywords','label'=>'Ключевые слова','rules'=>'required|text|max_length[255]'
      ),array(
        'field'=>'site','label'=>'Краткое название сайта','rules'=>'required|text|max_length[64]'
      )
    );
    
    $data = array(
      'title'=>$this->input->post('title'),'description'=>$this->input->post('description'),
        'keywords'=>$this->input->post('keywords'),'site'=>$this->input->post('site'),
        'reviews_add'=>$this->input->post('reviews_add'),'download_period'=>$this->input->post('download_period'),
        'moder'=>$this->input->post('moder'),'pay_robox_login'=>$this->input->post('pay_robox_login'),
        'pay_robox_pass1'=>$this->input->post('pay_robox_pass1'),'pay_robox_pass2'=>$this->input->post('pay_robox_pass2'),
        'pay_robox_mode'=>$this->input->post('pay_robox_mode'),'pay_qiwi_id'=>$this->input->post('pay_qiwi_id'),
        'pay_qiwi_lt'=>$this->input->post('pay_qiwi_lt'),'pay_qiwi_agt'=>$this->input->post('pay_qiwi_agt'),
        'pay_wm_purse'=>$this->input->post('pay_wm_purse'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $data['reviews_add'] = $data['reviews_add'] * 3600;
      
      $data['download_period'] = $data['download_period'] * 3600;
      
      $this->admin_mdl->edit_settings($data);
    }
    
    $data = $this->admin_mdl->get_settings();
    
    $data['reviews_add'] = $data['reviews_add'] / 3600;
    
    $data['download_period'] = $data['download_period'] / 3600;
    
    $this->template->build_admin('settings', $data, $title = 'Настройки');
  }
  /**
   * ---------------------------------------------------------------
   *  Дизайны
   * ---------------------------------------------------------------
   */

  function designs($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $url = '';
    
    $input = array(
    );
    
    //Статус
    if (! empty($_GET['status'])) {
      $input['status'] = $_GET['status'];
      $url['status'] = 'status='.$_GET['status'];
    }
    
    $config['base_url'] = base_url().'administrator/designs/';
    $config['total_rows'] = $this->admin_mdl->count_designs($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['data'] = $this->admin_mdl->get_designs($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    $this->template->build_admin('designs', $data, $title = 'Дизайны сайтов');
  }

  function designs_action() {
    $designs = $this->input->post('designs');
    
    $action = $this->input->post('action');
    
    if ($action == 'close') {
      $this->admin_mdl->close_designs($designs);
    }
    
    if ($action == 'delete') {
      $this->admin_mdl->del('designs', $designs);
    }
    
    if ($action == 'moder') {
      $this->admin_mdl->moder_designs($designs);
    }
    
    redirect('administrator/designs');
  }
  /**
   * ---------------------------------------------------------------
   *  Тарифы
   * ---------------------------------------------------------------
   */

  function tariffs() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[16]'
      ),array(
        'field'=>'price_of_month','label'=>'Стоимость в месяц','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'price_of_year','label'=>'Стоимость в год','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'commission','label'=>'Комиссия','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'minimum_w_a','label'=>'Минимальная сумма для вывода','rules'=>'required|numeric|max_length[16]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'price_of_month'=>$this->input->post('price_of_month'),
        'price_of_year'=>$this->input->post('price_of_year'),'commission'=>$this->input->post('commission'),
        'minimum_w_a'=>$this->input->post('minimum_w_a')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('tariffs', $data);
      
    }
    
    $data['data'] = $this->tariff_mdl->get_all();
    
    $this->template->build_admin('tariffs', $data, $title = 'Тарифы');
  }

  function tariffs_add() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[16]'
      ),array(
        'field'=>'price_of_month','label'=>'Стоимость в месяц','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'price_of_year','label'=>'Стоимость в год','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'commission','label'=>'Комиссия','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'minimum_w_a','label'=>'Минимальная сумма для вывода','rules'=>'required|numeric|max_length[16]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'price_of_month'=>$this->input->post('price_of_month'),
        'price_of_year'=>$this->input->post('price_of_year'),'commission'=>$this->input->post('commission'),
        'minimum_w_a'=>$this->input->post('minimum_w_a')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('tariffs', $data);
      
    }
    
    $this->template->build_admin('tariffs_add', $data, $title = 'Добавить тариф');
  }

  function tariffs_edit($id) {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[16]'
      ),array(
        'field'=>'price_of_month','label'=>'Стоимость в месяц','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'price_of_year','label'=>'Стоимость в год','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'commission','label'=>'Комиссия','rules'=>'required|numeric|max_length[16]'
      ),array(
        'field'=>'minimum_w_a','label'=>'Минимальная сумма для вывода','rules'=>'required|numeric|max_length[16]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'price_of_month'=>$this->input->post('price_of_month'),
        'price_of_year'=>$this->input->post('price_of_year'),'commission'=>$this->input->post('commission'),
        'minimum_w_a'=>$this->input->post('minimum_w_a')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('tariffs', $id, $data);
      
    }
    
    if (!$data = $this->tariff_mdl->get_tariff($id)) {
      redirect('administrator/tariffs');
    }
    
    $this->template->build_admin('tariffs_edit', $data, $title = 'Редактировать тариф');
  }

  function tariffs_action() {
    $tariffs = $this->input->post('tariffs');
    
    $action = $this->input->post('action');
    
    if ($action = 'delete') {
      //Удаляем
      $this->admin_mdl->del('tariffs', $tariffs);
    }
    
    redirect('administrator/tariffs');
  }
  /**
   * ---------------------------------------------------------------
   *  Категории
   * ---------------------------------------------------------------
   */

  function categories() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'descr','label'=>'Описание','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'keywords','label'=>'Ключевые слова','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'projects_descr','label'=>'Описание для проектов','rules'=>'required|max_length[10000]'
      ),array(
        'field'=>'users_descr','label'=>'Описание для каталога пользователей','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'descr'=>$this->input->post('descr'),
        'keywords'=>$this->input->post('keywords'),'parent_id'=>$this->input->post('category'),
        'projects_descr'=>$this->input->post('projects_descr'),'users_descr'=>$this->input->post('users_descr')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('categories', $data);
      
    }
    
    $data['categories'] = $this->categories_mdl->get_categories();
    
    $this->template->build_admin('categories', $data, $title = 'Категории');
  }

  function categories_add() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'descr','label'=>'Описание','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'keywords','label'=>'Ключевые слова','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'users_descr','label'=>'Описание для каталога пользователей','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'descr'=>$this->input->post('descr'),
        'keywords'=>$this->input->post('keywords'),'parent_id'=>$this->input->post('category'),
        'users_descr'=>$this->input->post('users_descr')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('categories', $data);
      
      redirect('administrator/categories');
    }
    
    $data['categories'] = $this->categories_mdl->get_categories();
    
    $this->template->build_admin('categories_add', $data, $title = 'Добавить категорию');
  }

  function categories_edit($id) {
    $rules = array(
      array(
        'field'=>'name','label'=>'Имя','rules'=>'required|max_length[24]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'descr','label'=>'Описание','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'keywords','label'=>'Ключевые слова','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'users_descr','label'=>'Описание для каталога пользователей','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'descr'=>$this->input->post('descr'),
        'keywords'=>$this->input->post('keywords'),'parent_id'=>$this->input->post('category'),
        'users_descr'=>$this->input->post('users_descr')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('categories', $id, $data);
    }
    
    if (!$data = $this->admin_mdl->get_category($id)) {
      redirect('administrator/categories');
    }
    
    $data['categories'] = $this->categories_mdl->get_categories();
    
    $this->template->build_admin('categories_edit', $data, $title = 'Редактировать категорию');
  }

  function categories_action() {
    $categories = $this->input->post('categories');
    
    $action = $this->input->post('action');
    
    if ($action == 'delete') {
      //Удаляем
      $this->admin_mdl->del('categories', $categories);
    }
    
    redirect('administrator/categories');
  }
  
  /**
   * ---------------------------------------------------------------
   *  Пользователи
   * ---------------------------------------------------------------
   */

  function users($start_page = 0) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
    
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $url = '';
    
    $input = array(
    );
    
    //Результатов на страницу
    if (! empty($_GET['result']) and is_numeric($_GET['result'])) {
      $input['per_page'] = $_GET['result'];
      $url['result'] = 'result='.$_GET['result'];
      
      $per_page = $input['per_page'];
    }
    
    //Ключевые слова
    if (! empty($_GET['keywords'])) {
      $input['keywords'] = $_GET['keywords'];
      $url['keywords'] = 'keywords='.$_GET['keywords'];
    }
    
    //Для прикрепдения к ссылке сортировки
    $data['url'] = $url;
    
    //Сортировка
    if (! empty($_GET['order_field'])) {
      $input['order_field'] = $_GET['order_field'];
      $url['order_field'] = 'order_field='.$_GET['order_field'];
    }
    
    //Тип сортировки
    if (! empty($_GET['order_type'])) {
      $input['order_type'] = $_GET['order_type'];
      $url['order_type'] = 'order_type='.$_GET['order_type'];
    } else {
      $input['order_type'] = 'desc';
    }
    
    $config['base_url'] = base_url().'/administrator/users/';
    $config['total_rows'] = $this->admin_mdl->count_users($input);
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    //Вывод
    $data['data'] = $this->admin_mdl->get_users($start_page, $per_page, $input);
    
    $data['count'] = $config['total_rows'];
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      
      //Присоединяем к ссылкам на страницы, поисковые GET параметры
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    if (! empty($data['url'])) {
      $data['url'] = implode("&", $data['url']);
    }
    
    $data['input'] = array(
      'keywords'=>(isset($input['keywords'])) ? $input['keywords'] : '',
      'order_field'=>(isset($input['order_field'])) ? $input['order_field'] : '',
      //Если не задан ордер тип, ставим desc
      'order_type'=>(isset($input['order_type'])) ? $input['order_type'] : 'desc',
      'result'=>$per_page,
    );
    
    $this->template->build_admin('users', $data, $title = 'Пользователи');
  }

  function users_ban($id) {
    $rules = array(
      array(
        'field'=>'cause','label'=>'Причина','rules'=>'required|max_length[50]'
      )
    );
    
    $data = array(
      'user_id'=>$id,'cause'=>$this->input->post('cause')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('banned', $data);
      
      redirect('administrator/users');
    }
    
    $this->template->build_admin('users_ban', $data, $title = 'Забанить пользователя');
  }

  function users_ban_del($id) {
    if ($id) {
      //Удаляем бан
      $this->admin_mdl->unban($id);
    }
    
    redirect('administrator/users');
  }

  function users_edit($id) {
    $rules = array(
      array(
        'field'=>'surname','label'=>'Фамилия','rules'=>'required|cyrillic|max_length[24]'
      ),array(
        'field'=>'name','label'=>'Имя','rules'=>'required|cyrillic|max_length[24]'
      ),array(
        'field'=>'team','label'=>'Группа','rules'=>'required'
      ),array(
        'field'=>'short_descr','label'=>'Краткое описание','rules'=>'max_length[255]'
      ),array(
        'field'=>'full_descr','label'=>'Резюме','rules'=>'max_length[10000]'
      ),
      array(
        'field'=>'cause','label'=>'Причина бана','rules'=>'max_length[255]'
      )
    );
    
    $data = array(
      'surname'=>$this->input->post('surname'),'name'=>$this->input->post('name'),
        'short_descr'=>$this->input->post('short_descr'),'full_descr'=>$this->input->post('full_descr'),
        'team'=>$this->input->post('team')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('users', $id, $data);
      
      //Если указана причина пользователя
      if ($this->input->post('cause')) {
        $cause = $this->users_mdl->check_banned($id);
        
        $data = array(
          'user_id'=>$id,'cause'=>$this->input->post('cause')
        );
        
        if (!$cause) {
          $this->admin_mdl->add('banned', $data);
        }
        //Редактируем причину, если новая
        elseif ($cause != $this->input->post('cause')) {
          $this->admin_mdl->editban($id, $data);
        }
      } else {
        if ($this->users_mdl->check_banned($id)) {
          $this->admin_mdl->delban($id);
        }
      }
      
    }
    
    //Если пользователь не найден
    if (!$data = $this->admin_mdl->get_user($id)) {
      redirect('administrator/users');
    }
    
    $data['teams'] = $this->admin_mdl->get_list('teams');
    
    //Есть ли бан у пользователя
    $data['cause'] = $this->users_mdl->check_banned($id);
    
    $this->template->build_admin('users_edit', $data, $title = 'Редактировать пользователя');
  }
  /**
   * ---------------------------------------------------------------
   *  Страницы
   * ---------------------------------------------------------------
   */

  function pages($start_page = 0) {
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $config['base_url'] = base_url().'/administrator/pages/';
    $config['total_rows'] = $this->admin_mdl->count_pages();
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['page_links'] = $this->pagination->create_links();
    
    $data['data'] = $this->admin_mdl->get_pages($start_page, $per_page);
    
    $data['count'] = $config['total_rows'];
    
    $this->template->build_admin('pages', $data, $title = 'Страницы');
  }

  function pages_add() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Название','rules'=>'required|alpha_numeric|max_length[24]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'text'=>$this->input->post('text')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('pages', $data);
      
      redirect('administrator/pages');
      
    }
    
    $this->template->build_admin('pages_add', $data, $title = 'Добавить страницу');
  }

  function pages_action() {
    $pages = $this->input->post('pages');
    
    $action = $this->input->post('action');
    
    if ($action = 'delete') {
      //Удаляем
      $this->admin_mdl->del('pages', $pages);
    }
    
    redirect('administrator/pages');
  }

  function pages_edit($id) {
    $rules = array(
      array(
        'field'=>'name','label'=>'Название','rules'=>'required|alpha_numeric|max_length[24]'
      ),array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name'),'title'=>$this->input->post('title'),'text'=>$this->input->post('text')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('pages', $id, $data);
      
      redirect('administrator/pages');
      
    }
    
    if (!$data = $this->admin_mdl->get_page($id)) {
      redirect('administrator/pages');
    }
    
    $this->template->build_admin('pages_edit', $data, $title = 'Редактировать страницу');
  }
  /**
   * ---------------------------------------------------------------
   *  Рассылка
   * ---------------------------------------------------------------
   */

  function mailer() {
    $rules = array(
      array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      )
    );
    
    /**
     * ---------------------------------------------------------------
     *  Прикрепляем файл, если существует
     * ---------------------------------------------------------------
     */
     
    if (isset($_FILES['userfile']['tmp_name'])) {
      $this->load->library('upload');
      
      $config['encrypt_name'] = TRUE;
      $config['upload_path'] = './files/mailer/';
      $config['allowed_types'] = 'zip|rar';
      $config['max_size'] = '2000';
      
      $this->upload->initialize($config);
      
      if ($this->upload->do_upload("userfile")) {
      
        $data_file = $this->upload->data();
        
        $file = 'files/mailer/'.$data_file['file_name'].'';
      } else {
        $data['error'] = $this->upload->display_errors();
      }
    }
    
    $file = (isset($file)) ? $file : '';
    
    $array = array(
      'title'=>$this->input->post('title'),'text'=>$this->input->post('text'),'file'=>$file,
    );
    
    $data['mailer'] = $this->admin_mdl->get_mailer();
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run() and !isset($data['error'])) {
      $data['count'] = $this->admin_mdl->mailer($data['mailer'], $array);
      
      //После отправки, уничтожаем файл
      //Если файл существует
      if (file_exists($file)) {
        unlink($file);
      }
      
    }
    
    $this->template->build_admin('mailer', $data, $title = 'Рассылка');
  }
  
  /**
   * ---------------------------------------------------------------
   *  Блоги
   * ---------------------------------------------------------------
   */

  function blogs($start_page = 0) {
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $config['base_url'] = base_url().'/administrator/blogs/';
    $config['total_rows'] = $this->blogs_mdl->count_all();
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['page_links'] = $this->pagination->create_links();
    
    if (! empty($url)) {
      $url = implode("&", $url);
      $data['page_links'] = str_replace('">', '/?'.$url.'">', $data['page_links']);
    }
    
    $data['data'] = $this->blogs_mdl->get_all($start_page, $per_page);
    
    $data['count'] = $config['total_rows'];
    
    $this->template->build_admin('blogs', $data, $title = 'Записи');
  }

  function blogs_edit($id) {
    $rules = array(
      array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      ),array(
        'field'=>'category','label'=>'Категория','rules'=>'required'
      )
    );
    
    $data = array(
      'title'=>$this->input->post('title'),'text'=>$this->input->post('text'),'category'=>$this->input->post('category'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('blogs', $id, $data);
      
      redirect('administrator/blogs');
      
    }
    
    if (!$data = $this->blogs_mdl->get($id)) {
      redirect('administrator/blogs');
    }
    
    $data['categories'] = $this->blogs_mdl->get_categories();
    
    $this->template->build_admin('blogs_edit', $data, $title = 'Редактировать запись');
  }

  function blogs_action() {
    $blogs = $this->input->post('blogs');
    
    $action = $this->input->post('action');
    
    if ($action = 'action') {
      $this->admin_mdl->del('blogs', $blogs);
    }
    
    redirect('administrator/blogs');
  }
  
  /**
   * ---------------------------------------------------------------
   *  Новости проекта
   * ---------------------------------------------------------------
   */

  function news($start_page = 0) {
    $per_page = 50;
    
    $start_page = intval($start_page);
    if ($start_page < 0) {
      $start_page = 0;
    }
    
    $config['base_url'] = base_url().'/administrator/news/';
    $config['total_rows'] = $this->news_mdl->count_all();
    $config['per_page'] = $per_page;
    
    $this->pagination->initialize($config);
    
    $data['page_links'] = $this->pagination->create_links();
    
    $data['data'] = $this->news_mdl->get_all($start_page, $per_page);
    
    $data['count'] = $config['total_rows'];
    
    $this->template->build_admin('news', $data, $title = 'Новости');
  }

  function news_del() {
    $news = $this->input->post('news');
    
    $action = $this->input->post('action');
    
    if ($action == 'delete') {
      //Удаляем
      $this->admin_mdl->del('news', $news);
    }
    
    redirect('administrator/news');
  }

  function news_add() {
    $rules = array(
      array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[50]'
      ),array(
        'field'=>'descr','label'=>'Краткое описание','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'date'=>now(),'title'=>$this->input->post('title'),'descr'=>$this->input->post('descr'),
        'text'=>$this->input->post('text'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('news', $data);
      
      redirect('administrator/news');
    }
    
    $this->template->build_admin('news_add', $data, $title = 'Добавить новость');
  }

  function news_edit($id) {
    $rules = array(
      array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[50]'
      ),array(
        'field'=>'descr','label'=>'Краткое описание','rules'=>'required|max_length[255]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      )
    );
    
    $data = array(
      'title'=>$this->input->post('title'),'descr'=>$this->input->post('descr'),
        'text'=>$this->input->post('text'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('news', $id, $data);
      
      redirect('administrator/news');
    }
    
    if (!$data = $this->news_mdl->get($id)) {
      show_404('page');
    }
    
    $this->template->build_admin('news_edit', $data, $title = 'Редактировать новость');
  }
  /**
   * ---------------------------------------------------------------
   *  Помощь
   * ---------------------------------------------------------------
   */

  function help_pages_add() {
    $rules = array(
      array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      ),array(
        'field'=>'category','label'=>'Категория','rules'=>'required'
      )
    );
    
    $data = array(
      'title'=>$this->input->post('title'),'text'=>$this->input->post('text'),'category'=>$this->input->post('category'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('help_pages', $data);
      
      redirect('administrator/help_pages');
      
    }
    
    $data['categories'] = $this->help_mdl->get_categories();
    
    $this->template->build_admin('help_pages_add', $data, $title = 'Добавить страницу');
  }

  function help_pages_edit($id) {
    $rules = array(
      array(
        'field'=>'title','label'=>'Заголовок','rules'=>'required|max_length[64]'
      ),array(
        'field'=>'text','label'=>'Текст','rules'=>'required|max_length[10000]'
      ),array(
        'field'=>'category','label'=>'Категория','rules'=>'required'
      )
    );
    
    $data = array(
      'title'=>$this->input->post('title'),'text'=>$this->input->post('text'),'category'=>$this->input->post('category'),
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('help_pages', $id, $data);
      
      redirect('administrator/help_pages_edit');
      
    }
    
    if (!$data = $this->help_mdl->get($id)) {
      show_404('page');
    }
    
    $data['categories'] = $this->help_mdl->get_categories();
    
    $this->template->build_admin('help_pages_edit', $data, $title = 'Редактировать страницу');
  }

  function help_categories() {
    $data['data'] = $this->help_mdl->get_categories();
    
    $this->template->build_admin('help_categories', $data, $title = 'Категории');
  }

  function help_categories_add() {
    $rules = array(
      array(
        'field'=>'name','label'=>'Название','rules'=>'required|text|max_length[24]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->add('help_categories', $data);
      
      redirect('administrator/help_categories');
    }
    
    $this->template->build_admin('help_categories_add', $data, $title = 'Добавить категорию');
  }

  function help_categories_edit($id = '') {
    $rules = array(
      array(
        'field'=>'name','label'=>'Название','rules'=>'required|text|max_length[24]'
      )
    );
    
    $data = array(
      'name'=>$this->input->post('name')
    );
    
    $this->form_validation->set_rules($rules);
    
    if ($this->form_validation->run()) {
      $this->admin_mdl->edit('help_categories', $id, $data);
      
      redirect('administrator/help_categories');
    }
    
    if (!$data = $this->admin_mdl->get_help_category($id)) {
      redirect('administrator/help_categories');
    }
    
    $this->template->build_admin('help_categories_edit', $data, $title = 'Редактировать категорию');
  }

  function help_categories_action() {
    $categories = $this->input->post('categories');
    
    $action = $this->input->post('action');
    
    if ($action = 'delete') {
      //Удаляем
      $this->admin_mdl->del('help_categories', $categories);
    }
    
    redirect('administrator/help_categories');
  }

  function help_pages() {
    $data['data'] = $this->help_mdl->get_pages();
    
    $this->template->build_admin('help_pages', $data, $title = 'Страницы');
  }

  function help_pages_action() {
    $pages = $this->input->post('pages');
    
    $action = $this->input->post('action');
    
    if ($action = 'delete') {
      //Удаляем
      $this->admin_mdl->del('help_pages', $pages);
    }
    
    redirect('administrator/help_pages');
  }
}
