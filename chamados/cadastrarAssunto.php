<?php
// TODO Colocar um script (jQuery) com a conversão ao mudar a unidade de medida
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoAdmin();
	
	// Obtendo os dados da Sessão
	$intIdUsuario = (int) @$_SESSION["intIdUsuario"];
	
	// Obtendo os valores postados
	$strHashIdAssunto = (string) @$_GET["strHashIdAssunto"];
	$bolAtualizacao = false;
	if (!empty($strHashIdAssunto)) {
		// Validando o Hash
		$intIdAssunto = Encripta::decode($strHashIdAssunto, "listarAssuntos");
		if (!$intIdAssunto) throw new Exception("O ID do Assunto está inválido.");
		
		$bolAtualizacao = true;
		$objAssunto = $objFachadaBDR->procurarAssuntoPorIdAssunto($intIdAssunto);
		
		// Recuperando o SLA e convertendo para tempo e unidade
		$arrTempo = Util::converterMinutosParaTempo($objAssunto->getSla());
	}
	
	// Listando todos os Grupos Ativos administrados pelo Usuário
	$arrObjGrupo = $objFachadaBDR->listarGruposAtivosAdminPorIdUsuario($intIdUsuario);
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
<div id="corpo">
	<h2 class="titulo"><?php echo ($bolAtualizacao) ? "Editar" : "Adicionar"; ?> Assunto</h2>
	<div class="conteudo">
		<form id="formCadastrar" action="xt_cadastrarAssunto.php" method="post">
		<input type="hidden" name="strAcao" value="<?php echo ($bolAtualizacao) ? "atualizar" : "inserir"; ?>"/>
		<input type="hidden" name="strHashIdAssunto" value="<?php echo ($bolAtualizacao) ? $strHashIdAssunto : ""; ?>"/>
		<table cellspacing="1" cellpadding="3">
			<tr>
				<td width="100" class="escuro"><label for="intIdGrupo">Grupo</label></td>
				<td class="claro">
					<select name="intIdGrupo" id="intIdGrupo" class="texto obrigatorio">
						<option value="">-- Selecione o Grupo --</option>
<?php
foreach ($arrObjGrupo as $objGrupo) {
	if ($objGrupo->getFlagRecebeChamado()) {
?>
						<option value="<?php echo htmlentities($objGrupo->getIdGrupo()); ?>" <?php echo ($bolAtualizacao && $objGrupo->getIdGrupo() == $objAssunto->getIdGrupo()) ? 'selected="selected"' : ""; ?>><?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></option>
<?php
	}
}
?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="escuro"><label for="strDescricaoAssunto">Assunto</label></td>
				<td class="claro"><input type="text" name="strDescricaoAssunto" id="strDescricaoAssunto" class="texto obrigatorio" size="33" maxlength="50" value="<?php echo ($bolAtualizacao) ? htmlentities($objAssunto->getDescricaoAssunto()) : ""; ?>"/></td>
			</tr>
			<tr>
				<td class="escuro"><label for="intTempo">SLA</label></td>
				<td class="claro">
					<input type="text" name="intTempo" id="intTempo" maxlength="5" class="texto numero obrigatorio" size="3" value="<?php echo ($bolAtualizacao) ? htmlentities($arrTempo["tempo"]) : ""; ?>">
					<select name="strUnidade" id="strUnidade" class="texto obrigatorio">
						<option value="">-- Selecione a Unidade --</option>
<!--						<option value="D" <?php echo ($bolAtualizacao && $arrTempo["unidade"] == "D") ? 'selected="selected"' : ""; ?>>Dia(s)</option> -->
						<option value="H" <?php echo ($bolAtualizacao && $arrTempo["unidade"] == "H") ? 'selected="selected"' : ""; ?>>Hora(s)</option>
<!--						<option value="M" <?php echo ($bolAtualizacao && $arrTempo["unidade"] == "M") ? 'selected="selected"' : ""; ?>>Minuto(s)</option> -->
					</select>
				</td>
			</tr>
			<tr>
				<td class="escuro"><label for="strUrlChamadoExterno">URL Chamado Externo</label></td>
				<td class="claro"><input type="text" name="strUrlChamadoExterno" id="strUrlChamadoExterno" class="texto" size="60" maxlength="200" value="<?php echo ($bolAtualizacao) ? htmlentities($objAssunto->getUrlChamadoExterno()) : ""; ?>"/></td>
			</tr>
			<tr>
				<td class="escuro"><label for="strAlertaChamado">Mensagem de Alerta do Chamado</label></td>
				<!-- <td class="claro"><input type="text" name="strAlertaChamado" id="strAlertaChamado" class="texto" size="45" maxlength="200" value="<?php echo ($bolAtualizacao) ? htmlentities($objAssunto->getAlertaChamado()) : ""; ?>"/></td> -->
				<td class="claro"><textarea rows="5" cols="47" name="strAlertaChamado" id="strAlertaChamado" class="texto"><?php echo ($bolAtualizacao) ? htmlentities($objAssunto->getAlertaChamado()) : ""; ?></textarea></td>
			</tr>
			<tr>
				<td class="escuro"><label for="strFormatoChamado">Formato do Chamado</label></td>
				<td class="claro"><textarea rows="15" cols="47" name="strFormatoChamado" id="strFormatoChamado" class="texto"><?php echo ($bolAtualizacao) ? htmlentities($objAssunto->getFormatoChamado()) : ""; ?></textarea></td>
			</tr>
			<tr>
				<td colspan="2"><div class="mensagem">&nbsp;</div></td>
			</tr>
		</table>
		<input type="submit" class="botao submit" value="<?php echo ($bolAtualizacao) ? "Atualizar" : "Cadastrar"; ?> Assunto"/>
	</form>
	</div>
</div>
<div class="clear"></div>
<?php
// Include do rodapé
include("includes/incRodape.php");