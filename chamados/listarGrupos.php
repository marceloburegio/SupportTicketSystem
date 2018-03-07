<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoAdmin();
	
	// Obtendo os dados da sessão
	$intIdUsuario = (int) @$_SESSION["intIdUsuario"];
	$bolGrupoAdmin = (boolean) @$_SESSION["bolGrupoAdmin"];
	$bolSuperAdmin = (boolean) @$_SESSION["bolSuperAdmin"];
	
	// Listando os grupos
	$arrObjGrupo = array();
	if ($bolSuperAdmin) $arrObjGrupo = $objFachadaBDR->listarGruposAtivos();
	elseif ($bolGrupoAdmin) $arrObjGrupo = $objFachadaBDR->listarGruposAtivosAdminPorIdUsuario($intIdUsuario);
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
<script type="text/javascript" src="<?php echo Config::getUrlBase(); ?>/js/listarGrupos.js?v=<?php echo filemtime("js/listarGrupos.js"); ?>"></script>

<div id="corpo">
	<h2 class="titulo">Administra&ccedil;&atilde;o de Grupos</h2>
	<div id="listaChamados">
<?php
if ($bolSuperAdmin) {
?>
	<div style="float:right;padding-top:15px;"><a href="cadastrarGrupo.php">Adicionar Novo Grupo</a></div>
	<div style="float:right;padding:7px;""><a href="cadastrarGrupo.php"><img src="imagens/icone_novo.gif" width="32" height="32" border="0" title="Adicionar Grupo" alt="Adicionar Grupo"/></a></div>
	<div class="clear"></div>
<?php
}
else {
?>
		<br/>
<?php
}
if (empty($arrObjGrupo)) {
?>
<h3 align="center">Nenhum grupo foi encontrado</h3>
<?php
}
else {
?>
		<table cellpadding="3" cellspacing="1" width="100%" border="0" bgcolor="#DDDDDD">
			<tr class="escuro">
				<td align="center">Nome do Grupo</td>
				<td width="250" align="center">Email do Grupo</td>
				<td width="100" align="center">Recebe Chamado?</td>
				<td width="180" align="center">A&ccedil;&otilde;es</td>
			</tr>
<?php
	foreach ($arrObjGrupo as $intKey => $objGrupo) {
		$strHashIdGrupo = Encripta::encode($objGrupo->getIdGrupo(), "listarGrupos");
?>
			<tr bgcolor="#FFFFFF" id="grupo<?php echo htmlentities($objGrupo->getIdGrupo()); ?>">
				<td><?php echo htmlentities($objGrupo->getDescricaoGrupo()); ?></td>
				<td align="center"><?php echo htmlentities($objGrupo->getEmailGrupo()); ?></td>
				<td align="center"><?php echo htmlentities(($objGrupo->getFlagRecebeChamado()) ? "Sim" : "Não"); ?></td>
				<td align="center">
					<input type="hidden" class="strHashIdGrupo" value="<?php echo htmlentities($strHashIdGrupo); ?>"/>
					<a href="cadastrarGrupo.php?strHashIdGrupo=<?php echo urlencode($strHashIdGrupo); ?>"><img src="imagens/icone_editar.gif" width="32" height="32" border="0" alt="Editar Grupo" title="Editar Grupo"/></a>&nbsp;
<?php
		if ($objGrupo->getFlagRecebeChamado()) {
?>
					<a href="listarFeriados.php?strHashIdGrupo=<?php echo urlencode($strHashIdGrupo); ?>"><img src="imagens/icone_feriado.gif" width="32" height="32" border="0" alt="Listar Feriados do Grupo" title="Listar Feriados do Grupo"/></a>&nbsp;
<?php
		}
		else {
?>
					<img src="imagens/icone_feriado_desativado.png" width="32" height="32" border="0" alt="Listar Feriados do Grupo" title="Listar Feriados do Grupo"/>&nbsp;
<?php
		}
?>
					<a href="associarUsuariosGrupo.php?strHashIdGrupo=<?php echo urlencode($strHashIdGrupo); ?>"><img src="imagens/icone_usuarios.gif" width="32" height="32" border="0" alt="Associar Usu&aacute;rios ao Grupo" title="Associar Usu&aacute;rios ao Grupo"/></a>&nbsp;
<?php
		if ($bolSuperAdmin) {
?>
					<a href="javascript:;" class="cancelarGrupo"><img src="imagens/icone_remover.gif" width="30" height="30" border="0" alt="Cancelar Grupo" title="Cancelar Grupo"/></a>
<?php
		}
?>
				</td>
			</tr>
<?php
	}
?>
		</table>
<?php
}
?>
	</div>
	<div class="clear"></div>
</div>
<?php
// Include do rodapé
include("includes/incRodape.php");