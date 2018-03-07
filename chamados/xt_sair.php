<?php
// Includes
require("config.inc.php");

try {
	// Inicializando os objetos
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Finalizando o acesso a este site
	$objFachadaBDR->fecharSessaoUsuario();
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incTopo.php");
	include("includes/incErro.php");
	include("includes/incRodape.php");
	exit();
}