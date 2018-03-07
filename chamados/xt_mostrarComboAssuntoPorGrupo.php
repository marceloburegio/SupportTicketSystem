<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Obtendo os dados postados
	$intIdGrupo		= (int) @$_POST["intIdGrupo"];
	$intIdAssunto	= (int) @$_POST["intIdAssunto"];
	
	// Listando os assuntos do grupo selecionado
	$arrObjAssunto = $objFachadaBDR->listarAssuntosAtivosPorIdGrupo($intIdGrupo);
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	echo "ERRO: ". $strMensagem;
	exit();
}
?>
<select name="intIdAssunto" class="obrigatorio comboAssuntos">
	<option value="">-- Selecione o Assunto --</option>
<?php
foreach ($arrObjAssunto as $objAssunto) {
?>
	<option value="<?php echo htmlentities($objAssunto->getIdAssunto()); ?>" <?php echo ($objAssunto->getIdAssunto() == $intIdAssunto) ? 'selected="selected"' : ""; ?>><?php echo htmlentities($objAssunto->getDescricaoAssunto()); ?></option>
<?php
}
?>
</select>