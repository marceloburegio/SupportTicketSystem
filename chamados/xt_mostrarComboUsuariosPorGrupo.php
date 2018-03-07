<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Obtendo os dados postados
	$intIdGrupo = (int) @$_POST["intIdGrupoDestino"];
	
	// Listando os usuários do grupo
	$arrObjUsuario = $objFachadaBDR->listarUsuariosPorIdGrupo($intIdGrupo);
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	echo "ERRO: ". $strMensagem;
	exit();
}
?>
<select id="intIdUsuarioDestino" name="intIdUsuarioDestino" class="texto obrigatorio intIdUsuarioDestino">
	<option value="">-- Selecione um Usu&aacute;rio --</option>
<?php
foreach ($arrObjUsuario as $objUsuario) {
?>
	<option value="<?php echo htmlentities($objUsuario->getIdUsuario()); ?>"><?php echo htmlentities($objUsuario->getNomeUsuario()); ?></option>
<?php
}
?>
</select>