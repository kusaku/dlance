<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_mdl extends Model
{
	//Меняем тарифный план у которых истёк срок на начальный
	function change_tariff()
	{
		$this->db->where('tariff_period <', now());

		$this->db->update('users', array('tariff' => 1));
	}

	//Возвращаем платежи с истёкшим сроком протекции отправителю
	function return_payment()
	{
		$this->db->select('id, user_id, recipient_id, amount');

		$query = $this->db->get_where('payments', array('time <' => now(), 'status' => 1, 'type' => 2));

		if( $query->num_rows() > 0 )
		{
			$result = $query->result_array();

			foreach($result as $row):

				$this->db->update('payments', array('status' => 3), array('id' => $row['id']));

				//Прибавляем баланс обратно отправителю
				$this->balance_mdl->plus($row['user_id'], $row['amount']);

				$this->events->create($row['user_id'], 'Платеж с ID '.$row['id'].' был возвращен отправителю');

				$this->events->create($row['recipient_id'], 'Платеж с ID '.$row['id'].' был возвращен отправителю');

			endforeach;
		}

		return FALSE;
	}
}