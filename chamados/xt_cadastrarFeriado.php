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
	$strHashIdFeriado		= (string) @$_POST["strHashIdFeriado"];
	$strDescricaoFeriado	= (String) @$_POST["strDescricaoFeriado"];
	$strDataFeriado			= (String) @$_POST["strDataFeriado"];
	
	if ($strAcao == "inserir") {
		// Validando o Hash do ID do Grupo
		$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarFeriados");
		if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
		
		$objFachadaBDR->cadastrarFeriado($intIdGrupo, $strDataFeriado, $strDescricaoFeriado);
		$strMensagem = "Feriado cadastrado com sucesso.";
		$bolResposta = true;
	}
	else {
		// Validando o Hash
		$intIdFeriado = Encripta::decode($strHashIdFeriado, "listarFeriados");
		if (!$intIdFeriado) throw new Exception("O ID do Feriado está inválido.");
		
		if ($strAcao == "atualizar") {
			// Validando o Hash do ID do Grupo
			$intIdGrupo = Encripta::decode($strHashIdGrupo, "listarFeriados");
			if (!$intIdGrupo) throw new Exception("O ID do Grupo está inválido.");
			
			$objFachadaBDR->atualizarFeriado($intIdFeriado, $intIdGrupo, $strDataFeriado, $strDescricaoFeriado);
			$strMensagem = "Feriado atualizado com sucesso.";
			$bolResposta = true;
		}
		elseif ($strAcao == "excluir") {
			$objFachadaBDR->excluirFeriado($intIdFeriado);
			$strMensagem = "Feriado excluído com sucesso.";
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