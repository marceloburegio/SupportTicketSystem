<?php
/**
 * Repositório de objetos Setor
 * Esta classe implementa a interface IRepositorioSetor
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:32:20
 */
class RepositorioSetorBDR implements IRepositorioSetor {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoSetor
	 */
	protected $objConexaoSetor;
	
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
		$this->objConexaoSetor = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoSetor->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Setor $objSetor
	 * @throws SetorNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Setor $objSetor) {
		if ($objSetor != null) {
			$intStatusSetor = ($objSetor->getStatusSetor()) ? 1 : 0;
			$strSql = "
				INSERT INTO setor (
					id_setor,
					descricao_setor,
					codigo_centro_custo,
					status_setor
				)
				VALUES (
					". $this->objPDO->quote($objSetor->getIdSetor()) .",
					". $this->objPDO->quote($objSetor->getDescricaoSetor()) .",
					". $this->objPDO->quote($objSetor->getCodigoCentroCusto()) .",
					". $this->objPDO->quote($intStatusSetor) ."
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
			throw new SetorNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Setor $objSetor
	 * @throws SetorNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Setor $objSetor) {
		if ($objSetor != null) {
			$intStatusSetor = ($objSetor->getStatusSetor()) ? 1 : 0;
			$strSql = "
				UPDATE setor SET
					descricao_setor     = ". $this->objPDO->quote($objSetor->getDescricaoSetor()) .",
					codigo_centro_custo = ". $this->objPDO->quote($objSetor->getCodigoCentroCusto()) .",
					status_setor        = ". $this->objPDO->quote($intStatusSetor) ."
				WHERE id_setor = ". $this->objPDO->quote($objSetor->getIdSetor()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new SetorNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdSetor) {
		$intIdSetor = (int) $intIdSetor;
		
		$strSql = "
			DELETE FROM setor
			WHERE id_setor = ". $this->objPDO->quote($intIdSetor) ."";
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
	 * @param int $intIdSetor
	 * @throws SetorNaoCadastradoException
	 * @return Setor
	 */
	public function procurar($intIdSetor) {
		$intIdSetor = (int) $intIdSetor;
		
		$strSql ="
			AND id_setor = ". $this->objPDO->quote($intIdSetor) ."";
		$arrObjSetor = $this->listar($strSql);
		if (!empty($arrObjSetor) && is_array($arrObjSetor)) {
			return $arrObjSetor[0];
		}
		else {
			throw new SetorNaoCadastradoException($intIdSetor);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdSetor) {
		$intIdSetor = (int) $intIdSetor;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM setor
			WHERE id_setor = ". $this->objPDO->quote($intIdSetor) ."";
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
				id_setor,
				descricao_setor,
				codigo_centro_custo,
				status_setor
			FROM setor
			WHERE id_setor IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjSetor = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrResult["status_setor"] = ($arrResult["status_setor"]) ? true : false;
					$arrObjSetor[] = new Setor($arrResult["id_setor"], $arrResult["descricao_setor"], $arrResult["codigo_centro_custo"], $arrResult["status_setor"]);
				}
			}
			return $arrObjSetor;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}