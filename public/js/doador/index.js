var doador = {
    formulario: {
    	limpar: function() {
    		$('#busca').val('');
    		$('.pesquisar').submit();
        }
    }
};

$('#limpar').click(function(e) {
	doador.formulario.limpar();
});

$('.delete').click(function(e) {
	return confirm("Você tem certeza que deseja " + $(this).attr("title") + "?");
});

$('.detalhes').click(function(e) {
	$(this).parent().next().toggle();
}).css('cursor','pointer');

$('#busca').focus();