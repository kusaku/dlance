$(document).ready(function()
{
	var collection = collection(), usd = 28, uah = 36, eur = 40;

	function collection()
	{
		var massiv = [], data = $('.budget');

		for( var i = 0, size = data.length;i < size; i++ )
		{	
			massiv[i] = $('.budget:eq(' + [i] + ')').html();
			
			data = massiv[i].split(' ');
			
			massiv[i] = data[0];
		}

		return massiv;
	}

	function set(collection)
	{
		data = collection;

		for( var i = 0, size = data.length;i < size; i++ )
		{
			if( $.cookie("value") )
			{
				if( $.cookie("units") == 'Гривен' )
				{
					amount = data[i] * 10;
				}
				else
				{
					amount = data[i];
				}

				sum = amount / $.cookie("value");
				
				sum = sum.toFixed(2);
			}
			else
			{

				sum = data[i];
			}

			sum = sum + ' ' + $.cookie("units");

			$('.budget:eq(' + [i] + ')').html(sum)
		}
	}

	function deleteClass()
	{
		$("#setRur").removeClass("bold");
		$("#setUsd").removeClass("bold");
		$("#setEur").removeClass("bold");
		$("#setUah").removeClass("bold");
	}

	if( $.cookie("value") )
	{
		set(collection);
		
		units = $.cookie("units");

		deleteClass();

		switch (units) {
  			case 'рублей':
				$("#setRur").addClass("bold");
			break
			case 'y.e':
				$("#setUsd").addClass("bold");
			break
			case 'Евро':
				$("#setEur").addClass("bold");
			break
			case 'Гривен':
				$("#setUah").addClass("bold");
			break
		}
	}

	$("#setRur").click(function () {
		$.cookie('value', null, {domain: 'dlance.fabricasaitov.ru', path: '/'});
		$.cookie('units', 'рублей', {domain: 'dlance.fabricasaitov.ru', path: '/'});

		set(collection);
		deleteClass();
		$("#setRur").addClass("bold");
	});
	$("#setUsd").click(function () {
		$.cookie('value', usd, {domain: 'dlance.fabricasaitov.ru', path: '/'});
		$.cookie('units', 'y.e', {domain: 'dlance.fabricasaitov.ru', path: '/'});

		set(collection);
		deleteClass();
		$("#setUsd").addClass("bold");
	});
	$("#setEur").click(function () {
		$.cookie('value', eur, {domain: 'dlance.fabricasaitov.ru', path: '/'});
		$.cookie('units', 'Евро', {domain: 'dlance.fabricasaitov.ru', path: '/'});

		set(collection);
		deleteClass();
		$("#setEur").addClass("bold");
	});
	$("#setUah").click(function () {
		$.cookie('value', uah, {domain: 'dlance.fabricasaitov.ru', path: '/'});
		$.cookie('units', 'Гривен', {domain: 'dlance.fabricasaitov.ru', path: '/'});

		set(collection);
		deleteClass();
		$("#setUah").addClass("bold");
	});

});