$('#doador').change(function() {
	if($(this).val() > 0) {
		
		$.post("./processoss", {"doador": $(this).val()}, function(data) {
//		  var processosVinculados = $("#processosVinculados");
//		  processosVinculados.empty();
//		  processosVinculados.append($('<option></option>').attr("value", 0).text('Selecione a cidade'));
//          $.each(data, function () {
//        	  processosVinculados.append($('<option></option>').val(this.id).text(this.nome));
//          });
		}, "json");
	}
});