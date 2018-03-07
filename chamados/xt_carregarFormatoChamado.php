<?php
// Includes
require("config.inc.php");

// Inicializando a resposta
$bolResposta = false;
$strMensagem = "";
$strAlerta   = "";

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Validando o acesso a este site
	$objFachadaBDR->validarSessaoUsuario();
	
	// Obtendo os dados postados
	$intIdAssunto = (int) @$_POST["intIdAssunto"];
	if ($intIdAssunto > 0) {
		
		// Recuperando o Assunto especificado
		$objAssunto = $objFachadaBDR->procurarAssuntoPorIdAssunto($intIdAssunto);
		
		// Obtendo o Formato do Chamado
		$strMensagem = $objAssunto->getFormatoChamado();
		$strAlerta   = $objAssunto->getAlertaChamado();
		$bolResposta = true;
	}
}
catch (Exception $ex) {
	$strMensagem = $ex->getMessage();
}

// Montando o array de resposta
$arrResposta = array();
$arrResposta["resposta"] = $bolResposta;
$arrResposta["mensagem"] = $strMensagem;
$arrResposta["alerta"]   = $strAlerta;

// Exibindo a resposta serializada pelo JSON
echo json_encode($arrResposta);