$('#formulario-add').submit(function() {
	return validaFormulario();
});

function validaFormulario() {
	var msg = [], 
		retorno,
		objEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,
		email = $("#email").val();
	
	if(!email) {
		msg.push("Preencha o e-mail");
	} else if(!objEmail.test(email)) {
		msg.push("O e-mail digitado é inválido");
	}
	
	if(!$("#senha").val()) {
		msg.push("Preencha a senha");
	}
	
	if(!$("#senha2").val()) {
		msg.push("Preencha o campo repita senha");
	}
	
	if( $("#senha").val() !== $("#senha2").val() ) {
		msg.push("As senhas preenchidas não conferem");
	}
	
	if(msg.length > 0) {
		retorno = false;
		alert("Verifique os seguintes campos:\n\n" + msg.join('\n'));
	} else {
		retorno = true;
	}
	return retorno;
}

/// Preenchimento do formulario
//$("input").each(function() {
//	$(this).val($(this).attr('name'));
//});

//$("input[type='radio']").each(function() {
//	$(this).attr('checked', 'checked');
//});
