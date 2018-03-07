<?php
/**
 * Repositório de objetos Assunto
 * Esta classe implementa a interface IRepositorioAssunto
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:27:43
 */
class RepositorioAssuntoBDR implements IRepositorioAssunto {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoAssunto
	 */
	protected $objConexaoAssunto;
	
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
		$this->objConexaoAssunto = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoAssunto->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Assunto $objAssunto) {
		if ($objAssunto != null) {
			$intStatusAssunto = ($objAssunto->getStatusAssunto()) ? 1 : 0;
			$strSql = "
				INSERT INTO assunto (
					id_assunto,
					id_grupo,
					descricao_assunto,
					status_assunto,
					sla,
					alerta_chamado,
					formato_chamado,
					url_chamado_externo
				)
				VALUES (
					". $this->objPDO->quote($objAssunto->getIdAssunto()) .",
					". $this->objPDO->quote($objAssunto->getIdGrupo()) .",
					". $this->objPDO->quote($objAssunto->getDescricaoAssunto()) .",
					". $this->objPDO->quote($intStatusAssunto) .",
					". $this->objPDO->quote($objAssunto->getSla()) .",
					". $this->objPDO->quote($objAssunto->getAlertaChamado()) .",
					". $this->objPDO->quote($objAssunto->getFormatoChamado()) .",
					". $this->objPDO->quote($objAssunto->getUrlChamadoExterno()) ."
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
			throw new AssuntoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Assunto $objAssunto) {
		if ($objAssunto != null) {
			$intStatusAssunto = ($objAssunto->getStatusAssunto()) ? 1 : 0;
			$strSql = "
				UPDATE assunto SET
					id_grupo            = ". $this->objPDO->quote($objAssunto->getIdGrupo()) .",
					descricao_assunto   = ". $this->objPDO->quote($objAssunto->getDescricaoAssunto()) .",
					status_assunto      = ". $this->objPDO->quote($intStatusAssunto) .",
					sla                 = ". $this->objPDO->quote($objAssunto->getSla()) .",
					alerta_chamado      = ". $this->objPDO->quote($objAssunto->getAlertaChamado()) .",
					formato_chamado     = ". $this->objPDO->quote($objAssunto->getFormatoChamado()) .",
					url_chamado_externo = ". $this->objPDO->quote($objAssunto->getUrlChamadoExterno()) ."
				WHERE id_assunto = ". $this->objPDO->quote($objAssunto->getIdAssunto()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new AssuntoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdAssunto) {
		$intIdAssunto = (int) $intIdAssunto;
		
		$strSql = "
			DELETE FROM assunto
			WHERE id_assunto = ". $this->objPDO->quote($intIdAssunto) ."";
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
	 * @param int $intIdAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @return Assunto
	 */
	public function procurar($intIdAssunto) {
		$intIdAssunto = (int) $intIdAssunto;
		
		$strSql ="
			AND id_assunto = ". $this->objPDO->quote($intIdAssunto) ."";
		$arrObjAssunto = $this->listar($strSql);
		if (!empty($arrObjAssunto) && is_array($arrObjAssunto)) {
			return $arrObjAssunto[0];
		}
		else {
			throw new AssuntoNaoCadastradoException($intIdAssunto);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdAssunto) {
		$intIdAssunto = (int) $intIdAssunto;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM assunto
			WHERE id_assunto = ". $this->objPDO->quote($intIdAssunto) ."";
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
				id_assunto,
				id_grupo,
				descricao_assunto,
				status_assunto,
				sla,
				alerta_chamado,
				formato_chamado,
				url_chamado_externo
			FROM assunto
			WHERE id_assunto IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjAssunto = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrResult["status_assunto"] = ($arrResult["status_assunto"]) ? true : false;
					$arrObjAssunto[] = new Assunto($arrResult["id_assunto"], $arrResult["id_grupo"], $arrResult["descricao_assunto"], $arrResult["status_assunto"], $arrResult["sla"], $arrResult["alerta_chamado"], $arrResult["formato_chamado"], $arrResult["url_chamado_externo"]);
				}
			}
			return $arrObjAssunto;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}