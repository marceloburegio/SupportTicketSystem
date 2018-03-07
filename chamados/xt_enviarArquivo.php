<?php
// Includes
require("config.inc.php");

// Inicializando a resposta
$bolResposta = false;
$strMensagem = "";
$strLocation = "";

$strNomeArquivo = "";
$strCaminhoArquivo = "";
$intTamanhoArquivo = 0;

// Obtendo a data atual
$strDataAtual = date("Ymd");

// Criando o caminho que deverá ser usado para os arquivos enviados na data atual
if(!file_exists(Config::getCaminhoArquivosAnexos() ."/". $strDataAtual)) {
	if(!mkdir(Config::getCaminhoArquivosAnexos() ."/". $strDataAtual, 0777, true)) {
		$strMensagem = "Erro ao criar diretorio";
	}
}

if (file_exists(Config::getCaminhoArquivosAnexos() ."/". $strDataAtual)) {
	// Obtendo o nome temporario do arquivo
	$strNomeArquivoTemp	= (string) @$_FILES["Filedata"]["tmp_name"];
	$strNomeArquivo		= (string) @$_FILES["Filedata"]["name"];
	
	// Verificando os nomes dos arquivos
	if (empty($strNomeArquivoTemp) || empty($strNomeArquivo)) $strMensagem = "Ocorreu um erro ao enviar o arquivo. Por favor, tente novamente.";
	else {
		// Renomeando o arquivo
		$arrNomeArquivo = pathinfo($strNomeArquivo);
		$strExtensao = "";
		if (!empty($arrNomeArquivo["extension"])) $strExtensao = ".". $arrNomeArquivo["extension"];
		$strCaminhoArquivo = $strDataAtual ."/". md5($strNomeArquivoTemp . date("d-m-Y h:i:m:s")) . $strExtensao;
		
		// Movendo o arquivo para a pasta final
		if (move_uploaded_file($strNomeArquivoTemp, Config::getCaminhoArquivosAnexos() ."/". $strCaminhoArquivo)) {
			if (file_exists(Config::getCaminhoArquivosAnexos() ."/". $strCaminhoArquivo)) {
				$bolResposta = true;
				$intTamanhoArquivo = filesize(Config::getCaminhoArquivosAnexos() ."/". $strCaminhoArquivo);
			}
		}
	}
}

// Montando o array de resposta
$arrResposta = array();
$arrResposta["resposta"] = $bolResposta;
$arrResposta["mensagem"] = htmlentities($strMensagem);
$arrResposta["location"] = $strLocation;
$arrResposta["strNomeArquivo"] = $strNomeArquivo;
$arrResposta["strCaminhoArquivo"] = $strCaminhoArquivo;
$arrResposta["intTamanhoArquivo"] = $intTamanhoArquivo;

//Retornando via json
echo json_encode($arrResposta);