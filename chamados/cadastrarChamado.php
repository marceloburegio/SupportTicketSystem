<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Listando todos os grupos
	$arrObjGrupo = $objFachadaBDR->listarGruposAtivosQueRecebemChamados();
	
	// Desabilitando o Balão do Novo Chamado (informações)
	$_SESSION["bolBalaoNovoChamado"] = false;
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incTopo.php");
	include("includes/incErro.php");
	include("includes/incRodape.php");
	exit();
}

// Include do topo
include("includes/incTopo.php");
?>
<script type="text/javascript" src="js/cadastrarChamado.js?v=<?php echo filemtime("js/cadastrarChamado.js"); ?>"></script>

<div id="corpo">
	<h2 class="titulo">Novo Chamado</h2>
	<div class="conteudo">
		<div style="float:left;">
		<form id="formCadastrarChamado" action="xt_cadastrarChamado.php" method="post" enctype="multipart/form-data">
		<table cellspacing="1" cellpadding="3">
			<tr>
				<td class="escuro"><label for="intIdGrupoDestino">Destinat&aacute;rio</label></td>
				<td class="claro">
					<select name="intIdGrupoDestino" id="intIdGrupoDestino" class="obrigatorio">
						<option value="">-- Selecione o Grupo --</option>
<?php
foreach ($arrObjGrupo as $objGrupo) {
?>
						<option value="<?php echo htmlentities($objGrupo->getIdGrupo()); ?>"><?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></option>
<?php
}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="130" class="escuro"><label for="intIdAssunto">Assunto</label></td>
				<td class="claro"><div id="assuntos"></div></td>
			</tr>
			<tr>
				<td class="escuro"><label for="strEmailCopia">E-mails Adicionais:</label></td>
				<td class="claro"><input type="text" id="strEmailCopia" name="strEmailCopia" size="45" class="texto"></td>
			</tr>
			<tr>
				<td class="escuro"><label for="strDescricaoChamado">Descri&ccedil;&atilde;o</label></td>
				<td class="claro"><textarea rows="10" cols="47" name="strDescricaoChamado" id="strDescricaoChamado" class="texto obrigatorio"></textarea></td>
			</tr>
			<tr>
				<td class="escuro"><label for="intCodigoPrioridade">Prioridade</label></td>
				<td class="claro">
					<select name="intCodigoPrioridade" id="intCodigoPrioridade" class="obrigatorio">
						<option value="">-- Selecione a Prioridade --</option>
<?php
$arrPrioridades = Config::getPrioridades();
foreach ($arrPrioridades as $intCodigoPrioridade => $strDescricaoPrioridade) {
?>
						<option value="<?php echo $intCodigoPrioridade; ?>"><?php echo $strDescricaoPrioridade; ?></option>
<?php
}
?>
					</select><br/>
					<div id="justificativaPrioridade" style="display:none;">
						<br/>
						<font color="#FF0000"><strong>Qual a sua justificativa para a Urg&ecirc;ncia:</strong></font><br/>
						<textarea rows="6" cols="40" name="strJustificativaPrioridade" id="strJustificativaPrioridade"></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td class="escuro">Arquivo Anexo<br/>(apenas um)</td>
				<td class="claro" style="height:40px; width:375px;">
					<div class="uploadifive">
						<div class="uploadifive-queue" id="strArquivoAnexo-queue"></div>
						<input type="file" name="strArquivoAnexo" id="strArquivoAnexo"/>
					</div>
					<div class="clear"></div>
					<input type="hidden" id="strNomeArquivoAnexo" name="strNomeArquivoAnexo">
					<input type="hidden" id="strCaminhoArquivoAnexo" name="strCaminhoArquivoAnexo">
				</td>
			</tr>
			<tr>
				<td class="escuro">Prazo (Previs&atilde;o)</td>
				<td class="claro"><span id="strDataPrazo" style="font-weight:bold;"></span></td>
			</tr>
			<tr>
				<td colspan="2"><div class="mensagem">&nbsp;</div></td>
			</tr>
		</table>
		<input type="submit" class="botao submit" value="Cadastrar Chamado"/>
	</form>
	</div>
	<div style="float:left;width:350px;line-height:150%;">
		<h3 align="center">Informa&ccedil;&otilde;es sobre as Prioridades</h3>
		<ul>
			<li><strong>Baixa</strong> - Para ocorr&ecirc;ncias que n&atilde;o possuem impacto nos processos/rotinas ou d&uacute;vidas</li>
			<li><strong>Normal</strong> - Para ocorr&ecirc;ncias que possuem algum impacto mas podem aguardar pois existe possibilidade de contorno</li>
			<li><strong>Alta</strong> - Para ocorr&ecirc;ncias que s&atilde;o cr&iacute;ticas, mas que n&atilde;o impactam diretamente no neg&oacute;cio. Existem possibilidades de contorno por&eacute;m s&atilde;o complexas e/ou dif&iacute;ceis</li>
			<li><strong>Urgente</strong> - Para ocorr&ecirc;ncias que s&atilde;o cr&iacute;ticas, que impactam diretamente no neg&oacute;cio e n&atilde;o possuem nenhuma possibilidade de contorno. Para utilizar esta prioridade uma Justificativa &eacute; obrigat&oacute;ria</li>
		</ul>
	</div>
	<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
<?php
// Include do rodapé
include("includes/incRodape.php");