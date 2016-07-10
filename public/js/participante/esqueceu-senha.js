$('#formulario-esqueceu-senha').submit(function() {
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
	
	if(msg.length > 0) {
		retorno = false;
		alert("Verifique os seguintes campos:\n\n" + msg.join('\n'));
	} else {
		retorno = true;
	}
	return retorno;
}