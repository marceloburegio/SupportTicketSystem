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
	$strHashIdChamado		= (string) @$_POST["strHashIdChamado"];
	$strTipoListagem		= (string) @$_POST["strTipoListagem"];
	$intIdUsuarioOrigem		= (int) @$_SESSION["intIdUsuario"];
	$intIdAssunto			= (int) @$_POST["intIdAssunto"];
	$intCodigoPrioridade	= (int) @$_POST["intCodigoPrioridade"];
	$intStatus	= (int) @$_POST["intStatus"];
	
	$bolRecebido = ($strTipoListagem == "recebidos") ? true : false;
	$strListagem = ($bolRecebido) ? "listarChamadosRecebidos" : "listarChamadosEnviados"; 
	
	// Validando o identificador do chamado
	$intIdChamado = Encripta::decode($strHashIdChamado, $strListagem);
	if (!$intIdChamado) throw new Exception("O Identificador do Chamado está incorreto. Tente o acesso novamente.");
	
	// Cadastrando o chamado
	$objFachadaBDR->reclassificarChamado($intIdChamado, $intIdUsuarioOrigem, $intIdAssunto, $intCodigoPrioridade, $intStatus);
	
	$strMensagem = "Chamado reclassificado com sucesso.";
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