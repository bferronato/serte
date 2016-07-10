//$('#doador').change(function() {
//	if($(this).val() > 0) {
//		
//		$.post("./vinculados", {"id_doador": $(this).val()}, function(data) {
//			var processosVinculados = $("#processosVinculados");
//			processosVinculados.empty();
//			$.each(data, function (i,j) {
//				processosVinculados.append($('<option></option>').val(j.id).text(j.numero));
//			});
//			
//			if( data.length == 0 ) {
//				processosVinculados.append($('<option></option>').val(0).text('Nenhum processo vinculado'));
//			}
//		}, "json");
//		
//		$.post("./nao-vinculados", {"id_doador": $(this).val()}, function(data) {
//			var processosNaoVinculados = $("#processosNaoVinculados");
//			processosNaoVinculados.empty();
//			$.each(data, function (i,j) {
//				processosNaoVinculados.append($('<option></option>').val(j.id).text(j.numero));
//			});
//			
//			if( data.length == 0 ) {
//				processosNaoVinculados.append($('<option></option>').val(0).text('Nenhum processo disponível'));
//			}
//		}, "json");
//	}
//});
//
//$('#vincular').click(function() {
//
//	var id_doador = $("#doador").find(":selected").val(),
//		id_processo = $("#processosNaoVinculados").find(":selected").val(),
//		numero_processo = $("#processosNaoVinculados").find(":selected").text(),
//		erro = [];
//
//	if(!id_doador) {
//		erro.push('Selecione o doador');
//	}
//	
//	if(!id_processo || id_processo == 0) {
//		erro.push('Selecione o processo para vincular');
//	}
//
//	if(erro.length == 0) {
//		$.post("./post", {"id_doador":id_doador,"id_processo":id_processo}, function(data) {
//			if(data.result) {
//				$("#processosNaoVinculados").find(":selected").remove();
//				$('#processosVinculados option[value="0"]').remove();
//				$("#processosVinculados").append($('<option></option>').val(id_processo).text(numero_processo));
//				$('.alert').message({'msg':'Processo vinculado com sucesso'});
//				if($('#processosNaoVinculados option').length == 0) {
//					$("#processosNaoVinculados").append($('<option></option>').val(0).text('Nenhum processo disponível'));
//				}
//			} else {
//				$('.alert').message({'msg':data.msg});
//			}
//		}, "json");
//	} else {
//		$('.alert').message({'msg':erro.join('<br />')});
//	}
//	
//});
//
//$('#desvincular').click(function() {
//
//	var id_doador = $("#doador").find(":selected").val(),
//		id_processo = $("#processosVinculados").find(":selected").val(),
//		numero_processo = $("#processosVinculados").find(":selected").text(),
//		erro = [];
//
//	if(!id_doador) {
//		erro.push('Selecione o doador');
//	}
//	
//	if(!id_processo || id_processo == 0) {
//		erro.push('Selecione o processo para desvincular');
//	}
//
//	if(erro.length == 0) {
//		$.post("./delete", {"id_doador":id_doador,"id_processo":id_processo}, function(data) {
//			if(data.result) {
//				$("#processosVinculados").find(":selected").remove();
//				$('#processosNaoVinculados option[value="0"]').remove();
//				$("#processosNaoVinculados").append($('<option></option>').val(id_processo).text(numero_processo));
//				$('.alert').message({'msg':'Processo desvinculado com sucesso'});
//				if($('#processosVinculados option').length == 0) {
//					$("#processosVinculados").append($('<option></option>').val(0).text('Nenhum processo vinculado'));
//				}
//			} else {
//				$('.alert').message({'msg':data.msg});
//			}
//		}, "json");
//	} else {
//		$('.alert').message({'msg':erro.join('<br />')});
//	}
//	
//});