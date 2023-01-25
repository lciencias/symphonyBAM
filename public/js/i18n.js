
var I18n = {
		"_": function(message){
			return this.messages[language][message] || message;
		},    

		messages: {
			'es': {
				"Deactivate" : "Desactivar",
				"Required field" : "Campo requerido",
				"This item will be deactivated. Are you sure?": "Esta seguro?",
				"OK": "Aceptar",
				"Cancel": "Cancelar",
				"# Ticket": "No Ticket",
				"Employee": "Empleado",
				"Registered By User": "Registrado por",
				"Ticket Created Date": "Fecha de Creacion",
				"Ticket Scheduled Date": "Fecha de Realizacion",
				"Ticket Type": "Tipo de Ticket",
				"Status": "Estatus",
				"Priority": "Prioridad",
				"Impact": "Impacto",
				"Channel": "Canal",
				"Description": "Descripcion",
				"Company": "Empresa",
				"Category": "Categoria",
				"Group": "Grupo",
				"Description": "Descripci�n",
				"Amount": "Monto",
				"BAM": "BAM",
				"Current balance":"Saldo Actual",
				"Post date": "Fecha de posteo",
				"Unavailable account statement": "Estado de cuenta no disponible",
				"Amortization information" : "Informaci�n de Amortizaci�nx",
				"Date of subscription": "Fecha de Abono",
				"Amount" : "Importe",
				"No depreciation data" : "No hay datos de amortizaciones",
				"Amortization information": "Informaci�n de Amortizaci�n",
				"Transaction not found" : "Transacci�n no encontrada",
				"No connection to the Webservice":"No hay conexion con el Webservice",
				"The product has no registered reason":"El producto no tiene motivos registrados",
				"Select": "Seleccionar",
				"Assigned User": "Usuario Asignado",
				"The range of hours is incorrect": "El intervalo de tiempo es incorrecto",
				"Expiration Date": "Fecha de Vencimiento",
				"Expired Time: ": "Tiempo vencido: ",
				"DOMICILE": "DOMICILIO",
				"Street": "Calle",
				"External number": "N�mero exterior",
				"Internal number": "N�mero interior",
				"Colony": "Colonia",
				"Zip code": "C�digo Postal",
				"Town": "Ciudad",
				"State": "Estado",			
				"RFC": "RFC",
				"Failed to connect to database" : "Error al conectar a la base de datos",
				"Please type in two search fields": "Si la busqueda es por nombre, apellidos o rfc, por favor ingrese dos campos de busqueda.",
				"More": "M�s",
				"Select transactions of one type" : "Seleccione transacciones de un tipo",
				"Yes": "Si",
				"No": "No",
				"Failed to save data" : "Error al intentar guardar los datos",
				"Required fields": "Todos los campos son obligatorios",
				"Non-applied deposit": "Dep�sito no aplicado",
				"Select": "Seleccionar",
				"Partial":"Parcial",
				"The Folio Condusef is Required" : "El Folio Condusef es obligatorio",
				"The Channel is Required" : "El canal es obligatorio",
				"Total":"Total",
				"Amount deposited":"Importe depositado",
				"Deposit date":"Fecha del dep�sito",
				"Deposit file":"Archivo del dep�sito",
				"Please provide email" : "Favor de proporcionar el correo electronico",
				"Error generating document" : "Error al generar el documento",
				"Error generating mail sending" : "Error al generar el envio del correo",
				"Incorrect email" : "Correo electronico incorrecto",
				"Transactions not found, please check the selection" : "Transacciones no encontradas, favor de verificar su selecci�n",
				"ChargesBack not found, please check the selection" : "Contracargos no encontradas, favor de verificar su selecci�n",
				"Account has no products": "La cuenta no tiene productos",
				"Account has no transactions" : "Transacciones no encontradas, favor de verificar su selecci�n",
				"P r o c e s s i n g . . . . . . .":"P r o c e s a n d o . . . . . .",
				"BIRTHDATE": "Fecha de Nacimiento",
				"Select a chargeback" : "Seleccione un contracargo",
				"HOME PHONE": "Tel�fono de casa",
				"MOBILE PHONE": "Tel�fono m�vil",
				"Select a transaction" : "Seleccione una transacci�n",
				"NON-SUCCESSFUL VALIDATION": "VALIDACI�N NO EXITOSA",				
				"Account": "Cuenta",
				"Paysheet": "N�mina",
				"Products": "Productos",
				"The email has been sent":"Se ha enviado el correo",
				"Please select a period" : "Por favor seleccione un periodo",
				"Failed to query Database" : "Error al consultar la Base de datos",
				"Percentage of Service:" : "Porcentaje de Servicio:",
				"Id":"id",
				"Transaction date" : "Fecha de transacci�n",											
				"Post date" : "Fecha de posteo",											
				"Description" : "Descripci�n",
				"No information available": "Sin informacion disponible",
				"Reference number" : "N�mero de referencia",
				"Amount" : "Importe en M.N."
			}, 'en': {
				"Spanish": "Spanish"
			}
		}
};
function translate(s){
	value = s;
	switch (s){
		case 'Folio must have 9 digits and must be numeric': 
			if (language == 'es')
				value = 'El folio debe contener 9 d&iacute;gitos y debe ser num&iacute;rico';
			break;	
	}
	return value;
}