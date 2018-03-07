<?php
/**
 * Classe PDO2 contendo:
 *  + Suporte ao Firebird
 *  + Suporte para transações no MSSQL
 *
 * @author Marcelo Burégio
 * @version 1.1
 * @since 10/07/2009 16:09:17
 */
class PDO2 extends PDO {
	/**
	 * Tipo da conexão realizada com o PDO (firebird, mssql, mysql, oracle)
	 * 
	 * @access private
	 * @var string
	 */
	private $strType;
	
	/**
	 * Objeto da conexão
	 *
	 * @access private
	 * @var Resource
	 */
	private $srcConnection;
	
	/**
	 * Objeto do resultado da query
	 *
	 * @access private
	 * @var Resource
	 */
	private $srcStatement;
	
	/**
	 * Identificador do atributo PDO::CASE_*
	 *
	 * @access private
	 * @var int
	 */
	private $intColumnCase;
	
	/**
	 * String que indica o código do stado do SQL (SQLSTATE)
	 *
	 * @access private
	 * @var string
	 */
	private $strSqlState;
	
	/**
	 * Código do erro do Firebird
	 *
	 * @access private
	 * @var int
	 */
	private $intErrorNo;
	
	/**
	 * Mensagem de erro do Firebird
	 *
	 * @access private
	 * @var string
	 */
	private $strErrorMsg;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct($strDSN, $strUsername = null, $strPassword = null, $arrDriverOptions = array()) {
		// Limpando as variáveis de erro
		$this->__storeError();
		
		// Verificando qual tipo de base foi inicializado
		if (preg_match("/^([^:]+):(.+)$/i", $strDSN, $arrDSN)) {
			
			// Armazenando o tipo da base de dados
			$this->strType = $arrDSN[1];
			
			// Verificando se o PDO inicializado é para o Firebird
			if ($this->strType == "firebird") {
				
				// Armazenando os parametros padrões
				$this->intColumnCase = PDO::CASE_NATURAL;
				
				// Obtendo o nome (caminho) do banco de dados
				if (preg_match("/dbname=([^;]*)/i", $arrDSN[2], $arrDatabase)) $strDatabase = $arrDatabase[1];
				
				// Conectando ao banco de dados Firebird usando a API do PHP
				if ($srcConnection = @ibase_connect($strDatabase, $strUsername, $strPassword)) $this->srcConnection = $srcConnection;
				else {
					// Armazenando o erro e levantando a PDOException
					$strErrorMsg = @$this->__storeError("28000", ibase_errcode(), ibase_errmsg());
					throw new PDOException($strErrorMsg);
				}
			}
			else {
				// Inicializando o PDO para os outros bancos
				parent::__construct($strDSN, $strUsername, $strPassword, $arrDriverOptions);
			}
		}
	}
	
	/**
	 * Método que inicia uma transação no BDR
	 *
	 * @access public
	 * @return boolean
	 */
	public function beginTransaction() {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Limpando as variáveis de erro
			$this->__storeError();
			if (@ibase_trans($this->srcConnection)) return true;
			else {
				
				// Armazenando o erro e levantando a PDOException
				$strErrorMsg = @$this->__storeError("28000", ibase_errcode(), ibase_errmsg());
				throw new PDOException($strErrorMsg);
			}
		}
		else return parent::beginTransaction();
	}
	
	/**
	 * Método que compromete uma transação no BDR
	 *
	 * @access public
	 * @return boolean
	 */
	public function commit() {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Limpando as variáveis de erro
			$this->__storeError();
			if (@ibase_commit($this->srcConnection)) return true;
			else {
				
				// Armazenando o erro e levantando a PDOException
				$strErrorMsg = @$this->__storeError("28000", ibase_errcode(), ibase_errmsg());
				throw new PDOException($strErrorMsg);
			}
		}
		else return parent::commit();
	}
	
	/**
	 * Método que retorna o código de erro (SQLSTATE) da última execução ao BDR
	 *
	 * @access public
	 * @return int
	 */
	public function errorCode() {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			return (empty($this->strSqlState)) ? null : $strSqlState;
		}
		else return parent::errorCode();
	}
	
	/**
	 * Método que retorna a mensagem de erro da última execução ao BDR
	 *
	 * @access public
	 * @return string
	 */
	public function errorInfo() {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			$arrErroInfo = array();
			if (empty($this->strSqlState)) $arrErroInfo[] = "";
			else {
				$arrErrorInfo[] = $this->strSqlState;
				$arrErrorInfo[] = $this->intErrorNo;
				$arrErrorInfo[] = $this->strErrorMsg;
			}
			return $arrErrorInfo;
		}
		else return parent::errorInfo();
	}
	
	/**
	 * Método que executa uma consulta no BDR
	 * Retorna o número de linhas afetadas
	 *
	 * @access public
	 * @param string $strStatement
	 * @return int
	 */
	public function exec($strStatement) {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Limpando os erros
			$this->__storeError();
			
			// Executando a consulta na base do firebird
			if (@ibase_query($this->srcConnection, $strStatement)) return @ibase_affected_rows($this->srcConnection);
			else {
				
				// Armazenando o erro e levantando a PDOException
				$strErrorMsg = @$this->__storeError("42000", ibase_errcode(), ibase_errmsg());
				throw new PDOException($strErrorMsg);
			}
		}
		else return parent::exec($strStatement);
	}
	
	/**
	 * Método que retorna o último id inserido no BDR
	 *
	 * @access public
	 * @return int
	 */
	public function lastInsertId($seqname = NULL) {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Armazenando o erro e levantando a PDOException
			$this->__storeError("IM001");
			throw new PDOException("SQLSTATE[IM001]: Driver does not support this function: driver does not support lastInsertId()");
		}
		else return parent::lastInsertId($seqname);
	}
	
	/**
	 * Método que prepara uma query para ser executa no BDR
	 *
	 * @access public
	 * @param string $strStatement
	 * @param array $arrDriverOptions = array()
	 * @return PDO2Statement
	 */
	public function prepare($strStatement, $arrDriverOptions = array()) {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Limpando os erros
			$this->__storeError();
			
			// Preparando uma query na base do Firebird
			if ($srcStatement = @ibase_prepare($this->srcConnection, $strStatement)) {
				$this->srcStatement = $srcStatement;
				return new PDO2Statement($this);
			}
			else {
				// Armazenando o erro e levantando a PDOException
				$strErrorMsg = @$this->__storeError("42000", ibase_errcode(), ibase_errmsg());
				throw new PDOException($strErrorMsg);
			}
		}
		else return parent::prepare($strStatement, $arrDriverOptions);
	}
	
	/**
	 * Método que executa uma query no BDR
	 *
	 * @access public
	 * @param string $strStatement
	 * @return PDO2Statement
	 */
	public function query($strStatement) {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Limpando os erros
			$this->__storeError();
			
			// Preparando uma query na base do Firebird
			if ($srcStatement = @ibase_query($this->srcConnection, $strStatement)) {
				$this->srcStatement = $srcStatement;
				return new PDO2Statement($this);
			}
			else {
				// Armazenando o erro e levantando a PDOException
				$strErrorMsg = @$this->__storeError("42000", ibase_errcode(), ibase_errmsg());
				throw new PDOException($strErrorMsg);
			}
		}
		else return parent::query($strStatement);
	}
	
	/**
	 * Método que desfaz uma transação no BDR
	 *
	 * @access public
	 * @return boolean
	 */
	public function rollBack() {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Limpando as variáveis de erro
			$this->__storeError();
			if (@ibase_rollback($this->srcConnection)) return true;
			else {
				
				// Armazenando o erro e levantando a PDOException
				$strErrorMsg = @$this->__storeError("28000", ibase_errcode(), ibase_errmsg());
				throw new PDOException($strErrorMsg);
			}
		}
		else return parent::rollBack();
	}
	
	/**
	 * Método que define um atributo/propriedade para o PDO
	 *
	 * @access public
	 * @param int $intAttribute
	 * @param mix $mixValue
	 * @return boolean
	 */
	public function setAttribute($intAttribute, $mixValue) {
		// Verificando se é uma base firebird
		if ($this->strType == "firebird") {
			
			// Limpando as variáveis de erro
			$this->__storeError();
			
			// Armazenando o atributo de case
			if ($intAttribute == PDO::ATTR_CASE) $this->intColumnCase = $mixValue;
			return true;
		}
		return parent::setAttribute($intAttribute, $mixValue);
	}
	
	/**
	 * Método privado que armazena os dados de erro de conexão
	 * Retorna uma string já formatada com a string do SQLSTATE
	 *
	 * @access public
	 * @param string $strSqlState = "00000"
	 * @param int $intErrorNo = 0
	 * @param string $strErrorMsg = ""
	 * @return string
	 */
	private function __storeError($strSqlState = "00000", $intErrorNo = 0, $strErrorMsg = "") {
		// Armazenando os parametros no objeto
		$this->strSqlState = (string) $strSqlState;
		$this->intErrorNo  = (int) $intErrorNo;
		$this->strErrorMsg = (string) $strErrorMsg;
		
		// Retornando a linha contendo a mensagem de erro armazenada
		return "SQLSTATE[". $this->strSqlState ."] [". $this->intErrorNo ."] ". $this->strErrorMsg;
	}
	
	/**
	 * Método que indica se a base da instância é Firebird ou não
	 *
	 * @access public
	 * @return boolean
	 */
	public function __isFirebird() {
		return ($this->strType == "firebird");
	}
	
	/**
	 * Método que retorna o tipo de CASE das chaves das colunas
	 *
	 * @access public
	 * @return int
	 */
	public function __getColumnCase() {
		return $this->intColumnCase;
	}
	
	/**
	 * Método que retorna o resource de uma query ou prepare para o PDOStatement
	 *
	 * @access public
	 * @return resource
	 */
	public function __getStatement() {
		return $this->srcStatement;
	}
}
/**
 * Classe PDO2Statement com as funcionalidades para o Firebird - WORKARROUND
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 06/11/2008 16:09:17
 */
class PDO2Statement extends PDOStatement {
	/**
	 * Objeto da classe PDO
	 *
	 * @access private
	 * @var PDO2
	 */
	private $objPDO;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct(PDO2 $objPDO) {
		$this->objPDO = $objPDO;
	}
	
	/**
	 * Método que retorna todos os registros do Statement em forma de array
	 *
	 * @access public
	 * @param int $intFetchStyle = PDO::FETCH_BOTH
	 * @param int $intColumnIndex = 0
	 * @param array $arrCtorArgs = array()
	 * @return array
	 */
	public function fetchAll($intFetchStyle = PDO::FETCH_BOTH, $intColumnIndex = 0, $arrCtorArgs = array()) {
		// Verificando se é uma base firebird
		if ($this->objPDO->__isFirebird()) {
			
			// Lendo todos os dados
			$arrFetchAllData = array();
			while ($arrFetchData = $this->fetch($intFetchStyle)) $arrFetchAllData[] = $arrFetchData;
			return $arrFetchAllData;
		}
		else return parent::fetchAll($intFetchStyle, $intColumnIndex, $arrCtorArgs);
	}
	
	/**
	 * Método que retorna o registro ponteirado do Statement em forma de array
	 *
	 * @access public
	 * @param int $intFetchStyle = PDO::FETCH_BOTH
	 * @param int $intCursorOrientation = PDO::FETCH_ORI_NEXT
	 * @param int $intCursorOffset = 0
	 * @return array
	 */
	public function fetch($intFetchStyle = PDO::FETCH_BOTH, $intCursorOrientation = PDO::FETCH_ORI_NEXT, $intCursorOffset = 0) {
		// Verificando se é uma base firebird
		if ($this->objPDO->__isFirebird()) {
			
			// Lendo apenas um registro do ponteiro
			if ($arrFetchData = @ibase_fetch_assoc($this->objPDO->__getStatement())) {
				$arrFetchRow = array();
				
				// Verificando se o Fetch Style apresenta associaçao textual
				if ($intFetchStyle == PDO::FETCH_BOTH || $intFetchStyle = PDO::FETCH_ASSOC) {
					if ($this->objPDO->__getColumnCase() == PDO::CASE_UPPER) $arrFetchData = array_change_key_case($arrFetchData, CASE_UPPER);
					if ($this->objPDO->__getColumnCase() == PDO::CASE_LOWER) $arrFetchData = array_change_key_case($arrFetchData, CASE_LOWER);
					$arrFetchRow = array_merge($arrFetchRow, $arrFetchData);
				}
				
				// Verificando se o Fetch Style apresenta associação numérica
				if ($intFetchStyle == PDO::FETCH_BOTH || $intFetchStyle == PDO::FETCH_NUM) {
					$arrFetchRow = array_merge($arrFetchRow, array_values($arrFetchData));
				}
				return $arrFetchRow;
			}
			return false;
		}
		else return parent::fetch($intFetchStyle, $intCursorOrientation, $intCursorOffset);
	}
}