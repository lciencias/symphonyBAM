$.validator.addMethod(
		'Folio', 
		function (value, element) {
				regex = new RegExp('^[0-9]+$');
				if(value == '') return true;
				else if (value.length == 9 && regex.test(value)) return true;
				return false;
			
		},
		"Folio must have 9 digits and must be numeric"
);
$.validator.addMethod(
		'validDates', 
		function (value, element) {
				regex = new RegExp(/^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/);
				if(value == '') return true;
				else if (regex.test(value)) return true;
				return false;
			
		},
		"Esta no es una fecha v&aacute;lida"
);
$.validator.addMethod(
		'validPassword',
		function(value, element){
			regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$/);
			if (value == '') return true;
			else if (regex.test(value)) return true;
			else return false;
		},
		'La contrase&ntilde;a debe de contener al menos una may&uacute;scula, una min&uacute;scula y un n&uacute;mero y debe de ser de entre 8 y 15 caracteres');
$.validator.addMethod(
		'passwordMatch',
		function(value, element){
				matcherValue = $('#password').val();
				if (matcherValue == '' && value == '') return true;
				else if(matcherValue != value) return false;
				else return true;
		},
		'Las contrase&ntilde;as no coinciden'
		);
$.validator.addMethod(
		'validFiles', 
		function (value, element) {
			rule = $(element).data('rule');
			console.log(rule);
			var regex = new RegExp(rule);
			if(value == '') return true;
			else if (regex.test(value)) return true;
			return false;
		},
		"Solo se aceptan archivos con extensi&oacute;n xls y xlsx"
);
$.validator.classRuleSettings.validDates = { validDates : true };
$.validator.classRuleSettings.validPassword = { validPassword : true };
$.validator.classRuleSettings.passwordMatch = { passwordMatch : true };
$.validator.classRuleSettings.validFiles = { validFiles : true };