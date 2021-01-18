$(document).ready(function(){
	$(document).on("click", ".chm_item", function() {
		$("div#listaChamados").find(".chm_item").each(function(){
			$(this).removeClass("chm_selecionado");
		});
		$(this).addClass("chm_selecionado");
		
		// Carregando os dados do chamado
		$("#detalhamentoChamado").load(
			"xt_detalharChamado.php",
			{"strTipoListagem" : $("#strTipoListagem").val(), "strHashIdChamado" : $(this).find(".strHashIdChamado").val()},
			function() {
				$.scrollTo($("#detalhamentoChamado"), 500);
			}
		);
	});
	
	// Adicionando a tarja verde sobre os chamados
	$(document).on("mouseenter", ".chm_item", function() {
		$(this).addClass("chm_hover");
	});
	$(document).on("mouseleave", ".chm_item", function() {
		$(this).removeClass("chm_hover");
	});
	
	// Validacao do Formulario
	$(document).on("submit", "form#formFiltro", function() {
		var objForm = $(this);
		
		// Desativando o botao submit
		var objBotaoSubmit = $(objForm).find("input.submit").get(0);
		$(objBotaoSubmit).attr("disabled", "disabled");
		
		$("div#listaChamados").html('<h3 align="center">Carregando chamados...</h3>');
		
		// Enviando os dados
		$.post($(objForm).attr("action"), $(objForm).serializeArray(), function(res, textStatus) {
			// Habilitando o botao submit
			$(objBotaoSubmit).removeAttr("disabled");
			
			if (textStatus != "success") {
				$("div#listaChamados").html('<h3>Ocorreu um erro de comunica&ccedil;&atilde;o com o servidor. Por favor, tente novamente.</h3>');
			}
			else {
				$("div#listaChamados").html(res);
			}
		});
		return false;
	});
	
	// Validacao do Formulario de Cadastro
	$(document).on("submit", "form#formCadastrarHistorico, form#formEncaminharChamado, form#formReclassificarChamado", function() {
		var objForm = $(this);
		
		if (validarFormulario($(objForm))) {
			// Verificando se o usuario deseja fechar o chamado
			if ($(objForm).find("#strAcaoChamadoFechar").length > 0) {
				if ($(objForm).find("#strAcaoChamadoFechar").prop("checked")) {
					if (!confirm("Deseja FECHAR este chamado?")) return false;
				}
			}
			
			// Verificando se o usuario deseja cancelar o chamado
			if ($(objForm).find("#strAcaoChamadoCancelar").length > 0) {
				if ($(objForm).find("#strAcaoChamadoCancelar").prop("checked")) {
					if (!confirm("Deseja CANCELAR este chamado?")) return false;
				}
			}
			
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
				if (resposta) $("#detalhamentoChamado").load("xt_detalharChamado.php", {"strTipoListagem" : $("#strTipoListagem").val(), "strHashIdChamado" : $(objForm).find(".strHashIdChamado").val()});
			}, "json");
		}
		return false;
	});
	
	// Exibindo o encaminhamento
	$(document).on("click", "#btn_encaminhar", function(){
		$("#reclassificarChamado").slideUp();
		$("#encaminharChamado").slideDown();
	});
	
	// Cancelando o encaminhamento
	$(document).on("click", "#btn_cancelarEncaminhamento", function() {
		$("#encaminharChamado").slideUp(function() {
			var objForm = $("#encaminharChamado").find("form");
			exibirMensagem($(objForm).find("div.mensagem"), true, "");
			$(objForm).find(".obrigatorio").each(function() {
				markAsNoError($(this));
			});
			$(objForm).get(0).reset();
			$("#usuarioPorGrupo").html("");
		});
	});
	
	// Especificando usuario do encaminhamento
	$(document).on("click", "#bolEspecificar", function() {
		validarEncaminhamento($(this).parents("form"));
	});
	
	// Alterando o grupo do encaminhamento
	$(document).on("change", "#encaminharChamado .intIdGrupoDestino", function() {
		var objForm = $(this).parents("form");
		var intIdAssunto = $(objForm).find(".intIdAssunto").val();
		validarEncaminhamento(objForm);
		$("#encaminharChamado_assuntos").load("xt_mostrarComboAssuntoPorGrupo.php", {"intIdGrupo" : $(this).val(), "intIdAssunto" : intIdAssunto});
	});
	
	// Exibindo a reclassificacao
	$(document).on("click", "#btn_reclassificar", function(){
		carregarDataPrazo();
		$("#encaminharChamado").slideUp();
		$("#reclassificarChamado").slideDown();
	});
	
	// Cancelando a reclassificacao
	$(document).on("click", "#btn_cancelarReclassificacao", function() {
		$("#reclassificarChamado").slideUp(function() {
			var objForm = $("#reclassificarChamado").find("form");
			exibirMensagem($(objForm).find("div.mensagem"), true, "");
			$(objForm).find(".obrigatorio").each(function() {
				markAsNoError($(this));
			});
			$(objForm).get(0).reset();
			$("#strDataPrazo").html("");
		});
	});
	
	// Atualizando a data de prazo
	$(document).on("change", "#reclassificarChamado .comboAssuntos", function() {
		carregarDataPrazo();
	});
	
	// Carregando o formulario ao entrar na pagina
	$("#formFiltro").submit();
});
function validarEncaminhamento(objForm) {
	// Limpando os campos
	exibirMensagem($(objForm).find("div.mensagem"), true, "");
	$("#encaminharChamado_usuarios").html("");
	if ($("#bolEspecificar").prop("checked")) {
		var intIdGrupoDestino = $.trim($(objForm).find(".intIdGrupoDestino").val());
		if (intIdGrupoDestino == "") exibirMensagem($(objForm).find("div.mensagem"), false, "Selecione um grupo antes de especificar o usuario.");
		else $("#encaminharChamado_usuarios").load("xt_mostrarComboUsuariosPorGrupo.php", {"intIdGrupoDestino": intIdGrupoDestino}).show();
	}
}
function listar(intOffSet){
	if($.trim(intOffSet) != ""){
		$("#intOffSet").attr("value", intOffSet);
		$("div#listaChamados").load("xt_listarChamados.php", $("#formListagem").serializeArray());
	}
}
function carregarDataPrazo() {
	var intIdAssunto = $("#reclassificarChamado .comboAssuntos").val();
	var intIdGrupoDestino = $("#reclassificarChamado .intIdGrupoDestino").val();
	var strDataAbertura = $("#reclassificarChamado .strDataAbertura").val();
	if ($.trim(intIdAssunto) != "") {
		$("#strDataPrazo").load("xt_calcularDataPrazo.php", {"intIdGrupo" : intIdGrupoDestino, "intIdAssunto" : intIdAssunto, "strDataAbertura" : strDataAbertura});
	}
}