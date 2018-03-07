<?php
// Includes
require("config.inc.php");

// Inicializando a resposta
$bolResposta = false;
$strMensagem = "";
$strLocation = "";

// Obtendo os dados postados
$strCaminhoArquivoAnexo = (string) @$_POST["strCaminhoArquivoAnexo"];

// Apagando o arquivo anexo
$strCaminhoArquivoAnexo = Config::getCaminhoArquivosAnexos() ."/". $strCaminhoArquivoAnexo;
if (@unlink($strCaminhoArquivoAnexo)) $bolResposta = true;
else $strMensagem = 'Desculpe, ocorreu um erro ao remover o arquivo.';

// Montando o array de resposta
$arrResposta = array();
$arrResposta["resposta"] = $bolResposta;
$arrResposta["mensagem"] = htmlentities($strMensagem);
$arrResposta["location"] = $strLocation;

// Exibindo a resposta serializada pelo JSON
echo json_encode($arrResposta);