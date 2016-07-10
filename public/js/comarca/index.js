var comarca = {
    formulario: {
    	limpar: function() {
    		$('#busca').val('');
    		$('.pesquisar').submit();
        }
    }
};

$('#limpar').click(function(e) {
	comarca.formulario.limpar();
});

$('.delete').click(function(e) {
	e.preventDefault();
	
	if( confirm("Você tem certeza que deseja " + $(this).attr("title") + "?") ) {
		$this = $(this);
		var url = $this.attr('href');
		$.ajax({
			url:url,
			success:function(data) {
			  $this.parent().parent().remove();
	    }});
	}
});

$('#busca').focus();