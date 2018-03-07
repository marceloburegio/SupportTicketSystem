<?php
/**
 * Repositório de objetos Encaminhamento
 * Esta classe implementa a interface IRepositorioEncaminhamento
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:30:55
 */
class RepositorioEncaminhamentoBDR implements IRepositorioEncaminhamento {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoEncaminhamento
	 */
	protected $objConexaoEncaminhamento;
	
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
		$this->objConexaoEncaminhamento = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoEncaminhamento->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Encaminhamento $objEncaminhamento) {
		if ($objEncaminhamento != null) {
			$strSql = "
				INSERT INTO encaminhamento (
					id_encaminhamento,
					id_chamado,
					id_usuario_origem,
					id_grupo_destino,
					id_usuario_destino,
					data_encaminhamento
				)
				VALUES (
					". $this->objPDO->quote($objEncaminhamento->getIdEncaminhamento()) .",
					". $this->objPDO->quote($objEncaminhamento->getIdChamado()) .",
					". $this->objPDO->quote($objEncaminhamento->getIdUsuarioOrigem()) .",
					". $this->objPDO->quote($objEncaminhamento->getIdGrupoDestino()) .",
					". $this->objPDO->quote($objEncaminhamento->getIdUsuarioDestino()) .",
					". $this->objPDO->quote($objEncaminhamento->getDataEncaminhamento()) ."
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
			throw new EncaminhamentoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Encaminhamento $objEncaminhamento) {
		if ($objEncaminhamento != null) {
			$strSql = "
				UPDATE encaminhamento SET
					id_chamado          = ". $this->objPDO->quote($objEncaminhamento->getIdChamado()) .",
					id_usuario_origem   = ". $this->objPDO->quote($objEncaminhamento->getIdUsuarioOrigem()) .",
					id_grupo_destino    = ". $this->objPDO->quote($objEncaminhamento->getIdGrupoDestino()) .",
					id_usuario_destino  = ". $this->objPDO->quote($objEncaminhamento->getIdUsuarioDestino()) .",
					data_encaminhamento = ". $this->objPDO->quote($objEncaminhamento->getDataEncaminhamento()) ."
				WHERE id_encaminhamento = ". $this->objPDO->quote($objEncaminhamento->getIdEncaminhamento()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new EncaminhamentoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdEncaminhamento) {
		$intIdEncaminhamento = (int) $intIdEncaminhamento;
		
		$strSql = "
			DELETE FROM encaminhamento
			WHERE id_encaminhamento = ". $this->objPDO->quote($intIdEncaminhamento) ."";
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
	 * @param int $intIdEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @return Encaminhamento
	 */
	public function procurar($intIdEncaminhamento) {
		$intIdEncaminhamento = (int) $intIdEncaminhamento;
		
		$strSql ="
			AND id_encaminhamento = ". $this->objPDO->quote($intIdEncaminhamento) ."";
		$arrObjEncaminhamento = $this->listar($strSql);
		if (!empty($arrObjEncaminhamento) && is_array($arrObjEncaminhamento)) {
			return $arrObjEncaminhamento[0];
		}
		else {
			throw new EncaminhamentoNaoCadastradoException($intIdEncaminhamento);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdEncaminhamento) {
		$intIdEncaminhamento = (int) $intIdEncaminhamento;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM encaminhamento
			WHERE id_encaminhamento = ". $this->objPDO->quote($intIdEncaminhamento) ."";
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
				id_encaminhamento,
				id_chamado,
				id_usuario_origem,
				id_grupo_destino,
				id_usuario_destino,
				data_encaminhamento
			FROM encaminhamento
			WHERE id_encaminhamento IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjEncaminhamento = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrObjEncaminhamento[] = new Encaminhamento($arrResult["id_encaminhamento"], $arrResult["id_chamado"], $arrResult["id_usuario_origem"], $arrResult["id_grupo_destino"], $arrResult["id_usuario_destino"], $arrResult["data_encaminhamento"]);
				}
			}
			return $arrObjEncaminhamento;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}