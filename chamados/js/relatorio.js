$(document).ready(function(){
	// Validacao do Formulario
	$(document).on("submit", "form#formRelatorio", function() {
		var objForm = $(this);
		
		if (validarFormulario($(objForm))) {
			// Limpando a mensagem
			exibirMensagem($(objForm).find("div.mensagem"), true, "");
			
			// Desativando o botao submit
			var objBotaoSubmit = $(objForm).find("input.submit");
			var nomeBotao = $(objBotaoSubmit).val();
			$(objBotaoSubmit).attr("disabled", "disabled");
			$(objBotaoSubmit).attr("value", "Enviando...");
			
			// Enviando os dados
			$.post($(objForm).attr("action"), $(objForm).serializeArray(), function(res, textStatus) {
				// Habilitando o botao submit
				$(objBotaoSubmit).val(nomeBotao);
				$(objBotaoSubmit).removeAttr("disabled");
				
				// Processando a resposta
				if (textStatus != "success") res = '<h3>Ocorreu um erro de comunica&ccedil;&atilde;o com o servidor. Por favor, tente novamente.</h3>';
				$("div#relatorio").html(res);
			});
		}
		return false;
	});
	
	// Efetuando o submit inicial
	$("#formRelatorio").submit();
});