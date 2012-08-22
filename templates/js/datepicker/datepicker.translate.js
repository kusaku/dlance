function Datepicker() {
	// Change this to true to start debugging
	this.debug = false; 
	// Next ID for a date picker instance
	this._nextId = 0; 
	// List of instances indexed by ID
	this._inst = []; 
	// The current instance in use
	this._curInst = null; 
	// List of date picker inputs that have been disabled
	this._disabledInputs = []; 
	// True if the popup picker is showing , false if not
	this._datepickerShowing = false; 
	// True if showing within a "dialog", false if not
	this._inDialog = false; 
	// Available regional settings, indexed by language code
	this.regional = []; 
	// Default regional settings
	this.regional[''] = { 
		// Display text for clear link
		clearText: 'Очистить', 
		// Status text for clear link
		clearStatus: 'Стереть текущую дату', 
		// Display text for close link
		closeText: 'Закрыть', 
		// Status text for close link
		closeStatus: 'Закрыть без сохранения', 
		// Display text for previous month link
		prevText: '&#x3c;Пред', 
		// Status text for previous month link
		prevStatus: 'Предыдущий месяц', 
		// Display text for next month link
		nextText: 'След&#x3e;', 
		// Status text for next month link
		nextStatus: 'Следующий месяц', 
		// Display text for current month link
		currentText: 'Сегодня', 
		// Status text for current month link
		currentStatus: 'Текущий месяц', 
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			// Names of months for drop-down and formatting
			'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], 
		// For formatting
		monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'], 
		// Status text for selecting a month
		monthStatus: 'Показать другой месяц', 
		// Status text for selecting a year
		yearStatus: 'Показать другой год', 
		// Header for the week of the year column
		weekHeader: 'Нед', 
		// Status text for the week of the year column
		weekStatus: 'Неделя года', 
		// For formatting
		dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'], 
		// For formatting
		dayNamesShort: ['Вск', 'Пнд', 'Втр', 'Срд', 'Чтв', 'Птн', 'Сбт'], 
		// Column headings for days starting at Sunday
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'], 
		// Status text for the day of the week selection
		dayStatus: 'Установить первым днем недели', 
		// Status text for the date selection
		dateStatus: 'Выбрать день, месяц, год', 
		// See format options on parseDate
		dateFormat: 'dd.mm.yy', 
		// The first day of the week, Sun = 0, Mon = 1, ...
		firstDay: 1, 
		// Initial Status text on opening
		initStatus: 'Выбрать дату', 
		// True if right-to-left language, false if left-to-right
		isRTL: false 
	};