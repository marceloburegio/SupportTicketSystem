<?php
/**
 * Repositório de objetos Historico
 * Esta classe implementa a interface IRepositorioHistorico
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:31:48
 */
class RepositorioHistoricoBDR implements IRepositorioHistorico {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoHistorico
	 */
	protected $objConexaoHistorico;
	
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
		$this->objConexaoHistorico = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoHistorico->getConexao();
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
					id_historico,
					id_chamado,
					id_usuario,
					tipo_historico,
					descricao_historico,
					data_historico,
					nome_arquivo_anexo,
					caminho_arquivo_anexo
				)
				VALUES (
					". $this->objPDO->quote($objHistorico->getIdHistorico()) .",
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
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Historico $objHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Historico $objHistorico) {
		if ($objHistorico != null) {
			$strSql = "
				UPDATE historico SET
					id_chamado            = ". $this->objPDO->quote($objHistorico->getIdChamado()) .",
					id_usuario            = ". $this->objPDO->quote($objHistorico->getIdUsuario()) .",
					tipo_historico        = ". $this->objPDO->quote($objHistorico->getTipoHistorico()) .",
					descricao_historico   = ". $this->objPDO->quote($objHistorico->getDescricaoHistorico()) .",
					data_historico        = ". $this->objPDO->quote($objHistorico->getDataHistorico()) .",
					nome_arquivo_anexo    = ". $this->objPDO->quote($objHistorico->getNomeArquivoAnexo()) .",
					caminho_arquivo_anexo = ". $this->objPDO->quote($objHistorico->getCaminhoArquivoAnexo()) ."
				WHERE id_historico = ". $this->objPDO->quote($objHistorico->getIdHistorico()) ."";
			try {
				$this->objPDO->exec($strSql);
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
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdHistorico) {
		$intIdHistorico = (int) $intIdHistorico;
		
		$strSql = "
			DELETE FROM historico
			WHERE id_historico = ". $this->objPDO->quote($intIdHistorico) ."";
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
	 * @param int $intIdHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @return Historico
	 */
	public function procurar($intIdHistorico) {
		$intIdHistorico = (int) $intIdHistorico;
		
		$strSql ="
			AND id_historico = ". $this->objPDO->quote($intIdHistorico) ."";
		$arrObjHistorico = $this->listar($strSql);
		if (!empty($arrObjHistorico) && is_array($arrObjHistorico)) {
			return $arrObjHistorico[0];
		}
		else {
			throw new HistoricoNaoCadastradoException($intIdHistorico);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdHistorico) {
		$intIdHistorico = (int) $intIdHistorico;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM historico
			WHERE id_historico = ". $this->objPDO->quote($intIdHistorico) ."";
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
	
}