$(document).ready(function(){
	$("#strLogin").blur(function() {
		// Limpando o Nome do Usuario
		$("#strNomeUsuario").val("");
		
		if ($.trim($(this).val()) != "") {
			$.post("xt_procurarUsuario.php", {"strLogin" : $("#strLogin").val()}, function(res) {
				if (res.resposta) {
					$("#strNomeUsuario").addClass("loginOk");
					$("#strNomeUsuario").removeClass("loginErro");
				}
				else {
					$("#strNomeUsuario").addClass("loginErro");
					$("#strNomeUsuario").removeClass("loginOk");
				}
				$("#strNomeUsuario").val(res.mensagem);
			},"json");
		}
	});
	
	// Adicionando as permissoes do Usuario para Admin
	$(document).on("click", ".adicionarUsuarioAdmin", function() {
		var strHashIdGrupo = $(this).parent().find(".strHashIdGrupo").val();
		var strHashIdUsuario = $(this).parent().find(".strHashIdUsuario").val();
		var bolFlagAdmin = "true";
		modificarPermissoesUsuario(strHashIdGrupo, strHashIdUsuario, bolFlagAdmin);
	});
	
	// Removendo as permissoes do Usuario para Admin
	$(document).on("click", ".removerUsuarioAdmin", function() {
		var strHashIdGrupo = $(this).parent().find(".strHashIdGrupo").val();
		var strHashIdUsuario = $(this).parent().find(".strHashIdUsuario").val();
		var bolFlagAdmin = "false";
		modificarPermissoesUsuario(strHashIdGrupo, strHashIdUsuario, bolFlagAdmin);
	});
	
	// Excluindo o Usuario do Grupo
	$(document).on("click", ".excluirUsuarioGrupo", function() {
		var strHashIdGrupo = $(this).parent().find(".strHashIdGrupo").val();
		var strHashIdUsuario = $(this).parent().find(".strHashIdUsuario").val();
		if (confirm("Deseja EXCLUIR esse Usuario?")) {
			if ($.trim(strHashIdGrupo) != "" && $.trim(strHashIdUsuario) != "") {
				$.post("xt_excluirUsuarioGrupo.php", {"strHashIdGrupo" : strHashIdGrupo, "strHashIdUsuario" : strHashIdUsuario}, function(res) {
					exibirMensagem($("form#formCadastrarUsuarioGrupo").find("div.mensagem"), res.resposta, res.mensagem);
					if (res.resposta) {
						$("#listagemUsuarios").load("xt_listarUsuariosPorGrupo.php", {"strHashIdGrupo" : $("#strHashIdGrupo").val()});
					}
				}, "json");
			}
		}
	});
	
	// Validacao do Formulario de Cadastro
	$(document).on("submit", "form#formCadastrarUsuarioGrupo", function() {
		var objForm = $(this);
		
		if (validarFormulario($(objForm))) {
			// Limpando a mensagem
			exibirMensagem($(objForm).find("div.mensagem"), true, "");
			
			// Desativando o botao submit
			var objBotaoSubmit = $(objForm).find("input.submit").get(0);
			var nomeBotao = $(objBotaoSubmit).val();
			$(objBotaoSubmit).attr("disabled", "disabled");
			$(objBotaoSubmit).attr("value", "Enviando...");
			
			// Enviando os dados
			$.post($(objForm).attr("action"), $(objForm).serializeArray(), function(res, textStatus) {
				// Habilitando o botao submit
				$(objBotaoSubmit).val(nomeBotao);
				$(objBotaoSubmit).removeAttr("disabled");
				
				// Inicializando as variaveis
				var resposta = false;
				var mensagem = "";
				
				// Processando a resposta
				if (textStatus != "success") mensagem = "Ocorreu um erro de comunica&ccedil;&atilde;o com o servidor. Por favor, tente novamente.";
				else {
					mensagem = res.mensagem;
					if (res.resposta) resposta = true;
				}
				exibirMensagem($(objForm).find("div.mensagem"), resposta, mensagem);
				if (resposta && res.location.length > 0) location.href = res.location;
				if (resposta) $("#listagemUsuarios").load("xt_listarUsuariosPorGrupo.php", {"strHashIdGrupo" : $("#strHashIdGrupo").val()});
			}, "json");
		}
		return false;
	});
	
	// Listando os usuarios
	$("#listagemUsuarios").load("xt_listarUsuariosPorGrupo.php", {"strHashIdGrupo" : $("#strHashIdGrupo").val()});
});
function modificarPermissoesUsuario(strHashIdGrupo, strHashIdUsuario, bolFlagAdmin) {
	if ($.trim(strHashIdGrupo) != "" && $.trim(strHashIdUsuario) != "") {
		$.post("xt_modificarPermissoesUsuarioGrupo.php", {"strHashIdGrupo" : strHashIdGrupo, "strHashIdUsuario" : strHashIdUsuario, "bolFlagAdmin" : bolFlagAdmin}, function(res) {
			exibirMensagem($("form#formCadastrarUsuarioGrupo").find("div.mensagem"), res.resposta, res.mensagem);
			if (res.resposta) {
				$("#listagemUsuarios").load("xt_listarUsuariosPorGrupo.php", {"strHashIdGrupo" : $("#strHashIdGrupo").val()});
			}
		}, "json");
	}
}
