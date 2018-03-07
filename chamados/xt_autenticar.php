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
	
	// Obtendo os dados postados
	$strLogin = (string) @$_POST["strLogin"];
	$strSenha = (string) @$_POST["strSenha"];
	
	// Autenticando o usuario
	if ($objFachadaBDR->autenticarUsuario($strLogin, $strSenha)) {
		// Verificando se é o primeiro acesso do usuário
		$strLocation = "./";
		if ($_SESSION["bolPrimeiroAcesso"]) $strLocation = "primeiroAcesso.php";
		
		$strMensagem = "Usuário autenticado. Aguarde...";
		$bolResposta = true;
	}
	else {
		$strMensagem = "Usuário/Senha incorretos.";
	}
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