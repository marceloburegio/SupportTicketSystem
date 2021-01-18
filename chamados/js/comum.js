$(document).ready(function(){
	// Loading ...
	$(document).ajaxStart(function() { $("#loading").show(); });
	$(document).ajaxStop(function() { $("#loading").fadeOut("slow"); });
	
	// Menu Horizontal
	$(document).on("mouseenter", ".menu_horizontal > li", function(){
		$(this).find("ul").show();
	});
	$(document).on("mouseleave", ".menu_horizontal > li", function(){
		$(this).find("ul").hide();
	});
	
	// Calendario
	$.datepicker.setDefaults($.extend({showMonthAfterYear: false}, $.datepicker.regional["pt-BR"]));
	$(document).on("click", "input.calendario", function() {
		$(this).datepicker({showOn:"focus"}).focus();
	});
	$(document).on("keyup", "input.calendario", function() {
		var calendario = $(this).val();
		calendario = calendario.replace(/\//g, '');
		calendario = calendario.replace(/[^0-9]/g, '');
		if (calendario.length > 4) calendario = calendario.substring(0,2) +'/'+ calendario.substring(2,4) +'/'+ calendario.substring(4);
		else if (calendario.length > 2) calendario = calendario.substring(0,2) +'/'+ calendario.substring(2);
		$(this).val(calendario);
	});
	
	// Colocando o focus do input
	$(document).on("focus", "input.texto", function() {
		$(this).addClass("asfocused");
	});
	$(document).on("blur", "input.texto", function() {
		$(this).removeClass("asfocused");
	});
	
	// Colocando o focus no botao
	$(document).on("mouseenter", "input.botao", function() {
		$(this).addClass("botaoAsFocused");
	});
	$(document).on("mouseleave", "input.botao", function() {
		$(this).removeClass("botaoAsFocused");
	});
	
	// Removendo os campos vermelhos da validacao
	$(document).on("change", ".obrigatorio", function () {
		if ($(this).get(0).tagName == "INPUT") {
			if ($(this).attr("type") == "radio") {
				var bolSpanExists = ($(this).parents("span.validacao").length > 0);
				if (bolSpanExists) markAsNoError($(this).parents("span.validacao"));
				return true;
			}
		}
		checkIsEmptyField($(this));
	});
	
	// Mascara automatica para campos numericos
	$(document).on("keyup", ".numero", function() {
		// Removendo os caracteres invalidos
		$(this).val($(this).val().replace(/[^0-9]/g, ""));
	});
	
	// Validacao para campos Senha
	$(document).on("change", ".senha", function () {
		if (!validarSenha($(this).val())) markAsError($(this));
		else markAsNoError($(this));
	});
	
	// Validacao do Formulario de Cadastro
	$(document).on("submit", "form#formAutenticar, form#formCadastrar", function() {
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
				//if (resposta) $(objForm).get(0).reset();
			}, "json");
		}
		return false;
	});
});

/**
 * Funcao que valida todos os campos obrigatorios do formulario
 */
function validarFormulario(objForm) {
	var bolIsFocus = true;
	var bolIsValid = true;
	var strMensagem = "";
	var bolObrigatorio = false;
	var bolCpfInvalido = false;
	var bolSenhaInvalida = false;
	
	$(objForm).find(".obrigatorio").each(function() {
		if (checkIsEmptyField($(this))) {
			bolIsValid = false;
			if (bolIsFocus) {
				$(this).focus();
				bolIsFocus = false;
			}
			if (!bolObrigatorio) {
				if (strMensagem != "") strMensagem += "\r\n";
				strMensagem += "Os campos em destaque s&atilde;o obrigat&oacute;rios.";
				bolObrigatorio = true;
			}
		}
	});
	
	// Validando os campos Senha, caso existam
	$(objForm).find(".senha").each(function() {
		if (!validarSenha($(this).val())) {
			markAsError($(this));
			bolIsValid = false;
			if (bolIsFocus) {
				$(this).focus();
				bolIsFocus = false;
			}
			if (!bolSenhaInvalida) {
				if (strMensagem != "") strMensagem += "\r\n";
				strMensagem += "A Senha informada n&atilde;o pode conter espa&ccedil;os e deve ser maior de 6 caracteres.";
				bolSenhaInvalida = true;
			}
		}
		else markAsNoError($(this));
	});
	
	// Validando todos os campos radios, caso existam
	var radios = [];
	$(objForm).find(".obrigatorio:radio").each(function() {
		// Verificando se existe algum radio com o mesmo nome selecionado
		radios[ $(this).attr("name") ] = ($(objForm).find(".obrigatorio[name="+ $(this).attr("name") +"]:checked").length > 0) ? true : false;
	});
	
	// Se o radio nao estiver selecionado, defini-lo como erro, caso contrario remover o erro
	for(nome in radios) {
		if ($(this).find(".obrigatorio[name="+ nome +"]:radio").length > 0) {
			var radio = $(this).find(".obrigatorio[name="+ nome +"]:radio").get(0);
			var bolSpanExists = ($(radio).parents("span.validacao").length > 0);
			if (!radios[nome]) {
				if (bolSpanExists) markAsError($(radio).parents("span.validacao"));
				bolIsValid = false;
				if (bolIsFocus) {
					if (bolSpanExists) $(radio).parents("span.validacao").focus();
					bolIsFocus = false;
				}
				if (!bolObrigatorio) {
					if (strMensagem != "") strMensagem += "\r\n";
					strMensagem += "Os campos em destaque s&atilde;o obrigat&oacute;rios.";
					bolObrigatorio = true;
				}
			}
			else {
				if (bolSpanExists) markAsNoError($(radio).parents("span.validacao"));
			}
		}
	}
	// Mostrando mensagens para serem exibidas
	if (!bolIsValid) exibirMensagem($(objForm).find("div.mensagem"), false, strMensagem);
	return bolIsValid;
}

/**
 * Funcoes Utilitarias
 */
function validarSenha(strSenha) {
	if (strSenha.replace(/\s/g, "") != strSenha) return false;
	if (strSenha.length < 6) return false;
	return true;
}
function markAsError(obj) {
	$(obj).next("span.erro").remove();
	$(obj).after("<span class=\"erro\" style=\"font-family:Verdana;font-size:16px;\"></span>");
	$(obj).addClass("erro");
	//if ($(obj).get(0).tagName != "SELECT" ) $(obj).css({"padding": "2px"});
}
function markAsNoError(obj) {
	$(obj).next("span.erro").remove();
	$(obj).removeClass("erro");
}
function checkIsEmptyField(obj) {
	if ($(obj).val() == "" || $(obj).val() == null) {
		markAsError(obj);
		return true;
	}
	else {
		markAsNoError(obj);
		return false;
	}
}
function exibirMensagem(obj, resposta, mensagem) {
	if (mensagem.length == 0) mensagem = "&nbsp;";
	mensagem = mensagem.replace("\n", "<br/>");
	classe = (resposta) ? "sucesso" : "erro";
	mensagem = "<div class=\""+ classe +"\">"+ mensagem +"</div>";
	$(obj).html(mensagem);
}
/* Formata um numero float no estilo */
function numberFormat(floNum) {
	return RComma(floNum.toFixed(2).toString().replace('.',','));
}
function RComma(S) {
	S = String(S);
	var RgX = /^(.*\s)?([-+\u00A3\u20AC]?\d+)(\d{3}\b)/;
	return S == (S = S.replace(RgX, "$1$2.$3")) ? S : RComma(S);
}
/* ***********************
 *   FUNCOES DE UPLOAD 
 * ***********************/
function processaFimUpload(file, data) {
	var res = $.parseJSON(data);
	if (!res.resposta) alert(res.mensagem);
	else {
		// Atribuindo os nome e o caminho do arquivo aos inputs hidden
		$("#strNomeArquivoAnexo").attr("value", res.strNomeArquivo);
		$("#strCaminhoArquivoAnexo").attr("value", res.strCaminhoArquivo);
		
		// Atualizando a div que exibirá o tamanho do arquivo
		file.queueItem.find('.fileinfo').html(' ('+ formataTamanhoArquivo(res.intTamanhoArquivo) +')');
	}
}
function processaInicioUpload() {
	// Se o usuario ja tinha feito um upload anterior, apagar o arquivo anterior antes de realizar o novo upload
	if ($("#strArquivoAnexo-queue").children().length > 1) {
		$("#strArquivoAnexo-queue").children().first().find(".close").click();
	}
}
/**
 * Metodo que ira apagar o arquivo em anexo
 * @return void
 */
function apagarArquivo() {
	if ($("#strCaminhoArquivoAnexo").val() != "") {
		$.post("xt_apagarArquivo.php", {"strCaminhoArquivoAnexo" : $("#strCaminhoArquivoAnexo").val()});
	}
}
/**
 * 
 * @param intTamanho
 * @return String
 */
function formataTamanhoArquivo(intTamanho){
	var byteSize = Math.round(intTamanho / 1024 * 100) / 100;
	var suffix = 'KB';
	if (byteSize > 1024) {
		byteSize = Math.round(byteSize / 1024 * 100) / 100;
		suffix = 'MB';
	}
	return byteSize + " " + suffix;
}