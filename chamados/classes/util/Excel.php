<?php
/**
 * Classe para a criação de planilhas Excel (.xls)
 *
 * @author Marcelo Burégio
 * @subpackage util
 * @version 1.0
 * @since 26/11/2008 15:50:27
 */
class Excel {
	/**
	 * Conteúdo da planilha em Excel
	 *
	 * @access private
	 * @var string
	 **/
	private $strContents;
	
	/**
	 * Contém a ultima linha adicionada na planilha
	 *
	 * @access private
	 * @var string
	 **/
	private $intLastLine;
	
	/**
	 * Método construtor da classe
	 * 
	 * @access private
	 */
	public function __construct() {
		$this->strContents = "";
		$this->intLastLine = 0;
	}
	
	/**
	 * Método que adiciona um valor a uma determinada linha x coluna da planilha
	 *
	 * @access public
	 * @param int $intLine
	 * @param int $intColumn
	 * @param string $strValue
	 * @return void
	 */
	public function addValue($intLine, $intColumn, $strValue) {
		$intSize = strlen($strValue);
		$this->strContents .= pack("v*", 0x0204, 8 + $intSize, $intLine, $intColumn, 0x00, $intSize);
		$this->strContents .= $strValue;
	}
	
	/**
	 * Método que adiciona uma linha com um array de valores
	 *
	 * @access public
	 * @param string $arrValues
	 * @return void
	 */
	public function addLine($arrValues) {
		$intLine = $this->intLastLine;
		$intColumn = 0;
		foreach ($arrValues as $strValue) {
			$this->addValue($intLine, $intColumn, $strValue);
			$intColumn++;
		}
		$this->intLastLine++;
	}
	
	/**
	 * Método que obtém o conteúdo total da planilha
	 *
	 * @access public
	 * @return string
	 */
	public function getContents() {
		$strContents  = pack("vvvvvv", 0x809, 0x08, 0x00, 0x10, 0x0, 0x0); // Head do arquivo Excel
		$strContents .= $this->strContents;
		$strContents .= pack("vv", 0x0A, 0x00); // EOF do arquivo Excel
		return $strContents;
	}
	
}