<?php
/**
 * Repositório de objetos Grupo
 * Esta classe implementa a interface IRepositorioGrupo
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:31:07
 */
class RepositorioGrupoBDR implements IRepositorioGrupo {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoGrupo
	 */
	protected $objConexaoGrupo;
	
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
		$this->objConexaoGrupo = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoGrupo->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Grupo $objGrupo
	 * @throws GrupoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Grupo $objGrupo) {
		if ($objGrupo != null) {
			$intStatusGrupo = ($objGrupo->getStatusGrupo()) ? 1 : 0;
			$intFlagRecebeChamado = ($objGrupo->getFlagRecebeChamado()) ? 1 : 0;
			$strSql = "
				INSERT INTO grupo (
					id_grupo,
					descricao_grupo,
					email_grupo,
					status_grupo,
					flag_recebe_chamado
				)
				VALUES (
					". $this->objPDO->quote($objGrupo->getIdGrupo()) .",
					". $this->objPDO->quote($objGrupo->getDescricaoGrupo()) .",
					". $this->objPDO->quote($objGrupo->getEmailGrupo()) .",
					". $this->objPDO->quote($intStatusGrupo) .",
					". $this->objPDO->quote($intFlagRecebeChamado) ."
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
			throw new GrupoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Grupo $objGrupo
	 * @throws GrupoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Grupo $objGrupo) {
		if ($objGrupo != null) {
			$intStatusGrupo = ($objGrupo->getStatusGrupo()) ? 1 : 0;
			$intFlagRecebeChamado = ($objGrupo->getFlagRecebeChamado()) ? 1 : 0;
			$strSql = "
				UPDATE grupo SET
					descricao_grupo     = ". $this->objPDO->quote($objGrupo->getDescricaoGrupo()) .",
					email_grupo         = ". $this->objPDO->quote($objGrupo->getEmailGrupo()) .",
					status_grupo        = ". $this->objPDO->quote($intStatusGrupo) .",
					flag_recebe_chamado = ". $this->objPDO->quote($intFlagRecebeChamado) ."
				WHERE id_grupo = ". $this->objPDO->quote($objGrupo->getIdGrupo()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new GrupoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdGrupo) {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql = "
			DELETE FROM grupo
			WHERE id_grupo = ". $this->objPDO->quote($intIdGrupo) ."";
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
	 * @param int $intIdGrupo
	 * @throws GrupoNaoCadastradoException
	 * @return Grupo
	 */
	public function procurar($intIdGrupo) {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql ="
			AND id_grupo = ". $this->objPDO->quote($intIdGrupo) ."";
		$arrObjGrupo = $this->listar($strSql);
		if (!empty($arrObjGrupo) && is_array($arrObjGrupo)) {
			return $arrObjGrupo[0];
		}
		else {
			throw new GrupoNaoCadastradoException($intIdGrupo);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdGrupo) {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM grupo
			WHERE id_grupo = ". $this->objPDO->quote($intIdGrupo) ."";
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
				id_grupo,
				descricao_grupo,
				email_grupo,
				status_grupo,
				flag_recebe_chamado
			FROM grupo
			WHERE id_grupo IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjGrupo = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrResult["status_grupo"] = ($arrResult["status_grupo"]) ? true : false;
					$arrResult["flag_recebe_chamado"] = ($arrResult["flag_recebe_chamado"]) ? true : false;
					$arrObjGrupo[] = new Grupo($arrResult["id_grupo"], $arrResult["descricao_grupo"], $arrResult["email_grupo"], $arrResult["status_grupo"], $arrResult["flag_recebe_chamado"]);
				}
			}
			return $arrObjGrupo;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}