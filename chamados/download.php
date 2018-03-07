<?php
// Includes
require("config.inc.php");

try {
	// Inicializando a Fachada
	$objFachadaBDR = FachadaBDR::getInstance();
	
	// Recuperando os dados postados
	$strHashIdHistorico = (string) @$_GET["strHashIdHistorico"];
	
	// Validando o identificador do historico
	$intIdHistorico = Encripta::decode($strHashIdHistorico, "downloadAnexo");
	if (!$intIdHistorico) throw new Exception("O Identificador do Histórico está incorreto. Tente o acesso novamente.");
	
	// Recuperando o historico
	$objHistorico = $objFachadaBDR->procurarHistorico($intIdHistorico);
	
	// Montando o caminho do arquivo anexo
	$strCaminhoArquivoAnexo = Config::getCaminhoArquivosAnexos() ."/". $objHistorico->getCaminhoArquivoAnexo();
	
	// Validando se o arquivo anexo existe
	if (strlen(trim($objHistorico->getCaminhoArquivoAnexo())) == 0 || strlen(trim($objHistorico->getNomeArquivoAnexo())) == 0) throw new Exception("O arquivo solicitado não foi encontrado.");
	if (!file_exists($strCaminhoArquivoAnexo)) throw new Exception("O arquivo solicitado (". $objHistorico->getNomeArquivoAnexo(). ") não existe.");
	
	// Tamanho do arquivo e extensão
	$intTamanhoArquivo = filesize($strCaminhoArquivoAnexo);
	$arrArquivoAnexo = pathinfo($strCaminhoArquivoAnexo);
	$strExtensao = "";
	if (!empty($arrArquivoAnexo["extension"])) $strExtensao = strtolower($arrArquivoAnexo["extension"]);
	
	// Determinando o Content-Type do arquivo
	$strContentType = "";
	switch ($strExtensao) {
		case "pdf": $strContentType = "application/pdf"; break;
		case "exe": $strContentType = "application/octet-stream"; break;
		case "zip": $strContentType = "application/zip"; break;
		case "doc": $strContentType = "application/msword"; break;
		case "xls": $strContentType = "application/vnd.ms-excel"; break;
		case "ppt": $strContentType = "application/vnd.ms-powerpoint"; break;
		case "gif": $strContentType = "image/gif"; break;
		case "png": $strContentType = "image/png"; break;
		case "jpeg":
		case "jpg": $strContentType = "image/jpg"; break;
		default: $strContentType = "application/force-download";
	}
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
	header("Content-Type: ". $strContentType);
	header('Content-Disposition: attachment; filename="'. $objHistorico->getNomeArquivoAnexo() .'";');
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ". $intTamanhoArquivo);
	readfile($strCaminhoArquivoAnexo); 
}
catch (Exception $ex) {
	$strMensagem = htmlentities($ex->getMessage());
	include("includes/incTopo.php");
	include("includes/incErro.php");
	include("includes/incRodape.php");
	exit();
}