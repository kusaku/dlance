/*
 * Inline Form Validation Engine, jQuery plugin
 * 
 * Copyright(c) 2009, Cedric Dugas
 * http://www.position-relative.net
 *	
 * Form validation engine witch allow custom regex rules to be added.
 * Licenced under the MIT Licence
 */
$(document).ready(function () {

		// SUCCESS AJAX CALL, replace "success: false," by:		 success : function() { callSuccessFunction() }, 
		$("[class^=validate]").validationEngine({
				success: false,
				failure: function () {}
		})
});

jQuery.fn.validationEngine = function (settings) {
		// IS THERE A LANGUAGE LOCALISATION ?
		if ($.validationEngineLanguage) {
				allRules = $.validationEngineLanguage.allRules
		} else {
				// Add your regex rules here, you can take telephone as an example
				allRules = {
						"required": {
								"regex": "none",
										"alertText": "Внимание! Поле не должно быть пустым!",
										"alertTextCheckboxMultiple": "* Пожалуйста, выберите опцию",
										"alertTextCheckboxe": "* Опция не выбрана"
						},
								"length": {
								"regex": "Нет",
										"alertText": "Между ",
										"alertText2": " и ",
										"alertText3": " символов"
						},
								"minCheckbox": {
								"regex": "none",
										"alertText": "Выбрано слишком много!"
						},
								"confirm": {
								"regex": "none",
										"alertText": "Поля не совпадают!"
						},

								"telephone": {
								"regex": "/^[0-9\-\(\)\+]{0,16}$/",
										"alertText": "Некорректный номер телефона!"
						},

								"email": {
								"regex": "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/",
										"alertText": "Неправильный адрес!"
						},

								"onlyLetter": {
								"regex": "/^[а-яА-Я]+$/",
										"alertText": "Только русские буквы!"
						},

								"onlyNumber": {
								"regex": "/^[0-9]+$/",
										"alertText": "Только цифры!"
						},

								"skype": {
								"regex": "/^[a-zA-z0-9_\-]{0,16}$/",
										"alertText": "Может содержать латинские символы, цифры, знак подчеркивания и дефис."
						},

								"username": {
								"regex": "/^[a-zA-z0-9]+$/",
										"alertText": "Может содержать латинские символы, цифры."
						},

								"noSpecialCaracters": {
								//"regex": "/[^\||\'|\<|\>|\"|\!|\?|\$|\@|\/|\\\|\&\~\*\+]+$/",
								"regex": "none",
										"alertText": "Специальные символы запрещены!"
						},

								"Number": {
								"regex": "/^[0-9]{0,24}$/",
										"alertText": "Только цифры!"
						}
				}
		}

		settings = jQuery.extend({
				allrules: allRules,
				success: false,
				failure: function () {}
		}, settings);

		// ON FORM SUBMIT, CONTROL AJAX FUNCTION IF SPECIFIED ON DOCUMENT READY
		$("form").bind("submit", function (caller) {
				if (submitValidation(this) == false) {
						if (settings.success) {
								settings.success && settings.success();
								return false;
						}
				} else {
						settings.failure && settings.failure();
						return false;
				}
		})
		$(this).not("[type=checkbox]").bind("blur click", function (caller) {
				loadValidation(this)
		});

		// ERROR PROMPT CREATION AND DISPLAY WHEN AN ERROR OCCUR
		var buildPrompt = function (caller, promptText) {
				var divFormError = document.createElement('div')
				var formErrorContent = document.createElement('div')
				var arrow = document.createElement('div')

				$(divFormError).addClass("formError")
				$(divFormError).addClass($(caller).attr("name"))
				$(formErrorContent).addClass("formErrorContent")
				$(arrow).addClass("formErrorArrow")

				$("body").append(divFormError)
				$(divFormError).append(arrow)
				$(divFormError).append(formErrorContent)
				$(arrow).html('<div class="line10"></div><div class="line9"></div><div class="line8"></div><div class="line7"></div><div class="line6"></div><div class="line5"></div><div class="line4"></div><div class="line3"></div><div class="line2"></div><div class="line1"></div>')
				$(formErrorContent).html(promptText)

				callerTopPosition = $(caller).offset().top;
				callerleftPosition = $(caller).offset().left;
				callerWidth = $(caller).width()
				callerHeight = $(caller).height()
				inputHeight = $(divFormError).height()

				callerleftPosition = callerleftPosition + callerWidth - 30
				callerTopPosition = callerTopPosition - inputHeight - 10

				$(divFormError).css({
						top: callerTopPosition,
						left: callerleftPosition,
						opacity: 0
				})
				$(divFormError).fadeTo("fast", 0.8);
		};
		// UPDATE TEXT ERROR IF AN ERROR IS ALREADY DISPLAYED
		var updatePromptText = function (caller, promptText) {
				updateThisPrompt = $(caller).attr("name")
				$("." + updateThisPrompt).find(".formErrorContent").html(promptText)

				callerTopPosition = $(caller).offset().top;
				inputHeight = $("." + updateThisPrompt).height()

				callerTopPosition = callerTopPosition - inputHeight - 10
				$("." + updateThisPrompt).animate({
						top: callerTopPosition
				});
		}
		// GET VALIDATIONS TO BE EXECUTED
		var loadValidation = function (caller) {

				rulesParsing = $(caller).attr('class');
				rulesRegExp = /\[(.*)\]/;
				getRules = rulesRegExp.exec(rulesParsing);
				str = getRules[1]
				pattern = /\W+/;
				result = str.split(pattern);

				var validateCalll = validateCall(caller, result)
				return validateCalll

		};
		// EXECUTE VALIDATION REQUIRED BY THE USER FOR THIS FILED
		var validateCall = function (caller, rules) {
				var promptText = ""
				var isError = false
				var prompt = $(caller).attr("name")
				var caller = caller

				for (i = 0; i < rules.length; i++) {
						switch (rules[i]) {
								case "required":
										_required(caller, rules)
										break;
								case "custom":
										_customRegex(caller, rules, i)
										break;
								case "length":
										_length(caller, rules, i)
										break;
								case "minCheckbox":
										_minCheckbox(caller, rules, i)
										break;
								case "confirm":
										_confirm(caller, rules, i)
										break;
								default:
										;
						}
				}
				if (isError == true) {
						($("." + prompt).size() == 0) ? buildPrompt(caller, promptText) : updatePromptText(caller, promptText)
				} else {
						closePrompt(caller)
				}

				/* VALIDATION FUNCTIONS */
				// VALIDATE BLANK FIELD
				function _required(caller, rules) {
						callerType = $(caller).attr("type")

						if (callerType == "text" || callerType == "password" || callerType == "textarea") {

								if (!$(caller).val()) {
										isError = true
										promptText += settings.allrules[rules[i]].alertText + "<br />"
								}
						}
						if (callerType == "radio" || callerType == "checkbox") {
								callerName = $(caller).attr("name")

								if ($("input[name=" + callerName + "]:checked").size() == 0) {
										isError = true
										if ($("input[name=" + callerName + "]").size() == 1) {
												promptText += settings.allrules[rules[i]].alertTextCheckboxe + "<br />"
										} else {
												promptText += settings.allrules[rules[i]].alertTextCheckboxMultiple + "<br />"
										}
								}
						}
				}
				// VALIDATE REGEX RULES
				function _customRegex(caller, rules, position) {
						customRule = rules[position + 1]
						pattern = eval(settings.allrules[customRule].regex)

						if (!pattern.test($(caller).attr('value'))) {
								isError = true
								promptText += settings.allrules[customRule].alertText + "<br />"
						}
				}
				// VALIDATE FIELD MATCH
				function _confirm(caller, rules, position) {
						confirmField = rules[position + 1]

						if ($(caller).attr('value') != $("#" + confirmField).attr('value')) {
								isError = true
								promptText += settings.allrules["confirm"].alertText + "<br />"
						}
				}
				// VALIDATE LENGTH
				function _length(caller, rules, position) {

						startLength = eval(rules[position + 1])
						endLength = eval(rules[position + 2])
						feildLength = $(caller).attr('value').length

						if (feildLength < startLength || feildLength > endLength) {
								isError = true
								promptText += settings.allrules["length"].alertText + startLength + settings.allrules["length"].alertText2 + endLength + settings.allrules["length"].alertText3 + "<br />"
						}
				}
				// VALIDATE CHECKBOX NUMBER
				function _minCheckbox(caller, rules, position) {

						nbCheck = eval(rules[position + 1])
						groupname = $(caller).attr("name")
						groupSize = $("input[name=" + groupname + "]:checked").size()

						if (groupSize > nbCheck) {
								isError = true
								promptText += settings.allrules["minCheckbox"].alertText + "<br />"
						}
				}
				return (isError) ? isError : false;
		};
		// CLOSE PROMPT WHEN ERROR CORRECTED
		var closePrompt = function (caller) {
				closingPrompt = $(caller).attr("name")

				$("." + closingPrompt).fadeTo("fast", 0, function () {
						$("." + closingPrompt).remove()
				});
		};
		// FORM SUBMIT VALIDATION LOOPING INLINE VALIDATION
		var submitValidation = function (caller) {
				var stopForm = false
				$(".formError").remove()
				var toValidateSize = $(caller).find("[class^=validate]").size()

				$(caller).find("[class^=validate]").each(function () {
						var validationPass = loadValidation(this)
						return (validationPass) ? stopForm = true : "";
				});
				// GET IF THERE IS AN ERROR OR NOT FROM THIS VALIDATION FUNCTIONS
				if (stopForm) {
						destination = $(".formError:first").offset().top;
						$("html:not(:animated),body:not(:animated)").animate({
								scrollTop: destination
						}, 1100)
						return true;
				} else {
						return false
				}
		};
};