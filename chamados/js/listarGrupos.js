$(document).ready(function(){
	// Cancelando um Grupo
	$(".cancelarGrupo").click(function() {
		if (confirm("Deseja realmente CANCELAR o grupo?")) {
			var objLinha = $(this).parents("tr");
			var strHashIdGrupo = $(this).parent().find(".strHashIdGrupo").val();
			if ($.trim(strHashIdGrupo) != "") {
				$.post("xt_cadastrarGrupo.php", {"strAcao" : "cancelar", "strHashIdGrupo" : strHashIdGrupo}, function(res) {
					if (res.resposta) $(objLinha).fadeOut(200);
					else alert(res.mensagem);
				}, "json");
			}
		}
	});
});