/**
 * Busca dinamica das cidades
 */
$('#comarca').change(function() {
	$.post("/vara/varas", {"comarca": $(this).val()}, function(data) {
	  var vara = $("#vara");
	  vara.empty().append($('<option></option>').val(0).text('Selecione a vara'));
      $.each(data, function () {
    	  vara.append($('<option></option>').val(this.id).text(this.nome));
      });
	}, "json");
});

$('#arquivo_morto').click(function() {
	$this = $(this);
	if ($this.is(':checked')) {
		$this.parent().parent().next().removeClass('hide');
	} else {
		$this.parent().parent().next().addClass('hide');
	} 
});

/**
 * Validacao do formulario de cadastro/edicao de doadores
 */
$("#formularioProcesso").validate({
	errorElement: "span",
	errorClass: "help-inline",
    rules:{
        numero:{
            required: true, 
            maxlength: 25
        },
        assunto:{
        	required: true,
        	maxlength: 100
        },
        estado:{
        	min: 1
        },
        justica:{
        	min: 1
        },
        vara:{
        	min: 1
        },
        numero_arquivo_morto:{
        	required: function(element) {
        		return $('#arquivo_morto').is(':checked') ? true : false;
            }
        }
    },
    messages:{
    	numero:{
            required: "Preencha o campo número",
            maxlength: "O campo número deve ter no máximo 25 caracteres"
        },
        assunto:{
        	required: "Preencha o campo assunto",
        	maxlength: "O campo assunto deve ter no máximo 100 caracteres"
        },
        estado:{
        	min: "Selecione o estado"
        },
        justica:{
        	min: "Selecione o tipo de justiça"
        },
        vara:{
        	min: "Selecione a vara"
        },
        numero_arquivo_morto:{
            required: "Preencha o campo número do arquivo morto"
        }
    }
});