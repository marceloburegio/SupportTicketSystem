$(document).ready(function(){
	// Cancelando um Grupo
	$(".cancelarAssunto").click(function() {
		if (confirm("Deseja realmente CANCELAR o assunto?")) {
			var objLinha = $(this).parents("tr");
			var strHashIdAssunto = $(this).parent().find(".strHashIdAssunto").val();
			if ($.trim(strHashIdAssunto) != "") {
				$.post("xt_cadastrarAssunto.php", {"strAcao" : "cancelar", "strHashIdAssunto" : strHashIdAssunto}, function(res) {
					if (res.resposta) $(objLinha).fadeOut(200);
					else alert(res.mensagem);
				}, "json");
			}
		}
	});
});