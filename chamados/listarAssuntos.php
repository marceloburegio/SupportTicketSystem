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
	
	// Listando todos os Grupos administrados pelo Usuário
	$arrObjGrupoTodos = $objFachadaBDR->listarGruposAtivosAdminPorIdUsuario($intIdUsuario);
	
	// Processando apenas os grupos que recebem chamados
	$arrObjGrupo = array();
	foreach ($arrObjGrupoTodos as $objGrupo) {
		if ($objGrupo->getFlagRecebeChamado()) $arrObjGrupo[] = $objGrupo;
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
<script type="text/javascript" src="<?php echo Config::getUrlBase(); ?>/js/listarAssuntos.js?v=<?php echo filemtime("js/listarAssuntos.js"); ?>"></script>

<div id="corpo">
	<h2 class="titulo">Administra&ccedil;&atilde;o de Assuntos</h2>
	<div id="listaChamados">
		<div style="float:right;padding-top:15px;"><a href="cadastrarAssunto.php">Adicionar Novo Assunto</a></div>
		<div style="float:right;padding:7px;""><a href="cadastrarAssunto.php"><img src="imagens/icone_novo.gif" width="32" height="32" border="0" title="Adicionar Grupo" alt="Adicionar Grupo"/></a></div>
		<div class="clear"></div>
<?php
if (!empty($arrObjGrupo)) {
	foreach ($arrObjGrupo as $objGrupo) {
		// Listando todos os Assuntos do Grupo
		$arrObjAssunto = $objFachadaBDR->listarAssuntosAtivosPorIdGrupo($objGrupo->getIdGrupo());
?>
		<table cellpadding="3" cellspacing="1" width="100%" bgcolor="#DDDDDD">
			<tr><td colspan="4" class="escuro"><?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></td></tr>
			<tr class="claro">
				<td>Assunto</td>
				<td width="80" align="center">Formato</td>
				<td width="150" align="center">SLA</td>
				<td width="150" align="center">A&ccedil;&otilde;es</td>
			</tr>
<?php
		if (!empty($arrObjAssunto) && is_array($arrObjAssunto) && count($arrObjAssunto) > 0) {
			foreach ($arrObjAssunto as $objAssunto) {
				$strHashIdAssunto = Encripta::encode($objAssunto->getIdAssunto(), "listarAssuntos");
?>
			<tr bgcolor="#FFFFFF">
				<td><?php echo htmlentities($objAssunto->getDescricaoAssunto()); ?></td>
				<td align="center">
<?php
				if (strlen($objAssunto->getFormatoChamado()) > 1) {
?>
					<img src="imagens/icone_editar.gif" width="32" height="32" border="0" title="Este assunto possui um Formato Espec&iacute;fico para os Chamados" alt="Este assunto possui um Formato Espec&iacute;fico para os Chamados">
<?php
				}
?>
				</td>
				<td align="center">
<?php
				$arrTempo = Util::converterMinutosParaTempo($objAssunto->getSla());
				echo htmlentities($arrTempo["tempo"] ." ". $arrTempo["unidade"]);
?>
				</td>
				<td align="center">
					<input type="hidden" class="strHashIdAssunto" value="<?php echo htmlentities($strHashIdAssunto); ?>"/>
					<a href="cadastrarAssunto.php?strHashIdAssunto=<?php echo urlencode($strHashIdAssunto); ?>"><img src="imagens/icone_editar.gif" width="32" height="32" border="0" alt="Editar Assunto" title="Editar Assunto"/></a>
					&nbsp;&nbsp; <a href="javascript:;" class="cancelarAssunto"><img src="imagens/icone_remover.gif" width="30" height="30" border="0" alt="Cancelar Assunto" title="Cancelar Assunto"/></a>
				</td>
			</tr>
<?php
			}
		}
		else {
?>
			<tr bgcolor="#FFFFFF">
				<td colspan="4"><h3 align="center">Nenhum assunto foi atribu&iacute;do a este grupo.</h3></td>
			</tr>
<?php
		}
?>
		</table><br/>
<?php
	}
}
else {
?>
		<h3 align="center">Nenhum grupo foi encontrato ou voc&ecirc; n&atilde;o &eacute; administrador de algum grupo.</h3>
<?php
}
?>
	</div>
	<div class="clear"></div>
</div>
<?php
// Include do rodapé
include("includes/incRodape.php");