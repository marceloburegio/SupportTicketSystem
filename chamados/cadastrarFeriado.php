<?php
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
	$strHashIdGrupo = (string) @$_GET["strHashIdGrupo"];
	$strHashIdFeriado = (string) @$_GET["strHashIdFeriado"];
	
	// Validando o Hash do ID do Grupo
	$bolAtualizacao = false;
	if (empty($strHashIdGrupo)) {
		throw new Exception("O ID do Grupo está vazio.");
	}
	else {
		$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarFeriados");
		if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
	}
	
	if (!empty($strHashIdFeriado)) {
		// Validando o Hash
		$intIdFeriado = Encripta::decode($strHashIdFeriado, "listarFeriados");
		if (!$intIdFeriado) throw new Exception("O ID do Feriado está inválido.");
		
		$bolAtualizacao = true;
		$objFeriado = $objFachadaBDR->procurarFeriado($intIdFeriado);
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
	<h2 class="titulo"><?php echo ($bolAtualizacao) ? "Editar" : "Adicionar"; ?> Feriado</h2>
	<div class="conteudo">
		<form id="formCadastrar" action="xt_cadastrarFeriado.php" method="post">
		<input type="hidden" name="strAcao" value="<?php echo ($bolAtualizacao) ? "atualizar" : "inserir"; ?>"/>
		<input type="hidden" name="strHashIdGrupo" value="<?php echo $strHashIdGrupo; ?>"/>
		<input type="hidden" name="strHashIdFeriado" value="<?php echo ($bolAtualizacao) ? $strHashIdFeriado : ""; ?>"/>
		<table cellspacing="1" cellpadding="3">
			<tr>
				<td class="escuro"><label for="strDescricaoFeriado">Descri&ccedil;&atilde;o</label></td>
				<td class="claro"><input type="text" name="strDescricaoFeriado" id="strDescricaoFeriado" class="texto obrigatorio" size="33" maxlength="50" value="<?php echo ($bolAtualizacao) ? htmlentities($objFeriado->getDescricaoFeriado()) : ""; ?>"/></td>
			</tr>
			<tr>
				<td class="escuro"><label for="strDataFeriado">Data do Feriado</label></td>
				<td class="claro"><input type="text" name="strDataFeriado" id="strDataFeriado" class="calendario obrigatorio" size="10" maxlength="50" value="<?php echo ($bolAtualizacao) ? Util::formatarBancoData($objFeriado->getDataFeriado()) : ""; ?>"/></td>
			</tr>
			<tr>
				<td colspan="2"><div class="mensagem">&nbsp;</div></td>
			</tr>
		</table>
		<input type="submit" class="botao submit" value="<?php echo ($bolAtualizacao) ? "Atualizar" : "Cadastrar"; ?> Feriado"/>
	</form>
	</div>
</div>
<div class="clear"></div>
<?php
// Include do rodapé
include("includes/incRodape.php");