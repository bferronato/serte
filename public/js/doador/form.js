(function($) {
    
    "use strict";

    /**
     * Mascaras de campos
     */
    $('#celular, #telefone').mask("(99)9999-9999");
    $('#cep').mask("99999-999");
    $('#cpf').mask("999.999.999-99");
    $('#cnpj').mask("99.999.999/9999-99");
    // Cria a mascara para os campos de valor e inicia a mascara (.maskMoney('mask'))
    $('#valor, #valor_celesc').maskMoney({showSymbol:true,prefix:"R$",decimal:",",thousands:".",allowZero:false}).maskMoney('mask');

    /**
     * Exibe ou esconde os formularios de doacao
     */
    $('input[name="tipo[]"]').change(function () {
        var formulario = $('#form-' + $(this).val());
        if($(this).is(':checked')) {
            formulario.show();
        } else {
            formulario.hide();
        }
    }).change();

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

//    $("#formularioDoador").on("click", '.deleteProcesso', function() {
//        var confirm = confirm("Você tem certeza que deseja excluir o processo selecionado?");
//        if (confirm) {
//            $(this).parent().remove();
//            deleteProcesso($(this).attr('title'));
//        }
//    });


    /**
     * Validacao do formulario de cadastro/edicao de doadores
     */
    $("#formularioDoador").validate({
        errorElement: "span",
        errorClass: "help-inline",
        rules: {
            telefone: {
                //required: true
            },
            valor: {
                //required: true
            }
        },
        messages: {
            telefone: {
                required: "Preencha o campo telefone"
            },
            valor: {
                required: "Preencha o campo valor"
            }
        }
    });
    //$.validator.addMethod("domain", function(value, element) {
    //    return this.optional(element) || /^http:\/\/mycorporatedomain.com/.test(value);
    //}, "Please specify the correct domain for your documents");
})(jQuery);