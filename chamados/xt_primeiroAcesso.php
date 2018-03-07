<?php
// Includes
require("config.inc.php");

// Iniciando a sessão (manualmente exclusivamente nesta página)
session_start();

// Inicializando a resposta
$bolResposta = false;
$strMensagem = "";
$strLocation = "";

try {
	$strLogin			= (string) @$_SESSION["strLogin"];
	$strNomeUsuario		= (string) @$_POST["strNome"];
	$strEmailUsuario	= (String) @$_POST["strEmail"];
	$intIdSetor			= (int) @$_POST["intIdSetor"];
	$strRamal			= (String) @$_POST["strRamal"];
	
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Cadastrando o usuário
	$objFachadaBDR->cadastrarUsuario($strLogin, $strNomeUsuario, $strEmailUsuario, $intIdSetor, $strRamal);
	$strLocation = "./";
	$strMensagem = "Dados Cadastrados com Sucesso.";
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