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
	$intIdUsuario				= (int)		@$_SESSION["intIdUsuario"];
	$intIdGrupoDestino			= (int)		@$_POST["intIdGrupoDestino"];
	$intIdAssunto				= (int)		@$_POST["intIdAssunto"];
	$strDescricaoChamado		= (string)	@$_POST["strDescricaoChamado"];
	$intCodigoPrioridade		= (int)		@$_POST["intCodigoPrioridade"];
	$strJustificativaPrioridade	= (string)	@$_POST["strJustificativaPrioridade"];
	$strNomeArquivoAnexo		= (string)	@$_POST["strNomeArquivoAnexo"];
	$strCaminhoArquivoAnexo		= (string)	@$_POST["strCaminhoArquivoAnexo"];
	$strEmailCopia				= (string)	@$_POST["strEmailCopia"];
	
	// Cadastrando o chamado
	$objFachadaBDR->cadastrarChamado($intIdUsuario, $intIdGrupoDestino, $intIdAssunto, $strDescricaoChamado, $intCodigoPrioridade, $strJustificativaPrioridade, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo, $strEmailCopia);
	
	$strMensagem = "Chamado cadastrado com sucesso.";
	$bolResposta = true;
}
catch (Exception $ex) {
	$strMensagem = $ex->getMessage();
}

// Montando o array de resposta
$arrResposta = array();
$arrResposta["resposta"] = $bolResposta;
$arrResposta["mensagem"] = $strMensagem;
$arrResposta["location"] = $strLocation;

// Exibindo a resposta serializada pelo JSON
echo json_encode($arrResposta);