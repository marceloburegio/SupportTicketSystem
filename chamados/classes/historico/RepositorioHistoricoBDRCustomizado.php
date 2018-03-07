<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioHistoricoBDRCustomizado extends RepositorioHistoricoBDR {
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
	 * @param Historico $objHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Historico $objHistorico) {
			if ($objHistorico != null) {
			$strSql = "
				INSERT INTO historico (
					id_chamado,
					id_usuario,
					tipo_historico,
					descricao_historico,
					data_historico,
					nome_arquivo_anexo,
					caminho_arquivo_anexo
				)
				VALUES (
					". $this->objPDO->quote($objHistorico->getIdChamado()) .",
					". $this->objPDO->quote($objHistorico->getIdUsuario()) .",
					". $this->objPDO->quote($objHistorico->getTipoHistorico()) .",
					". $this->objPDO->quote($objHistorico->getDescricaoHistorico()) .",
					". $this->objPDO->quote($objHistorico->getDataHistorico()) .",
					". $this->objPDO->quote($objHistorico->getNomeArquivoAnexo()) .",
					". $this->objPDO->quote($objHistorico->getCaminhoArquivoAnexo()) ."
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
			throw new HistoricoNaoCadastradoException(null);
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
				id_historico,
				id_chamado,
				id_usuario,
				tipo_historico,
				descricao_historico,
				data_historico,
				nome_arquivo_anexo,
				caminho_arquivo_anexo
			FROM historico
			WHERE id_historico IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjHistorico = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrObjHistorico[] = new Historico($arrResult["id_historico"], $arrResult["id_chamado"], $arrResult["id_usuario"], $arrResult["tipo_historico"], $arrResult["descricao_historico"], $arrResult["data_historico"], $arrResult["nome_arquivo_anexo"], $arrResult["caminho_arquivo_anexo"]);
				}
			}
			return $arrObjHistorico;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que lista todos os Historicos pertencentes ao Chamado informado
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
			ORDER BY data_historico ASC";
		return $this->listar($strSql);
	}

	/**
	 * Método que lista todos os Historicos pertencentes ao Chamado informado (ordenado recentes)
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdChamadoOrdenadoRecentes($intIdChamado, $strComplemento="") {
		$intIdChamado = (int) $intIdChamado;
		
		$strSql = "
			AND id_chamado = ". $this->objPDO->quote($intIdChamado) ."
			$strComplemento
			ORDER BY data_historico DESC";
		return $this->listar($strSql);
	}
	
	/**
	 * Método que ira verificar se o usuario já leu o chamado do tipo especificado
	 * 
	 * @param int $intIdUsuario
	 * @param int $intIdChamado
	 * @param int $intTipoHistorico
	 * @return boolean
	 */
	public function existePorIdUsuarioPorIdChamadoPorTipo($intIdUsuario, $intIdChamado, $intTipoHistorico){
		$intIdUsuario		= (int) $intIdUsuario;
		$intIdChamado		= (int) $intIdChamado;
		$intTipoHistorico	= (int) $intTipoHistorico;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM historico
			WHERE id_chamado = ". $this->objPDO->quote($intIdChamado) ."
			AND id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
			AND tipo_historico = ". $this->objPDO->quote($intTipoHistorico) ."";
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