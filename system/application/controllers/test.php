<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Test extends Controller
{

function dob()
{
	$input['dob_day'] = 22;
		$input['dob_month'] = 12;
			$input['dob_year'] = 1991;
			if(isset($input['dob_day'])){
			$set['dob'] = mktime(0, 0, 0, $input['dob_month'], $input['dob_day'], $input['dob_year']);
		}
		date_age($input['dob_day'], $input['dob_month'], $input['dob_year']);

		$datestring = "Год: %Y Месяц: %m День: %d - %h:%i %a";
		
		$data = time() - $set['dob'];


echo date_age($data);

}
function add()
{
		$rules = array 
		(
			array (
				'field' => 'tariff', 
				'label' => 'ID тарифа',
				'rules' => 'required|callback__check_tarrif'
			),
			array (
				'field' => 'tariff', 
				'label' => 'ID тарифа',
				'rules' => 'required|callback__check_tarrif'
			)
		);
		

		
		
		$rules[] = 	
		
			array (
				'field' => 'tariff', 
				'label' => 'ID тарифа',
				'rules' => 'required|callback__check_tarrif'
			);		

		print_r($rules);
}

function my_convert_encoding($string,$to,$from)
{
        // Convert string to ISO_8859-1
        if ($from == "UTF-8")
                $iso_string = utf8_decode($string);
        else
                if ($from == "UTF7-IMAP")
                        $iso_string = imap_utf7_decode($string);
                else
                        $iso_string = $string;

        // Convert ISO_8859-1 string to result coding
        if ($to == "UTF-8")
                return(utf8_encode($iso_string));
        else
                if ($to == "UTF7-IMAP")
                        return(imap_utf7_encode($iso_string));
                else
                        return($iso_string);
} 

function tes()
{
	echo date('d');

}


}