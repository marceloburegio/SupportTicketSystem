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
	$strHashIdAssunto		= (string) @$_POST["strHashIdAssunto"];
	$intIdGrupo				= (int) @$_POST["intIdGrupo"];
	$strDescricaoAssunto	= (string) @$_POST["strDescricaoAssunto"];
	$intTempo				= (int) @$_POST["intTempo"];
	$strUnidade				= (string) @$_POST["strUnidade"];
	$strAlertaChamado		= (string) @$_POST["strAlertaChamado"];
	$strFormatoChamado		= (string) @$_POST["strFormatoChamado"];
	$strUrlChamadoExterno	= (string) @$_POST["strUrlChamadoExterno"];
	
	// Convertendo o tempo + unidade em SLA
	$intSla = Util::converterTempoParaMinutos($intTempo, $strUnidade);
	
	if ($strAcao == "inserir") {
		$objFachadaBDR->cadastrarAssunto($intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno);
		$strMensagem = "Assunto cadastrado com sucesso.";
		$bolResposta = true;
	}
	else {
		// Validando o Hash
		$intIdAssunto = Encripta::decode($strHashIdAssunto, "listarAssuntos");
		if (!$intIdAssunto) throw new Exception("O ID do Assunto está inválido.");
		
		if ($strAcao == "atualizar") {
			$objFachadaBDR->atualizarAssunto($intIdAssunto, $intIdGrupo, $strDescricaoAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno);
			$strMensagem = "Assunto atualizado com sucesso.";
			$bolResposta = true;
		}
		elseif ($strAcao == "cancelar") {
			$objFachadaBDR->cancelarAssunto($intIdAssunto);
			$strMensagem = "Assunto cancelado com sucesso.";
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