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
		'', 'ÿíâàğÿ', 'ôåâğàëÿ', 'ìàğòà', 'àïğåëÿ', 'ìàÿ', 'èşíÿ',
		'èşëÿ', 'àâãóñòà', 'ñåíòÿáğÿ', 'îêòÿáğÿ', 'íîÿáğÿ', 'äåêàáğÿ'
		);
		$date = strtotime($date_input);

		//Âğåìÿ
		if($time) $time = ' â G:i';
		else $time = '';

		//Ñåãîäíÿ, â÷åğà, çàâòğà
		if(date('Y') == date('Y',$date))
		{
			if(date('z') == date('z', $date))
			{
				$result_date = date('Ñåãîäíÿ'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)+1,date('Y',$date)))) 
			{
				$result_date = date('Â÷åğà'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)-1,date('Y',$date)))) 
			{
				$result_date = date('Çàâòğà'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)+2,date('Y',$date)))) {
				$result_date = date('2 äíÿ íàçàä'.$time, $date);
			} 
			elseif(date('z') == date('z',mktime(0,0,0,date('n',$date),date('j',$date)+3,date('Y',$date)))) {
				$result_date = date('3 äíÿ íàçàä'.$time, $date);
			}

			if(isset($result_date)) return $result_date;
		}

		//Ìåñÿöà
		$month = $monthes[date('n',$date)];

		//Ãîäà
		if(date('Y') != date('Y', $date)) $year = 'Y ã.';
		else $year = '';

		$result_date = date('j '.$month.' '.$year.$time, $date);
		return $result_date;
	}


	function date_await($date_input)//Ñêîëüêî âğåìåíè äî ñîáûòèàÿ
	{
		$days = floor(($date_input - time())/86400);

		$fmod_days = fmod($date_input - time(), 86400);//Óçíà¸ì îñòàòîê, ïîñëå äåëåíèÿ óçíàâàíèÿ äíÿ


		$hours = floor(($fmod_days)/3600);

		$fmod_days = fmod($fmod_days, 3600);//Óçíà¸ì îñòàòîê, ïîñëå äåëåíèÿ óçíàâàíèÿ äíÿ


		$mins = floor(($fmod_days)/60);

		$fmod_mins = fmod($fmod_days, 60);//Óçíà¸ì îñòàòîê, ïîñëå äåëåíèÿ óçíàâàíèÿ äíÿ

		$result_date = '';

		if( $days )
		{
			$result_date = $days.' äíåé';
		}

		if( $hours )
		{
			$result_date .= ' '.$hours.' ÷àñ';
		}

		if( $mins )
		{
			$result_date .= ' '.$mins.' ìèíóò';
		}

		return  $result_date;
	}

	function date_age($day, $month, $year)//Âîçğàñò 
	{
		$result_date = date('Y') - $year;

		if( $month > date('m') || $month == date('m') && $day > date('d') ) $result_date = date('Y') - $year -1;

		return  $result_date;
	}
}