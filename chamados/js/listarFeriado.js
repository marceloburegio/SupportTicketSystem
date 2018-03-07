$(document).ready(function(){
	// Cancelando um Grupo
	$(".excluirFeriado").click(function() {
		if (confirm("Deseja realmente EXCLUIR o feriado?")) {
			var objLinha = $(this).parents("tr");
			var strHashIdFeriado = $(this).parent().find(".strHashIdFeriado").val();
			if ($.trim(strHashIdFeriado) != "") {
				$.post("xt_cadastrarFeriado.php", {"strAcao" : "excluir", "strHashIdFeriado" : strHashIdFeriado}, function(res) {
					if (res.resposta) $(objLinha).fadeOut(200);
					else alert(res.mensagem);
				}, "json");
			}
		}
	});
});