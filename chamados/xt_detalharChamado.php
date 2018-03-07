<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Recuperando os dados postados
	$strTipoListagem	= (string) @$_POST["strTipoListagem"];
	$strHashIdChamado	= (string) @$_POST["strHashIdChamado"];
	
	// Obtendo os dados
	$intIdUsuario = (int) @$_SESSION["intIdUsuario"];
	$bolRecebido = ($strTipoListagem == "recebidos") ? true : false;
	$bolEnviado = !$bolRecebido;
	$strListagem = ($bolRecebido) ? "listarChamadosRecebidos" : "listarChamadosEnviados"; 
	
	// Validando o identificador do chamado
	$intIdChamado = Encripta::decode($strHashIdChamado, $strListagem);
	if (!$intIdChamado) throw new Exception("O Identificador do Chamado está incorreto. Tente o acesso novamente.");
	
	// Recuperando os dados do chamado
	$objChamado = $objFachadaBDR->detalharChamado($intIdChamado);
	$arrObjEncaminhamento = $objFachadaBDR->listarEncaminhamentosPorIdChamado($intIdChamado);
	$arrObjHistorico = $objFachadaBDR->listarHistoricoPorIdChamadoOrdenadoRecentes($intIdChamado);
	
	// Calculando o destinatário
	$strDestinatario = $objChamado->getGrupoDestino()->getDescricaoGrupo() ." (Grupo)";
	if ($objChamado->getIdUsuarioDestino() != 0) $strDestinatario = $objChamado->getUsuarioDestino()->getNomeUsuario() ." (Individual)";
	
	// Listando todos os grupos
	$arrObjGrupo = $objFachadaBDR->listarGruposAtivosQueRecebemChamados();
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incErro.php");
	exit();
}

// Processando os dados do Encaminhamento
$arrDestinatarios = array();
foreach ($arrObjEncaminhamento as $objEncaminhamento) {
	$strDestinatarioTemp = $objEncaminhamento->getGrupoDestino()->getDescricaoGrupo();
	if ($objEncaminhamento->getIdUsuarioDestino() != 0) $strDestinatarioTemp = $objEncaminhamento->getUsuarioDestino()->getNomeUsuario();
	if (!empty($arrDestinatarios)) $arrDestinatarios[] = $objEncaminhamento->getUsuarioOrigem()->getNomeUsuario();
	$arrDestinatarios[] = $strDestinatarioTemp;
}

// Verificando se possui algum encaminhamento
if (!empty($arrDestinatarios) && count($arrDestinatarios) > 1) {
?>
<!-- Inicio do Encaminhamento -->
<div id="encaminhamentoChamado"><strong>Encaminhado:</strong> <?php echo htmlentities(implode(" » ", $arrDestinatarios)); ?></div>
<div class="clear"></div>
<?php
}
?>
<!-- Inicio dos Detalhes -->
<div id="detalhesChamado">
<div class="box">
	<div class="box_titulo escuro">Detalhes do Chamado</div>
	<div class="box_conteudo">
		<span class="claro">No. do Chamado</span><br/><?php echo htmlentities($objChamado->getIdChamado()); ?><br/><br/>
<?php
if (strlen(trim($objChamado->getCodigoChamadoExterno())) > 0) {
	if ($bolRecebido && strlen(trim($objChamado->getAssunto()->getUrlChamadoExterno())) > 0) {
?>
		<span class="claro">C&oacute;digo do Chamado Externo</span><br/><a href="<?php echo $objChamado->getAssunto()->getUrlChamadoExterno() . $objChamado->getCodigoChamadoExterno(); ?>" target="_blank"><?php echo htmlentities($objChamado->getCodigoChamadoExterno()); ?></a><br/><br/>
<?php
	}
	else {
?>
		<span class="claro">C&oacute;digo do Chamado Externo</span><br/><?php echo htmlentities($objChamado->getCodigoChamadoExterno()); ?><br/><br/>
<?php
	}
}
?>
		<span class="claro">Assunto</span><br/><?php echo htmlentities($objChamado->getAssunto()->getDescricaoAssunto()); ?><br/><br/>
		<span class="claro">Descri&ccedil;&atilde;o</span><br/>
		<div style="word-wrap:break-word;"><?php echo str_replace(array("\r\n", "\n"), "<br/>", htmlentities(rtrim($objChamado->getDescricaoChamado()))); ?><br/><br/></div>
		<span class="claro">Destino</span><br><?php echo htmlentities($strDestinatario); ?><br/><br/>
		<span class="claro">Prioridade</span><br/>
<?php
$arrPrioridades = Config::getPrioridades();
echo htmlentities($arrPrioridades[$objChamado->getCodigoPrioridade()]);
?>
		<br/><br/>
<?php
if ($objChamado->getCodigoPrioridade() == 4 && strlen(trim($objChamado->getJustificativaPrioridade())) > 0) {
?>
		<span class="claro">Justificativa da Prioridade</span><br/>
		<div style="word-wrap:break-word;"><span style="color:#FF0000;"><?php echo str_replace(array("\r\n", "\n"), "<br/>", htmlentities(rtrim($objChamado->getJustificativaPrioridade()))); ?></span><br/><br/></div>
<?php
}
?>
		<span class="claro">Data de Abertura</span><br/><?php echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objChamado->getDataAbertura()))); ?><br/><br/>
		<span class="claro">Prazo</span><br/><?php echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objChamado->getDataPrazo()))); ?><br/><br/>
<?php
if ($objChamado->getStatusChamado() == 2) {
?>
		<span class="claro">Data de Encerramento</span><br/><?php echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objChamado->getDataFechamento()))); ?><br/><br/>
		<span class="claro">Fechado Por</span><br/><?php echo htmlentities($objChamado->getUsuarioFechador()->getNomeUsuario()); ?><br/><br/>
<?php
}
?>
		<span class="claro">Aberto Por</span><br/><?php echo htmlentities($objChamado->getUsuarioOrigem()->getNomeUsuario()); ?><br/><br/>
		<span class="claro">Setor</span><br/><?php echo htmlentities(Util::formatarFrase($objChamado->getUsuarioOrigem()->getSetor()->getDescricaoSetor())); ?><br/><br/>
		<span class="claro">Ramal/Telefone</span><br/><?php echo htmlentities($objChamado->getUsuarioOrigem()->getRamal()); ?><br/><br/>
	</div>
</div>
</div>


<!-- Inicio do Historico -->
<div id="historicoChamado">


<?php
if ($bolEnviado || ($bolRecebido && $objChamado->getIdUsuarioOrigem() != $intIdUsuario && ($objChamado->getStatusChamado() == 1 || $objChamado->getStatusChamado() == 3))) {
?>
<!-- Início do Cadastro de Novo Histórico -->
<div class="box">
	<form id="formCadastrarHistorico" method="post" action="xt_cadastrarHistorico.php" enctype="multipart/form-data">
	<input type="hidden" name="strHashIdChamado" class="strHashIdChamado" value="<?php echo $strHashIdChamado; ?>"/>
	<input type="hidden" name="strTipoListagem" class="strTipoListagem" value="<?php echo $strTipoListagem; ?>"/>
	<div class="box_titulo escuro">Novo Hist&oacute;rico</div>
	<div class="box_conteudo" style="padding:10px;">
		<div style="margin:0 auto;width:400px;">
			<div>
				<textarea rows="10" cols="47" name="strDescricaoHistorico" class="texto obrigatorio"></textarea>
			</div>
<?php
	if ($bolRecebido && $objChamado->getIdUsuarioOrigem() != $intIdUsuario && ($objChamado->getStatusChamado() == 1 || $objChamado->getStatusChamado() == 3)) {
?>
			<div style="padding-top:10px">
				C&oacute;d. Chamado Externo:
				<input type="text" id="strCodigoChamadoExterno" name="strCodigoChamadoExterno" size="28" maxlength="50" />
			</div>
<?php
	}
?>
			
			<div style="padding-top:10px">
				<input type="file" name="strArquivoAnexo" id="strArquivoAnexo"/>
				<div class="clear"></div>
				<input type="hidden" id="strNomeArquivoAnexo" name="strNomeArquivoAnexo">
				<input type="hidden" id="strCaminhoArquivoAnexo" name="strCaminhoArquivoAnexo">
			</div>
<?php
	if ($objChamado->getStatusChamado() == 1 || $objChamado->getStatusChamado() == 3) {
?>
			<div align="center" style="padding-top:10px;">
				<input type="radio" name="strAcaoChamado" id="strAcaoChamadoNenhuma" value="nenhuma" checked="checked"/><label for="strAcaoChamadoNenhuma">Continuar aberto</label>
<?php
		if ($bolRecebido) {
?>
				<input type="radio" name="strAcaoChamado" id="strAcaoChamadoFechar" value="fechar"/><label for="strAcaoChamadoFechar">Fechar</label>
<?php
		}
		else {
?>
				<input type="radio" name="strAcaoChamado" id="strAcaoChamadoCancelar" value="cancelar"/><label for="strAcaoChamadoCancelar">Cancelar</label>
<?php
		}
?>
			</div>
<?php
	}
	else {
?>
			<input type="hidden" name="strAcaoChamado" value="reabrir"/>
<?php
	}
?>
			<div class="mensagem" style="padding-top:10px;">&nbsp;</div>
			<div align="center" style="padding-top:10px;">
<?php
	if ($objChamado->getStatusChamado() == 1 || $objChamado->getStatusChamado() == 3) {
?>
				<input type="submit" value="Cadastrar" class="botao submit"/>
<?php
		if ($bolRecebido) {
?>
				<input type="button" value="Encaminhar" class="botao" id="btn_encaminhar"/>
				<input type="button" value="Reclassificar" class="botao" id="btn_reclassificar"/>
<?php
		}
	}
	else {
?>
				<input type="submit" value="Reabrir Chamado" class="botao submit"/>
<?php
	}
?>
			</div>
		</div>
	</div>
	</form>
</div>


<?php
	if ($bolRecebido) {
?>
<!-- Início do Cadastro do Encaminhamento -->
<div id="encaminharChamado" class="box" style="display:none">
	<form id="formEncaminharChamado" method="post" action="xt_encaminharChamado.php">
	<input type="hidden" name="strHashIdChamado" class="strHashIdChamado" value="<?php echo $strHashIdChamado; ?>"/>
	<input type="hidden" name="strTipoListagem" class="strTipoListagem" value="<?php echo $strTipoListagem; ?>"/>
	<input type="hidden" class="intIdAssunto" value="<?php echo $objChamado->getIdAssunto(); ?>"/>
	<div class="box_titulo escuro">Encaminhar Chamado</div>
	<div class="box_conteudo" style="padding:10px;">
		<div style="margin:0 auto;width:310px;">
			<select name="intIdGrupoDestino" class="obrigatorio intIdGrupoDestino" style="width:310px;">
				<option value="">-- Selecione o Grupo --</option>
<?php
		foreach ($arrObjGrupo as $objGrupo) {
?>
				<option value="<?php echo htmlentities($objGrupo->getIdGrupo()); ?>"><?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></option>
<?php
		}
?>
			</select>
			<div id="encaminharChamado_assuntos" style="padding-top:5px;"></div>
			<div style="padding-top:5px;"><input type="checkbox" id="bolEspecificar" value="true"><label for="bolEspecificar">Especificar usu&aacute;rio</label></div>
			<div id="encaminharChamado_usuarios" style="padding-top:5px;"></div>
		</div>
		<div class="mensagem" style="padding-top:5px;">&nbsp;</div>
		<div align="center" style="padding-top:10px;">
			<div align="center" style="width:50%;float:left;"><input type="submit" value="Encaminhar" class="botao submit"/></div>
			<div align="center" style="width:50%;float:right;"><input type="button" value="Cancelar" class="botao" id="btn_cancelarEncaminhamento"/></div>
			<div class="clear"></div>
		</div>
	</div>
	</form>
</div>


<!-- Início da Reclassificação do Chamado -->
<div id="reclassificarChamado" class="box" style="display:none">
	<form id="formReclassificarChamado" method="post" action="xt_reclassificarChamado.php">
	<input type="hidden" name="strHashIdChamado" class="strHashIdChamado" value="<?php echo $strHashIdChamado; ?>"/>
	<input type="hidden" name="strTipoListagem" class="strTipoListagem" value="<?php echo $strTipoListagem; ?>"/>
	<input type="hidden" class="intIdGrupoDestino" value="<?php echo $objChamado->getIdGrupoDestino(); ?>"/>
	<input type="hidden" class="strDataAbertura" value="<?php echo $objChamado->getDataAbertura(); ?>"/>
	<div class="box_titulo escuro">Reclassificar Chamado</div>
	<div class="box_conteudo" style="padding:10px;">
		<div style="margin:0 auto;width:400px;">
			<table cellspacing="1" cellpadding="3">
				<tr>
					<td class="claro">Assunto</td>
					<td><div id="reclassificarChamado_assuntos"></div></td>
				</tr>
				<tr>
					<td class="claro"><label for="intCodigoPrioridade">Prioridade</label></td>
					<td>
						<select name="intCodigoPrioridade" id="intCodigoPrioridade" class="obrigatorio">
							<option value="">-- Selecione a Prioridade --</option>
<?php
		$arrPrioridades = Config::getPrioridades();
		foreach ($arrPrioridades as $intCodigoPrioridade => $strDescricaoPrioridade) {
?>
							<option value="<?php echo $intCodigoPrioridade; ?>" <?php if ($objChamado->getCodigoPrioridade() == $intCodigoPrioridade) echo 'selected="selected"';?>><?php echo htmlentities($strDescricaoPrioridade); ?></option>
<?php
		}
?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="claro"><label for="intStatus">Status</label></td>
					<td>
						<select name="intStatus" id="intStatus" class="obrigatorio">
							<option value="1">Normal (Aberto)</option>
							<option value="3">Pendente</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="claro">Prazo</td>
					<td><span id="strDataPrazo" style="font-weight:bold;"></span></td>
				</tr>
			</table>
		</div>
		<div class="mensagem" style="padding-top:5px;">&nbsp;</div>
		<div align="center" style="padding-top:10px;">
			<div align="center" style="width:50%;float:left;"><input type="submit" value="Reclassificar" class="botao submit"/></div>
			<div align="center" style="width:50%;float:right;"><input type="button" value="Cancelar" class="botao" id="btn_cancelarReclassificacao"/></div>
			<div class="clear"></div>
		</div>
	</div>
	</form>
</div>
<?php
	}
}
?>


<div class="box">
	<div class="box_titulo escuro">Hist&oacute;rico do Chamado</div>
<?php 
foreach ($arrObjHistorico as $objHistorico) {
	$strClassHistorico = "";
	switch ($objHistorico->getTipoHistorico()) {
		case 1: 
		case 3:
		case 5: $strClassHistorico = "hst_normal"; break;
//		case 7: $strClassHistorico = "hst_leitura"; break;
	}
?>
	<div class="box_conteudo <?php echo $strClassHistorico; ?>">
		<div style="float:left;"><span class="claro">Cadastrado por</span> <?php echo htmlentities($objHistorico->getUsuario()->getNomeUsuario()); ?></div>
		<div style="float:right;"><span class="claro">Data</span> <?php echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($objHistorico->getDataHistorico()))); ?></div>
		<div class="clear"></div><br/>
		<div style="word-wrap:break-word;">
		<?php echo str_replace(array("\r\n","\n"), "<br/>", htmlentities(rtrim($objHistorico->getDescricaoHistorico()))); ?><br/>
<?php
	if (strlen(trim($objHistorico->getCaminhoArquivoAnexo())) > 0 && strlen(trim($objHistorico->getNomeArquivoAnexo())) > 0) {
		$intIdHistorico = $objHistorico->getIdHistorico();
		$strHashIdHistorico = Encripta::encode($intIdHistorico, "downloadAnexo");
		$strCaminhoArquivoAnexo = Config::getCaminhoArquivosAnexos() ."/". $objHistorico->getCaminhoArquivoAnexo();
		$arrTamanhoArquivoAnexo = Util::formatarBytes(filesize($strCaminhoArquivoAnexo));
		$strTamanhoArquivoAnexo = number_format($arrTamanhoArquivoAnexo[0], 1, ',', '.') . $arrTamanhoArquivoAnexo[1];
?>
		<br/>
		<strong>Anexo: </strong><a href="download.php?strHashIdHistorico=<?php echo urlencode($strHashIdHistorico); ?>" target="_blank"><?php echo htmlentities($objHistorico->getNomeArquivoAnexo()); ?></a> <strong>(<?php echo $strTamanhoArquivoAnexo; ?>)</strong><br/>
<?php
	}
?>
		</div>
		<br/>
	</div>
<?php
}
?>
</div>

</div>
<div class="clear"></div>

<script type="text/javascript">
jQuery("#encaminharChamado_assuntos").load("xt_mostrarComboAssuntoPorGrupo.php");
jQuery("#reclassificarChamado_assuntos").load("xt_mostrarComboAssuntoPorGrupo.php", {"intIdGrupo" : <?php echo $objChamado->getIdGrupoDestino();?>, "intIdAssunto" : <?php echo $objChamado->getIdAssunto();?>});
setTimeout(function(){jQuery('#strArquivoAnexo').uploadify({
	'swf'			: 'imagens/uploadify.swf',
	'uploader'		: 'xt_enviarArquivo.php',
	'buttonText'	: 'Enviar Arquivo',
	'removeTimeout' : 0,
	'width'			: 110,
	'auto'			: true,
	'onSelect'		: function(file) {
		processaInicioUpload();
	},
	'onUploadSuccess'	: function(file, data, response) {
		var retorno = jQuery.parseJSON(data);
		processaFimUpload(retorno);
	}
})},0);
</script>
