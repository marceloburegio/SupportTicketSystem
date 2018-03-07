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
	$strAcao				= (string) @$_POST["strAcao"];
	$strHashIdGrupo			= (string) @$_POST["strHashIdGrupo"];
	$strDescricaoGrupo		= (string) @$_POST["strDescricaoGrupo"];
	$strEmailGrupo			= (string) @$_POST["strEmailGrupo"];
	$bolFlagRecebeChamado	= (boolean) (@$_POST["bolRecebeChamado"] == "true") ? true : false;
	
	if ($strAcao == "inserir") {
		$objFachadaBDR->cadastrarGrupo($strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado);
		$strMensagem = "Grupo cadastrado com sucesso.";
		$bolResposta = true;
	}
	else {
		// Validando o Hash
		$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarGrupos");
		if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
		
		if ($strAcao == "atualizar") {
			$objFachadaBDR->atualizarGrupo($intIdGrupo, $strDescricaoGrupo, $strEmailGrupo, $bolFlagRecebeChamado);
			$strMensagem = "Grupo atualizado com sucesso.";
			$bolResposta = true;
		}
		elseif ($strAcao == "cancelar") {
			$objFachadaBDR->cancelarGrupo($intIdGrupo);
			$strMensagem = "Grupo cancelado com sucesso.";
			$bolResposta = true;
		}
		else $strMensagem = "Ação não encontrada.";
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