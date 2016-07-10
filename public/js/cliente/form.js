/**
 * Mascaras de campos
 */
$('#celular, #telefone').mask("(99)9999-9999");
$('#cep').mask("99999-999");
$('#cpf').mask("999.999.999-99");
$('#cnpj').mask("99.999.999/9999-99");

/**
 * Busca dinamica das cidades
 */
$('#estado').change(function() {
	$.post("/cidade/cidades", {"estado": $(this).val()}, function(data) {
	  var cidade = $("#cidade");
	  cidade.empty().append($('<option></option>').val(0).text('Selecione a cidade'));
      $.each(data, function () {
    	  cidade.append($('<option></option>').val(this.id).text(this.nome));
      });
	}, "json");
});

$('#processo').typeahead({
    source: function (query, process) {
        return $.ajax({
            url: "/processo/processos",
            type: 'post',
            data: { query: query },
            dataType: 'json',
            success: function (result) {

                var resultList = result.map(function (item) {
                    var aItem = { id: item.id, numero: item.numero };
                    return JSON.stringify(aItem);
                });

                return process(resultList);

            }
        });
    },
    matcher: function (obj) {
        var item = JSON.parse(obj);
        return ~item.numero.toLowerCase().indexOf(this.query.toLowerCase());
    },
    sorter: function (items) {          
       var beginswith = [], caseSensitive = [], caseInsensitive = [], item;
        while (aItem = items.shift()) {
            var item = JSON.parse(aItem);
            if (!item.numero.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(JSON.stringify(item));
            else if (~item.numero.indexOf(this.query)) caseSensitive.push(JSON.stringify(item));
            else caseInsensitive.push(JSON.stringify(item));
        }
        return beginswith.concat(caseSensitive, caseInsensitive);

    },
    highlighter: function (obj) {
        var item = JSON.parse(obj);
        var query = this.query.replace(/\D/g,'');
        return item.numero.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
            return '<strong>' + match + '</strong>';
        });
    },
    updater: function (obj) {
        var item = JSON.parse(obj);
        
        montaListaProcessos(item.id, item.numero);
        
        return null;
    }
});

$("#formularioCliente").on("click", '.deleteProcesso', function() {
	if(confirm("Você tem certeza que deseja excluir o processo selecionado?")) {
		$(this).parent().remove();
		deleteProcesso($(this).attr('title'));
	}
});

// Carregar os processos na edicao
if($('#id_cliente').val()) {
	$.post('/cliente-processo/vinculados', {'id_cliente':$('#id_cliente').val()}, function(data) {
		$.each(data, function (i,processo) {
			montaListaProcessos(processo.id, processo.numero);
	    });
	}, "json");
}

function montaListaProcessos(id, numero) {
	$('#processo').val('').parent().append(
		$('<div/>').css({'margin-top':'5px'}).append(
            $('<i/>', {'class':'icon-remove deleteProcesso','title':id})
            	.css({'vertical-align':'middle','cursor':'pointer'})
        ).append($('<span/>').css({'margin-left':'5px'}).text(numero))
    );

    addProcesso(id);
    setProcessos();
}

var p1 = (function () {
	var processos = [],
		id_processos = $('#processos_vinculados');
	
    addProcesso = function(id_processo) {
    	processos.push(id_processo);
    };
    deleteProcesso = function(id_processo) {
    	processos.splice( processos.indexOf(id_processo), 1 );
    	setProcessos();
    };
    setProcessos = function() {
    	id_processos.val(getProcessos().join());
    };
    getProcessos = function() {
        return processos;
    };
})();
	
/**
 * Validacao do formulario de cadastro/edicao de clientes
 */
$("#formularioCliente").validate({
	errorElement: "span",
	errorClass: "help-inline",
    rules:{
        nome:{
            required: true, 
            minlength: 3
        },
        celular:{
        	required: true
        },
        cidade:{
        	min: 1
        },
        cpf:{
        	required: true
        },
        email:{
        	email: function(element) {
                return $("#email").val().length > 0;
            }
        }
    },
    messages:{
    	nome:{
            required: "Preencha o campo nome",
            minlength: "O campo nome deve ter no mínimo 3 caracteres"
        },
        celular:{
        	required: "Preencha o campo celular",
        },
        cidade:{
        	min: "Selecione a cidade",
        },
        cpf:{
        	required: "Preencha o campo CPF",
        },
        email:{
        	email: "O e-mail digitado é inválido"
        }
    }
});
//$.validator.addMethod("domain", function(value, element) { 
//	return this.optional(element) || /^http:\/\/mycorporatedomain.com/.test(value); 
//}, "Please specify the correct domain for your documents");