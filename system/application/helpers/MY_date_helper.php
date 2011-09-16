<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('date_smart'))
{
	function date_smart($date_input, $datestr = '%d.%m.%Y %G:%i', $time = true)
	{
		if( $date_input == '' )
			$date_input = now();

		$datestr = str_replace('%\\', '', preg_replace("/([a-z]+?){1}/i", "\\\\\\1", $datestr));
		$date_input = date($datestr, $date_input);

		$monthes = array(
		'', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
		'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
		);
		$date = strtotime($date_input);

		//Время
		if($time) $time = ' в G:i';
		else $time = '';

		//Сегодня, вчера, завтра
		if(date('Y') == date('Y',$date))
		{
			if(date('z') == date('z', $date))
			{
				$result_date = date('Сегодня'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)+1,date('Y',$date)))) 
			{
				$result_date = date('Вчера'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)-1,date('Y',$date)))) 
			{
				$result_date = date('Завтра'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)+2,date('Y',$date)))) {
				$result_date = date('2 дня назад'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)+3,date('Y',$date)))) {
				$result_date = date('3 дня назад'.$time, $date);
			}

			if(isset($result_date)) return $result_date;
		}

		//Месяца
		$month = $monthes[date('n',$date)];

		//Года
		if(date('Y') != date('Y', $date)) $year = 'Y г.';
		else $year = '';

		$result_date = date('j '.$month.' '.$year.$time, $date);
		return $result_date;
	}


	function date_await($date_input)//Сколько времени до событиая
	{
		$days = floor(($date_input - time())/86400);

		$fmod_days = fmod($date_input - time(), 86400);//Узнаём остаток, после деления узнавания дня


		$hours = floor(($fmod_days)/3600);

		$fmod_days = fmod($fmod_days, 3600);//Узнаём остаток, после деления узнавания дня


		$mins = floor(($fmod_days)/60);

		$fmod_mins = fmod($fmod_days, 60);//Узнаём остаток, после деления узнавания дня

		$result_date = '';

		if( $days )
		{
			$result_date = $days.' дней';
		}

		if( $hours )
		{
			$result_date .= ' '.$hours.' час';
		}

		if( $mins )
		{
			$result_date .= ' '.$mins.' минут';
		}

		return  $result_date;
	}

	function date_age($day, $month, $year)//Возраст 
	{
		$result_date = date('Y') - $year;

		if( $month > date('m') || $month == date('m') && $day > date('d') ) $result_date = date('Y') - $year -1;

		return  $result_date;
	}
}