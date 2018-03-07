<?php
/**
 * Classe utilitária
 * 
 * @author Marcelo Burégio
 * @subpackage util
 * @version 1.0
 * @since 15/09/2008 17:49:48
 */
class Util {
	
	/**
	 * Método construtor da classe
	 *
	 * @access private
	 */
	private function __construct() {
	}
	
	/**
	 * Método estático que converter uma string para as suas iniciais em maiúsculo, exceto os pronomes
	 *
	 * @access public
	 * @param string $strFrase
	 * @return string
	 */
	public static function formatarFrase($strFrase) {
		$strFrase = ucwords(strtolower($strFrase));
		$strFrase = str_replace(array(' Da ',' De ',' Do ',' Das ',' Dos ',' A ',' E ',' O ',' Na ',' No '), array(' da ',' de ',' do ',' das ',' dos ',' a ',' e ',' o ',' na ',' no '), $strFrase);
		return $strFrase;
	}
	
	/**
	 * Método estático que valida a data
	 *
	 * @access public
	 * @param string $strData
	 * @return bolean
	 */
	public static function validaData($strData){
		$arrData = explode("/", $strData);
		return checkdate($arrData[1], $arrData[0], $arrData[2]);
	}
	
	/**
	 * Método estático que converter uma data do formato DD/MM/YYYY para o formato de banco de dados
	 *
	 * @access public
	 * @param string $strData
	 * @return string
	 */
	public static function formatarDataBanco($strData) {
		$strDataRetorno = "";
		if(preg_match('/\s/', $strData)){
			$arrDataHora = explode(" ", $strData);
			$arrData = explode("/", $arrDataHora[0]);
			$strDataRetorno = date("Y-m-d", mktime(0, 0, 0, $arrData[1], $arrData[0], $arrData[2])). " " . $arrDataHora[1];
		}else{
			$arrData = explode("/", $strData);
			$strDataRetorno = date("Y-m-d", mktime(0, 0, 0, $arrData[1], $arrData[0], $arrData[2]));
		}
		return $strDataRetorno;
	}
	
	/**
	 * Método estático que converter uma data do formato de banco de dados para o formato DD/MM/YYYY ou DD/MM/YYYY HH:MM:SS ou DD/MM/YYYY HH:MM
	 *
	 * @access public
	 * @param string $strData
	 * @return string
	 */
	public static function formatarBancoData($strData) {
		if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})( [0-9]{2}:[0-9]{2}:[0-9]{2})?$/", $strData, $arrData)) {
			$strData = date("d/m/Y", mktime(0, 0, 0, $arrData[2], $arrData[3], $arrData[1]));
			if (!empty($arrData[4])) $strData .= $arrData[4];
			return $strData;
		}
		return "00/00/0000";
	}
	
	/**
	 * Método estático que converter data de DD/MM/YYYY HH:MM:SS para DD/MM/YY HH:MM
	 *
	 * @access public
	 * @param string $strData
	 * @return string
	 */
	public static function reduzirDataHora($strData) {
		return  substr($strData, 0, 6) . substr($strData, 8, 8);
	}
	
	/**
	 * Método estático que converter um mês (numérico) em mês com string
	 *
	 * @access public
	 * @param int $intMes
	 * @return string
	 */
	public static function formatarMes($intMes) {
		$intMes = (int) $intMes;
		switch($intMes) {
			case 1 : return "Janeiro";
			case 2 : return "Fevereiro";
			case 3 : return "Março";
			case 4 : return "Abril";
			case 5 : return "Maio";
			case 6 : return "Junho";
			case 7 : return "Julho";
			case 8 : return "Agosto";
			case 9 : return "Setembro";
			case 10: return "Outubro";
			case 11: return "Novembro";
			case 12: return "Dezembro";
			default: return "";
		}
	}
	
	/**
	 * Método estático que verifica a validade de um determinado email
	 *
	 * @access public
	 * @param string $strEmail
	 * @return mixed
	 */
	public static function verificaEmail($strEmail) {
		$strEmail = strtolower(trim($strEmail));
		if (preg_match('/^([_\.0-9a-z-]+)@(([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})$/', $strEmail, $arrEmail)) {
			$strHost	= $arrEmail[2];
			$strIP		= gethostbyname($strHost);
			if ($strHost != $strIP || getmxrr($strHost, $arrHostMx)) return $strEmail;
		}
		return false;
	}
	
	/**
	 * Método estático que retorna a frase de saudação dependendo da hora do dia
	 *
	 * @access public
	 * @return string
	 */
	public static function fraseSaudacao() {
		$intHora = date("G");
		$strFrase = "";
		if ($intHora >= 18) $strFrase = "Boa noite";
		elseif ($intHora >= 12) $strFrase = "Boa tarde";
		else $strFrase = "Bom dia";
		return $strFrase;
	}
	
	/**
	 * Método que converte o tempo e sua unidade para minutos
	 * 
	 * @param int $intSla
	 * @param String $strTempo
	 * @return int
	 */
	public static function converterTempoParaMinutos($intTempo, $strUnidade) {
		$intTempo = (int) $intTempo;
		$strUnidade = strtoupper($strUnidade);
		
		// Convertendo em Horas
		if ($strUnidade == "D") {
			$intTempo = $intTempo * 24;
			$strUnidade = "H";
		}
		
		// Convertendo em Minutos
		if ($strUnidade == "H") {
			$intTempo = $intTempo * 60;
			$strUnidade = "M";
		}
		return $intTempo;
	}
	
	/**
	 * Método que converte o tempo de Minutos para a maior Unidade possível
	 * Este método retorna um array com duas posições: tempo e unidade
	 * 
	 * @param $intMinutos
	 * @return array
	 */
	public static function converterMinutosParaTempo($intMinutos) {
		$intMinutos = (int) $intMinutos;
		$strUnidade = "M";
		$intTempo   = $intMinutos;
		
		/*
		if ($intTempo >= 24 * 60) { // Convertendo em Dias
			$intTempo = $intTempo / 60 / 24;
			$strUnidade = "D";
		}
		elseif ($intTempo >= 60) { // Convertendo em Horas
			$intTempo = $intTempo / 60;
			$strUnidade = "H";
		}
		*/
		if ($intTempo >= 60) { // Convertendo em Horas
			$intTempo = $intTempo / 60;
			$strUnidade = "H";
		}
		return array("tempo"=>round($intTempo), "unidade"=>$strUnidade);
	}
	
	/**
	 * Método que converte o tamanho de um arquivo de bytes para o formato especificado
	 * 
	 * @param $intBytes
	 * @return string
	 */
	public static function formatarBytes($intBytes) {
		$strTipo = "B";
		if ($intBytes > 1024) {
			$intBytes /= 1024;
			$strTipo = "KB";
			if ($intBytes > 1024) {
				$intBytes /= 1024;
				$strTipo = "MB";
				if ($intBytes > 1024) {
					$intBytes /= 1024;
					$strTipo = "GB";
				}
			}
		}
		return array($intBytes, $strTipo);
	}
}