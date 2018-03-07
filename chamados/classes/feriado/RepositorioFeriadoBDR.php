<?php
/**
 * Repositório de objetos Feriado
 * Esta classe implementa a interface IRepositorioFeriado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 26/10/2011 14:47:33
 */
class RepositorioFeriadoBDR implements IRepositorioFeriado {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoFeriado
	 */
	protected $objConexaoFeriado;
	
	/**
	 * Objeto PDO
	 *
	 * @access protected
	 * @var PDO
	 */
	protected $objPDO;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct() {
		$this->objConexaoFeriado = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoFeriado->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Feriado $objFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Feriado $objFeriado) {
		if ($objFeriado != null) {
			$strSql = "
				INSERT INTO feriado (
					id_grupo,
					data_feriado,
					descricao_feriado
				)
				VALUES (
					". $this->objPDO->quote($objFeriado->getIdGrupo()) .",
					". $this->objPDO->quote($objFeriado->getDataFeriado()) .",
					". $this->objPDO->quote($objFeriado->getDescricaoFeriado()) ."
				)";
			try {
				$this->objPDO->exec($strSql);
				return $this->objPDO->lastInsertId();
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new FeriadoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Feriado $objFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Feriado $objFeriado) {
		if ($objFeriado != null) {
			$strSql = "
				UPDATE feriado SET
					id_grupo          = ". $this->objPDO->quote($objFeriado->getIdGrupo()) .",
					data_feriado      = ". $this->objPDO->quote($objFeriado->getDataFeriado()) .",
					descricao_feriado = ". $this->objPDO->quote($objFeriado->getDescricaoFeriado()) ."
				WHERE id_feriado = ". $this->objPDO->quote($objFeriado->getIdFeriado()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new FeriadoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdFeriado) {
		$intIdFeriado = (int) $intIdFeriado;
		
		$strSql = "
			DELETE FROM feriado
			WHERE id_feriado = ". $this->objPDO->quote($intIdFeriado) ."";
		try {
			$this->objPDO->exec($strSql);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que procura um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @return Feriado
	 */
	public function procurar($intIdFeriado) {
		$intIdFeriado = (int) $intIdFeriado;
		
		$strSql ="
			AND id_feriado = ". $this->objPDO->quote($intIdFeriado) ."";
		$arrObjFeriado = $this->listar($strSql);
		if (!empty($arrObjFeriado) && is_array($arrObjFeriado)) {
			return $arrObjFeriado[0];
		}
		else {
			throw new FeriadoNaoCadastradoException($intIdFeriado);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdFeriado) {
		$intIdFeriado = (int) $intIdFeriado;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM feriado
			WHERE id_feriado = ". $this->objPDO->quote($intIdFeriado) ."";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResult = $objResult->fetch(PDO::FETCH_ASSOC);
			if (!empty($arrResult) && is_array($arrResult) && $arrResult["quantidade"] > 0) {
				return true;
			}
			else {
				return false;
			}
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que lista todos os objetos do Repositorio BDR
	 *
	 * @access public
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar($strComplemento="") {
		$strSql = "
			SELECT
				id_feriado,
				id_grupo,
				data_feriado,
				descricao_feriado
			FROM feriado
			WHERE id_feriado IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjFeriado = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrObjFeriado[] = new Feriado($arrResult["id_feriado"], $arrResult["id_grupo"], $arrResult["data_feriado"], $arrResult["descricao_feriado"]);
				}
			}
			return $arrObjFeriado;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}