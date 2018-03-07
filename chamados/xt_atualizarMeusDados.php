<?php
// Includes
require("config.inc.php");

// Inicializando a resposta
$bolResposta = false;
$strMensagem = "";
$strLocation = "";

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Obtendo os dados postados
	$intIdUsuario		= (int) @$_SESSION["intIdUsuario"];
	$strNomeUsuario		= (string) @$_POST["strNome"];
	$strEmailUsuario	= (String) @$_POST["strEmail"];
	$intIdSetor			= (int) @$_POST["intIdSetor"];
	$strRamal			= (String) @$_POST["strRamal"];
	
	// Cadastrando o usuário
	$objFachadaBDR->atualizarUsuario($intIdUsuario, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal);
	$strMensagem = "Dados atualizados com Sucesso.";
	$bolResposta = true;
}
catch (Exception $ex) {
	$strMensagem = $ex->getMessage();
}

// Montando o array de resposta
$arrResposta = array();
$arrResposta["resposta"] = $bolResposta;
$arrResposta["mensagem"] = htmlentities($strMensagem);
$arrResposta["location"] = $strLocation;

// Exibindo a resposta serializada pelo JSON
echo json_encode($arrResposta);