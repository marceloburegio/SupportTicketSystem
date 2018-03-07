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
	$strLogin		= (string) @$_POST["strLogin"];
	$strHashIdGrupo	= (string) @$_POST["strHashIdGrupo"];
	
	// Validando o Hash
	$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarGrupos");
	if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
	
	// Recuperando o usuário do banco
	$objUsuario = $objFachadaBDR->procurarUsuarioPorLogin($strLogin);
	
	// Adicionando o usuário ao grupo
	$intIdUsuario = $objUsuario->getIdUsuario();
	try {
		$objFachadaBDR->cadastrarGrupoUsuario($intIdGrupo, $intIdUsuario);
	}
	catch (GrupoUsuarioJaCadastradoException $ex) {
		throw new Exception("Usuário já associado ao Grupo");
	}
	
	$strMensagem = "Usuário adicionando ao Grupo";
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