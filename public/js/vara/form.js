/**
 * Validacao do formulario de cadastro/edicao de vara
 */
$("#formularioVara").validate({
	errorElement: "span",
	errorClass: "help-inline",
    rules:{
        comarca:{
        	required: true
        },
        nome:{
            required: true, 
            minlength: 3
        }
    },
    messages:{
        comarca:{
        	required: "Selecione uma comarca",
        },
        nome:{
            required: "Preencha o campo nome",
            minlength: "O campo nome deve ter no mínimo 3 caracteres"
        }
    }
});