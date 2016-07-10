var cliente = {
    formulario: {
    	limpar: function() {
    		$('#busca').val('');
    		$('.pesquisar').submit();
        }
    }
};

$('#limpar').click(function(e) {
	cliente.formulario.limpar();
});

$('.delete').click(function(e) {
	return confirm("Você tem certeza que deseja " + $(this).attr("title") + "?");
});

$('.detalhes').click(function(e) {
	$(this).parent().next().toggle();
}).css('cursor','pointer');

$('#busca').focus();

//function Cliente() {
//	// Private variable
//	var name;
//
//	// Private method
//	var privateMethod = function(){
//		// Access to private fields
//		name += " Changed";
//	};
//
//	return {
//	    // Public methods
//	    setName: function(newName) {
//	        name = newName;
//	        privateMethod();
//	    },
//	    getName: function() {
//	        return name;
//	    }
//	};
//}
//
//var user = new User();
//user.setName("My Name");
//user.getName(); // My Name Changed