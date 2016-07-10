/**
 * Validacao do formulario de cadastro/edicao de comarca
 */
$("#formularioComarca").validate({
	errorElement: "span",
	errorClass: "help-inline",
    rules:{
        nome:{
            required: true, 
            minlength: 3
        }
    },
    messages:{
    	nome:{
            required: "Preencha o campo nome",
            minlength: "O campo nome deve ter no mínimo 3 caracteres"
        }
    }
});