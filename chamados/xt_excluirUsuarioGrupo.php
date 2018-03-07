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
	$objFachadaBDR->validarSessaoAdmin();
	
	// Obtendo os dados postados
	$strHashIdGrupo		= (string) @$_POST["strHashIdGrupo"];
	$strHashIdUsuario	= (string) @$_POST["strHashIdUsuario"];
	
	// Validando o Hash
	$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarGrupos");
	$intIdUsuario = Encripta::decode($strHashIdUsuario, "listarGrupos");
	if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
	if (!$intIdUsuario) throw new Exception("O ID do Usuario está inválido.");
	
	// Excluindo o usuário do grupo
	$objFachadaBDR->excluirGrupoUsuario($intIdGrupo, $intIdUsuario);
	$strMensagem = "Usuário excluído do Grupo";
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