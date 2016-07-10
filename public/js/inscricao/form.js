$('input[name=nacionalidade]', '#formulario-inscricao').click(function() {

	if( $(this).val() == 'brasileira') {
		$('#div-cpf').show();
		$('#div-passaporte').hide();
	} else if($(this).val() == 'estrangeira') {
		$('#div-passaporte').show();
		$('#div-cpf').hide();
	}
});
$('input[name=nacionalidade]:checked', '#formulario-inscricao').click();

$('#id-pais').change(function() {
	//if($(this).val() > 0) {
		$.post("./estados", {"pais": $(this).val()}, function(data) {
		  var estado = $("#id-estado");
		  estado.empty();
		  estado.append($('<option></option>').attr("value", 0).text('Selecione o estado'));
          $.each(data, function () {
        	  estado.append($('<option></option>').attr("value", this.id).text(this.nome));
          });
          $('#id-estado').change();
		}, "json");
	//}
});

$('#id-estado').change(function() {
	//if($(this).val() > 0) {
		$.post("./cidades", {"estado": $(this).val()}, function(data) {
		  var cidade = $("#id-cidade");
		  cidade.empty();
		  cidade.append($('<option></option>').attr("value", 0).text('Selecione a cidade'));
          $.each(data, function () {
        	  cidade.append($('<option></option>').attr("value", this.id).text(this.nome));
          });
		}, "json");
	//}
});

$('#formulario-inscricao').submit(function() {
	return validaFormulario();
});


//$('#boleto').click(function() {
//	if( validaBoleto() ) {
//
//		var associadoBoleto = $('input[name=socio-boleto]:checked', '#formulario-inscricao').val();
//		var emDiaBoleto = $('input[name=em-dia-boleto]:checked', '#formulario-inscricao').val();
//		var graduacaoBoleto = $('input[name=graduacao]:checked', '#formulario-inscricao').val();
//
//		var params = {
//			"nome-boleto":$("#nome-boleto").val(),
//			"endereco-boleto":$("#endereco-boleto").val(),
//			"uf-boleto":$("#uf-boleto").val(),
//			"cidade-boleto":$("#cidade-boleto").val(),
//			"cep-boleto":$("#cep-boleto").val(),
//			"associadoBoleto":associadoBoleto,
//			"emDiaBoleto":emDiaBoleto,
//			"graduacaoBoleto":graduacaoBoleto
//		};
//		
//		$.post("./boleto", params);
//		
////		$.post("./boleto", params, function(data) {
////			 
////		});
//	}
//});

function validaFormulario() {
	var msg = [], 
		retorno;
	
	if(!$("#nome").val()) {
		msg.push("Preencha o seu nome");
	}
	
	if(!$("#nome-cracha").val()) {
		msg.push("Preencha o nome do seu crachá");
	}
	
	if(!$("#universidade").val()) {
		msg.push("Preencha o nome da sua universidade");
	}
	
	var nacionalidade = $('input[name=nacionalidade]:checked', '#formulario-inscricao').val();
	if(nacionalidade === undefined) {
		msg.push("Selecione sua nacionalidade");
	}
	
	if(nacionalidade == 'brasileira') {
		if(!$("#cpf").val()) {
			msg.push("Preencha o seu CPF");
		}
	} else {
		if(!$("#passaporte").val()) {
			msg.push("Preencha o seu passaporte");
		}
	}
	
	if(!$("#email").val()) {
		msg.push("Preencha o seu e-mail");
	}
	
	if(!$("#telefone").val()) {
		msg.push("Preencha o seu telefone para contato");
	}
	
	if(!$("#telefone").val()) {
		msg.push("Preencha o seu telefone para contato");
	}
	
	var termoEdital = $('input[name=termo-edital]:checked', '#formulario-inscricao').val();
	if(termoEdital != "1") {
		msg.push("Marque a opção que está ciente dos termos do Edital,");
	}
	
	if(msg.length > 0) {
		retorno = false;
		alert("Verifique os seguintes campos:\n\n" + msg.join('\n'));
	} else {
		retorno = true;
	}
	return retorno;
}


//$('input[name=taxa-inscricao]', '#formulario-inscricao').click(function() {
//	/*
//	 * Faixas valores
//	 * Faixas de valores referentes a formacao do socio ou inscrito
//	 * 1 Doutores
//	 * 2 Mestres, especialistas, graduados, pos-graduados
//	 * 3 Graduandos
//	 */
//	var faixaValor = {"1":{"1":"105,00","2":"85,00","3":"65,00"},
//					  "0":{"1":"210,00","2":"170,00","3":"130,00"}};
//	
////	alert(faixaValor['1']['1']);
////	alert(faixaValor['1']['2']);
////	alert(faixaValor['1']['3']);
////	alert(faixaValor['2']['1']);
////	alert(faixaValor['2']['2']);
////	alert(faixaValor['2']['3']);
//
//	
//	var formacao = $(this).val();
//	console.log(formacao)
//	var socio = $('input[name=socio]:checked', '#formulario-inscricao').val();
//	console.log(socio)
//	
//	$('#valor').html(faixaValor[socio][formacao]);
//	//$('#valor').val('ok');
//	
//	
//	// TRATAR A DATA!!!
//	if(faixaValor) {
//		
//	}
//	
//	
//	
//});


/// Preenchimento do formulario
//$("input").each(function() {
//	$(this).val($(this).attr('name'));
//});

//$("input[type='radio']").each(function() {
//	$(this).attr('checked', 'checked');
//});
