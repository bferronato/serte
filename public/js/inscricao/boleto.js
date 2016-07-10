$('#pagamento').submit(function() {
	return validaBoleto();
});

function validaBoleto() {
	var msg = [], 
		retorno;
	
	if(!$("#nome").val()) {
		msg.push("Preencha o seu nome e salve sua inscrição antes de gerar o boleto");
	}
	
	if(!$("#endereco").val()) {
		msg.push("Preencha o seu enereço e salve sua inscrição antes de gerar o boleto");
	}
	
	if(!$("#uf").val()) {
		msg.push("Preencha o seu estado e salve sua inscrição antes de gerar o boleto");
	}
	
	if(!$("#cidade").val()) {
		msg.push("Preencha a sua cidade e salve sua inscrição antes de gerar o boleto");
	}
	
	if(!$("#cep").val()) {
		msg.push("Preencha o seu CEP e salve sua inscrição antes de gerar o boleto");
	}
	
	var associadoBoleto = $('input[name="socio-boleto"]:checked', '#pagamento').val();
	if(associadoBoleto === undefined) {
		msg.push("Selecione se é associado da SBPJOR");
	}
	
	var graduacaoBoleto = $('input[name=graduacaoBoleto]:checked', '#pagamento').val();
	if(graduacaoBoleto === undefined) {
		msg.push("Selecione a sua graduação");
	}
	
	if(msg.length > 0) {
		retorno = false;
		alert("Verifique os seguintes campos:\n\n" + msg.join('\n'));
	} else {
		retorno = true;
	}
	return retorno;
}

$('input[name="socio-boleto"],input[name="em-dia-boleto"],input[name="graduacaoBoleto"]').click(function() {
	/*
	 * Faixas valores
	 * Faixas de valores referentes a formacao do socio ou inscrito
	 * 1 Doutores
	 * 2 Mestres, especialistas, graduados, pos-graduados
	 * 3 Graduandos
	 */
	var faixaValor;
	var data1 = "30/09/2012";
	var data2 = "08/10/2012";
	var data3 = "30/10/2012";
	
	var objDate1 = new Date();
	objDate1.setYear(data1.split("/")[2]);
	objDate1.setMonth(data1.split("/")[1]  - 1);//- 1 pq em js é de 0 a 11 os meses
	objDate1.setDate(data1.split("/")[0]);
	
	var objDate2 = new Date();
	objDate2.setYear(data2.split("/")[2]);
	objDate2.setMonth(data2.split("/")[1]  - 1);//- 1 pq em js é de 0 a 11 os meses
	objDate2.setDate(data2.split("/")[0]);
	
	var objDate3 = new Date();
	objDate3.setYear(data3.split("/")[2]);
	objDate3.setMonth(data3.split("/")[1]  - 1);//- 1 pq em js é de 0 a 11 os meses
	objDate3.setDate(data3.split("/")[0]);
	
	if(new Date().getTime() <= objDate1.getTime() ) {
	    faixaValor = {"1":{"1":"10500","2":"8500","3":"6500"},
	    			  "0":{"1":"21000","2":"17000","3":"13000"}};
	} else if(new Date().getTime() <= objDate2.getTime()) {
		faixaValor = {"1":{"1":"12000","2":"9500","3":"7500"},
					  "0":{"1":"24000","2":"19500","3":"13500"}};
	} else {
		faixaValor = {"1":{"1":"15000","2":"10000","3":"8000"},
					  "0":{"1":"30000","2":"20000","3":"14500"}};
	}
	
	var socio = $('input[name=socio-boleto]:checked', '#pagamento').val();
	var emDiaBoleto = $('input[name=em-dia-boleto]:checked', '#pagamento').val();
	var graduacaoBoleto = $('input[name=graduacaoBoleto]:checked', '#pagamento').val();
	
	// Verifica se alem de ser socio, esta em dia com a mensalidade
	socio = socio & emDiaBoleto;
	
	$('input[name=valor]', '#pagamento').val(faixaValor[socio][graduacaoBoleto]);

});