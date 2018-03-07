<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoAdmin();
	
	// Obtendo os dados postados
	$strHashIdGrupo = (string) @$_POST["strHashIdGrupo"];
	
	// Validando o identificador do grupo
	$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarGrupos");
	if (!$intIdGrupo) throw new Exception("O Identificador do Grupo está incorreto. Tente o acesso novamente.");
	
	// Listando os usuários do grupo
	$arrObjUsuario = $objFachadaBDR->listarUsuariosPorIdGrupo($intIdGrupo);
	
	// Recuperando o Id do Usuário autenticado
	$intIdUsuario = (int) @$_SESSION["intIdUsuario"];
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incErro.php");
	exit();
}

if (!empty($arrObjUsuario) && count($arrObjUsuario) > 0) {
?>
<table cellpadding="3" cellspacing="1" width="100%" border="0" bgcolor="#DDDDDD">
	<tr class="escuro">
		<td>Login</td>
		<td>Nome</td>
		<td width="150" align="center">A&ccedil;&otilde;es</td>
	</tr>
<?php
	foreach ($arrObjUsuario as $objUsuario) {
		// Recuperando o objeto UsuarioGrupo
		$objUsuarioGrupo = $objFachadaBDR->procurarGrupoUsuario($intIdGrupo, $objUsuario->getIdUsuario());
		
		// Gerando o Hash do IdUsuario
		$strHashIdUsuario = Encripta::encode($objUsuario->getIdUsuario(), "listarGrupos");
?>
	<tr bgcolor="#FFFFFF">
		<td><?php echo htmlentities($objUsuario->getLogin()); ?></td>
		<td><?php echo htmlentities($objUsuario->getNomeusuario()); ?></td>
		<td align="center" style="height:45px;">
			<input type="hidden" class="strHashIdGrupo" value="<?php echo htmlentities($strHashIdGrupo); ?>"/>
			<input type="hidden" class="strHashIdUsuario" value="<?php echo htmlentities($strHashIdUsuario); ?>"/>
			<a href="javascript:;" class="excluirUsuarioGrupo"><img src="imagens/icone_remover.gif" width="30" height="30" border="0" alt="Excluir Usu&aacute;rio" title="Excluir Usu&aacute;rio"/></a>
<?php
			if (!$objUsuarioGrupo->getFlagAdmin()) {
?>
			&nbsp;&nbsp; <a href="javascript:;" class="adicionarUsuarioAdmin"><img src="imagens/icone_admin_desativado.gif" width="32" height="32" border="0" alt="Adicionar Admininistrador" title="Adicionar Admininistrador"/></a>
<?php
			}
			else {
?>
			&nbsp;&nbsp; <a href="javascript:;" class="removerUsuarioAdmin"><img src="imagens/icone_admin_ativado.gif" width="32" height="32" border="0" alt="Remover Admininistrador" title="Remover Admininistrador"/></a>
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
else {
?>
<h3 align="center">Nenhum usu&aacute;rio foi associado a este grupo.</h3>
<?php
}