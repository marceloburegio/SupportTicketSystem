<?php
/**
 * Este arquivo configura todas as classes que serão carregadas
 * Deverá estar presente em todos os arquivos que utilizarão das classes
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 22/10/2008 12:21:20
 */
/**
 * Realizando os includes das classes automaticamente
 */
function __autoload($strClass) {
	// Fachada
	$arrClasses["FachadaBDR"]					= "fachada/FachadaBDR.php";
	
	// Conexão
	$arrClasses["ConexaoBDR"]					= "conexao/ConexaoBDR.php";
	$arrClasses["PDO2"]							= "conexao/PDO2.php";
	$arrClasses["RepositorioException"]			= "conexao/RepositorioException.php";
	
	// Utilitárias
	$arrClasses["Util"]							= "util/Util.php";
	$arrClasses["XML"]							= "util/XML.php";
	$arrClasses["Email"]						= "util/Email.php";
	$arrClasses["Config"]						= "util/Config.php";
	$arrClasses["Encripta"]						= "util/Encripta.php";
	$arrClasses["Paginacao"]					= "util/Paginacao.php";
	$arrClasses["HTML2PDF"]						= "util/html2pdf/html2pdf.class.php";
	$arrClasses["CampoInvalidoException"]		= "util/CampoInvalidoException.php";
	$arrClasses["CampoObrigatorioException"]	= "util/CampoObrigatorioException.php";
	
	// Verificando se a classe está cadastrada no vetor de classes
	$strCaminhoClasse = "";
	if (isset($arrClasses[$strClass])) require_once( dirname(__FILE__) ."/". $arrClasses[$strClass] );
	
	// Verificando se a classe é do tipo Controlador, Cadastro, IRepositorio, Repositorio ou Exceção
	elseif (preg_match("/^(Controlador(.*)|(Cadastro|IRepositorio)(.+)|Repositorio(.+)(BDR|XML|WS|TXT)(Customizado)?|(.+)(NaoCadastradoException|JaCadastradoException|InexistenteException))$/", $strClass, $arrClass)) {
		if (!empty($arrClass[2]))     $strPackage = "controladores";          // Controlador(.*)
		elseif (!empty($arrClass[4])) $strPackage = strtolower($arrClass[4]); // (Cadastro|IRepositorio)(.+)
		elseif (!empty($arrClass[5])) $strPackage = strtolower($arrClass[5]); // Repositorio(.+)(BDR|XML|WS|TXT)
		elseif (!empty($arrClass[8])) $strPackage = strtolower($arrClass[8]); // (.+)(NaoCadastradoException|JaCadastradoException)
		require_once(dirname(__FILE__) ."/". $strPackage ."/". $strClass .".php");
	}
	
	// Verificando se a classe é do tipo Classe Básica
	else {
		$strArquivo = dirname(__FILE__) ."/". strtolower($strClass) ."/". $strClass .".php";
		if (file_exists($strArquivo)) require_once($strArquivo);
	}
}