<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_mdl extends Model
{
	function change_tariff()//Меняем тарифный план у которых истёк срок на начальный
	{
		$this->db->where('tariff_period <', now());

		$this->db->update('users', array('tariff' => 1));
	}

	function return_payment()//Возвращаем платежи с истёкшим сроком протекции отправителю
	{
		$this->db->select('id, user_id, recipient_id, amount');

		$query = $this->db->get_where('payments', array('time <' => now(), 'status' => 1, 'type' => 2));

		if( $query->num_rows() > 0 )
		{
			$result = $query->result_array();


			foreach($result as $row):

				$this->db->update('payments', array('status' => 3), array('id' => $row['id']));

				$this->balance_mdl->plus($row['user_id'], $row['amount']);//Прибавляем баланс обратно отправителю

				$this->events->create($row['user_id'], 'Платеж с ID '.$row['id'].' был возвращен отправителю');

				$this->events->create($row['recipient_id'], 'Платеж с ID '.$row['id'].' был возвращен отправителю');

			endforeach;
		}

		return FALSE;
	}
}