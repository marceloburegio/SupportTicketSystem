<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoAdmin();
	
	// Obtendo os valores postados
	$bolSuperAdmin	= (boolean) @$_SESSION["bolSuperAdmin"];
	$strHashIdGrupo	= (string) @$_GET["strHashIdGrupo"];
	$bolAtualizacao = false;
	if (!empty($strHashIdGrupo)) {
		// Validando o Hash
		$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarGrupos");
		if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
		
		$bolAtualizacao = true;
		$objGrupo = $objFachadaBDR->procurarGrupo($intIdGrupo);
	}
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
	<h2 class="titulo"><?php echo ($bolAtualizacao) ? "Editar" : "Adicionar"; ?> Grupo</h2>
	<div class="conteudo">
		<form id="formCadastrar" action="xt_cadastrarGrupo.php" method="post">
		<input type="hidden" name="strAcao" value="<?php echo ($bolAtualizacao) ? "atualizar" : "inserir"; ?>"/>
		<input type="hidden" name="strHashIdGrupo" value="<?php echo ($bolAtualizacao) ? $strHashIdGrupo : ""; ?>"/>
<?php
if (!$bolSuperAdmin) {
?>
		<input type="hidden" name="bolRecebeChamado" value="<?php echo ($bolAtualizacao && $objGrupo->getFlagRecebeChamado()) ? "true" : "false"; ?>"/>
<?php
}
?>
		<table cellspacing="1" cellpadding="3">
			<tr>
				<td width="130" class="escuro"><label for="strDescricaoGrupo">Nome do Grupo</label></td>
				<td class="claro"><input type="text" name="strDescricaoGrupo" id="strDescricaoGrupo" size="25" maxlength="50" class="texto obrigatorio" value="<?php echo ($bolAtualizacao) ? htmlentities($objGrupo->getDescricaoGrupo()) : ""; ?>"/></td>
			</tr>
			<tr>
				<td class="escuro"><label for="strEmailGrupo">Email do Grupo</label></td>
				<td class="claro"><input type="text" name="strEmailGrupo" id="strEmailGrupo" size="25" maxlength="100" class="texto" value="<?php echo ($bolAtualizacao) ? htmlentities($objGrupo->getEmailGrupo()) : ""; ?>"/></td>
			</tr>
<?php
if ($bolSuperAdmin) {
?>
			<tr>
				<td class="escuro"><label for="bolRecebeChamado">Recebe Chamado</label></td>
				<td class="claro">
					<input type="radio" name="bolRecebeChamado" id="bolRecebeChamadoSim" value="true" <?php echo ($bolAtualizacao && $objGrupo->getFlagRecebeChamado()) ? 'checked="checked"' : ""; ?>/><label for="bolRecebeChamadoSim">Sim</label>
					<input type="radio" name="bolRecebeChamado" id="bolRecebeChamadoNao" value="false" <?php echo ($bolAtualizacao && !$objGrupo->getFlagRecebeChamado()) ? 'checked="checked"' : ""; ?>/><label for="bolRecebeChamadoNao">N&atilde;o</label>
				</td>
			</tr>
<?php
}
?>
			<tr>
				<td colspan="2"><div class="mensagem">&nbsp;</div></td>
			</tr>
		</table>
		<input type="submit" class="botao submit" value="<?php echo ($bolAtualizacao) ? "Atualizar" : "Cadastrar"; ?> Grupo"/>
		</form>
	</div>
</div>
<div class="clear"></div>
<?php
// Include do rodapé
include("includes/incRodape.php");