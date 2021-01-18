$(document).ready(function(){
	// Atualizando o combobox dos assuntos
	$(document).on("change", "#intIdGrupoDestino", function() {
		// Carregando os assuntos do grupo
		$("#assuntos").load("xt_mostrarComboAssuntoPorGrupo.php", {"intIdGrupo" : $(this).val()});
	});
	
	// Atualizando a data de prazo
	$(document).on("change", ".comboAssuntos", function() {
		carregarDataPrazo();
		carregarFormatoChamado();
	});
	
	// Mostrando/ocultando o textarea da prioridade
	$(document).on("change", "#intCodigoPrioridade", function() {
		if ($(this).val() == 4) {
			$("#strJustificativaPrioridade").addClass("obrigatorio");
			$("#justificativaPrioridade").slideDown();
		}
		else {
			$("#strJustificativaPrioridade").removeClass("obrigatorio");
			$("#justificativaPrioridade").slideUp();
		}
	});
	
	// Verificação da descricao modificada
	$(document).on("change", "#strDescricaoChamado", function() {
		bolDescricaoModificada = true;
	});
	
	// Carregando os assuntos padroes
	$("#assuntos").load("xt_mostrarComboAssuntoPorGrupo.php");
	
	setTimeout(function(){$('#strArquivoAnexo').uploadifive({
		'uploadScript'		: 'xt_enviarArquivo.php',
		'buttonText'	: 'Enviar Arquivo',
		'width'			: 110,
		'auto'			: true,
		'multi'	: false,
		'queueID'		: 'strArquivoAnexo-queue',
		'onAddQueueItem' : function(file) {
			processaInicioUpload();
		},
		'onUploadComplete'	: function(file, data) {
			processaFimUpload(file, data);
		},
		'onCancel'		: function(file) {
			apagarArquivo();
		}
	})},0);
	
	// Carregando a data de prazo a cada 60 segundos
	setInterval("carregarDataPrazo()", 60000);
	
	// Validacao do Formulario de Cadastro
	$(document).on("submit", "form#formCadastrarChamado", function() {
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
				if (resposta) {
					$(objForm).get(0).reset();
					$("#strDataPrazo").html("");
					$("#strNomeArquivoAnexo").val("");
					$("#strCaminhoArquivoAnexo").val("");
					$("#strArquivoAnexo-queue").html("").show();
					$("#strJustificativaPrioridade").removeClass("obrigatorio");
					$("#justificativaPrioridade").slideUp();
				}
			}, "json");
		}
		return false;
	});
});

var bolDescricaoModificada = false;
function carregarFormatoChamado() {
	var intIdAssunto = $(".comboAssuntos").val();
	$.post("xt_carregarFormatoChamado.php", {"intIdAssunto" : intIdAssunto}, function(res, textStatus) {
		// Inicializando as variaveis
		var resposta = false;
		var mensagem = "";
		var alerta   = "";
		
		// Processando a resposta
		if (textStatus != "success") mensagem = "Ocorreu um erro de comunica&ccedil;&atilde;o com o servidor. Por favor, tente novamente.";
		else {
			mensagem = res.mensagem;
			alerta   = res.alerta;
			if (res.resposta) resposta = true;
		}
		if (resposta) {
			if (bolDescricaoModificada && confirm("A descrição informada do chamado será apagada. Deseja continuar?")) bolDescricaoModificada = false;
			if (!bolDescricaoModificada) {
				$("#strDescricaoChamado").val(mensagem);
				if (alerta.length > 1) alert(alerta);
			}
		}
		else {
			if (mensagem.length > 1) alert(mensagem);
		}
	}, "json");
}
function carregarDataPrazo() {
	var intIdAssunto = $(".comboAssuntos").val();
	var intIdGrupoDestino = $("#intIdGrupoDestino").val();
	if ($.trim(intIdAssunto) != "") {
		$("#strDataPrazo").load("xt_calcularDataPrazo.php", {"intIdGrupo" : intIdGrupoDestino, "intIdAssunto" : intIdAssunto});
	}
}