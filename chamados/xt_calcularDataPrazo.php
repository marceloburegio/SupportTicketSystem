<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Obtendo os dados postados
	$intIdGrupo			= (int) @$_POST["intIdGrupo"];
	$intIdAssunto		= (int) @$_POST["intIdAssunto"];
	$strDataReferencia	= (string) @$_POST["strDataAbertura"];
	
	if ($intIdGrupo > 0 && $intIdAssunto > 0) {
		if (strlen(trim($strDataReferencia)) == 0) $strDataReferencia = date("Y-m-d H:i:s");
		
		// Calculando o prazo de entrega com base no problema
		$strDataPrazo = $objFachadaBDR->calcularDataPrazo($intIdGrupo, $intIdAssunto, $strDataReferencia);
		
		// Exibindo o prazo de entrega
		echo htmlentities(Util::reduzirDataHora(Util::formatarBancoData($strDataPrazo)));
	}
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	echo "ERRO: ". $strMensagem;
	exit();
}