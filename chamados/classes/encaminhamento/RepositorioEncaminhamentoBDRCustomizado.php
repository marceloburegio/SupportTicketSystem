<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioEncaminhamentoBDRCustomizado extends RepositorioEncaminhamentoBDR {
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
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
					id_chamado,
					id_usuario_origem,
					id_grupo_destino,
					id_usuario_destino,
					data_encaminhamento
				)
				VALUES (
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
	
	/**
	 * Método que lista todos os Encaminhamentos pertencentes ao Chamado informado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdChamado($intIdChamado, $strComplemento="") {
		$intIdChamado = (int) $intIdChamado;
		
		$strSql = "
			AND id_chamado = ". $this->objPDO->quote($intIdChamado) ."
			$strComplemento
			ORDER BY data_encaminhamento ASC";
		return $this->listar($strSql);
	}
	
	/**
	 * Método que verifica a existencia de algum encaminhamento por chamado no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existePorIdChamado($intIdChamado) {
		$intIdChamado = (int) $intIdChamado;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM encaminhamento
			WHERE id_chamado = ". $this->objPDO->quote($intIdChamado);
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
}