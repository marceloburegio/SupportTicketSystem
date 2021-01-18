<?php
/**
 * Devolve ao invocador a instância da conexão desejada.
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 06/11/2008 16:09:17
 */
class ConexaoBDR {
	/**
	 * Conexão PDO do sistema
	 *
	 * @access private
	 * @var PDO
	 */
	private $objPDO;
	
	/**
	 * Array de instâncias de bases de dados
	 *
	 * @access private
	 * @var array
	 */
	private static $arrInstances = array();
	
	/**
	 * Método construtor da classe
	 *
	 * @access private
	 * @param string $strDatabase
	 */
	private function __construct($strDatabase) {
		// Definindo os parametros de conexão
		$strType = "";
		switch ($strDatabase) {
			case "sistema" :
				$strHost = "127.0.0.1";
				$strUser = "root";
				$strPass = "";
				$strBase = "chamados";
				$strType = "mysql";
				$strDSN  = "{$strType}:host={$strHost};dbname={$strBase}";
				break;
		}
		try {
			$this->objPDO = new PDO2(@$strDSN, @$strUser, @$strPass);
			$this->objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ($strType == "sqlsrv") $this->objPDO->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_SYSTEM);
			if ($strType == "oci") $this->objPDO->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		}
		catch(Exception $ex) {
			throw new RepositorioException("Nao foi possivel conectar ao banco de dados: ". $ex->getMessage());
		}
	}
	
	/**
	 * Método estático que obtem uma instância da conexão solicitada
	 *
	 * @access public
	 * @param string $strDatabase
	 */
	public static function getInstancia($strDatabase) {
		// Inicializando uma instância
		if (empty(self::$arrInstances[$strDatabase])) {
			self::$arrInstances[$strDatabase] = new ConexaoBDR($strDatabase);
		}
		// Retornando a instância da base do array de instâncias
		return self::$arrInstances[$strDatabase];
	}
	
	/**
	 * Retornando o valor de <var>$this->objPDO</var>
	 *
	 * @access public
	 * @return PDO
	 */
	public function getConexao() {
		return $this->objPDO;
	}
}