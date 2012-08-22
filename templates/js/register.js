function send(){

	fields = {
		'username' : $('#username').val(),
		'email' : $('#email').val()
	}

	$.ajax({
		url: '/users/fast_register_check',
		type: "POST",
		data: fields,
		dataType: "json",
		success: function (json) {

			if (json.status == "OK")
			{
				$('#username_err').html(''); 
				$('#email_err').html('');

				//Показываем кнопку оплатить
				$("#r").css("display", "inline");
				//Скрываем кнопку отправить
				$("#sendbtn").css("display", "none");

				$('#username_err').append(json.username);
				$('#email_err').append(json.email);
				
				$('#register').html('Система успешно завершена, на указанный email был выслан код для активации аккаунта и данные для входа, после оплаты.');

				fields = {
					'cart' : $('#cart').val(),
					'total_amount' : $('#total_amount').val(),
					//Вставляем в поле полученный код
					'code' : json.code
				}

				$.ajax({
					url: "http://dlance.fabricasaitov.ru/account/newa",
					type: "POST",
					data: fields,
					cache: false,
					beforeSend: function() {
						$('#robokassa').html('Обработка запроса...');
					},
					success: function(html){
						$("#robokassa").html(html);
					}
				});

			}
			else
			{
				$('#username_err').html(''); 
				$('#email_err').html('');

				$('#username_err').append(json.username_err);
				$('#email_err').append(json.email_err);
			}

		}

	});

	return false;  
}