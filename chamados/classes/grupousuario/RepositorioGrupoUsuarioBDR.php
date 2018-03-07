<?php
/**
 * Repositório de objetos GrupoUsuario
 * Esta classe implementa a interface IRepositorioGrupoUsuario
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:31:38
 */
class RepositorioGrupoUsuarioBDR implements IRepositorioGrupoUsuario {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoGrupoUsuario
	 */
	protected $objConexaoGrupoUsuario;
	
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
		$this->objConexaoGrupoUsuario = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoGrupoUsuario->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param GrupoUsuario $objGrupoUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(GrupoUsuario $objGrupoUsuario) {
		if ($objGrupoUsuario != null) {
			$intFlagAdmin = ($objGrupoUsuario->getFlagAdmin()) ? 1 : 0;
			$strSql = "
				INSERT INTO grupo_usuario (
					id_grupo,
					id_usuario,
					flag_admin
				)
				VALUES (
					". $this->objPDO->quote($objGrupoUsuario->getIdGrupo()) .",
					". $this->objPDO->quote($objGrupoUsuario->getIdUsuario()) .",
					". $this->objPDO->quote($intFlagAdmin) ."
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
			throw new GrupoUsuarioNaoCadastradoException(null, null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param GrupoUsuario $objGrupoUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(GrupoUsuario $objGrupoUsuario) {
		if ($objGrupoUsuario != null) {
			$intFlagAdmin = ($objGrupoUsuario->getFlagAdmin()) ? 1 : 0;
			$strSql = "
				UPDATE grupo_usuario SET
					flag_admin = ". $this->objPDO->quote($intFlagAdmin) ."
				WHERE id_grupo = ". $this->objPDO->quote($objGrupoUsuario->getIdGrupo()) ."
				AND id_usuario = ". $this->objPDO->quote($objGrupoUsuario->getIdUsuario()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new GrupoUsuarioNaoCadastradoException(null, null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdGrupo, $intIdUsuario) {
		$intIdGrupo = (int) $intIdGrupo;
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql = "
			DELETE FROM grupo_usuario
			WHERE id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
			AND id_usuario = ". $this->objPDO->quote($intIdUsuario) ."";
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
	 * @param int $intIdUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @return GrupoUsuario
	 */
	public function procurar($intIdGrupo, $intIdUsuario) {
		$intIdGrupo = (int) $intIdGrupo;
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql ="
			AND id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
			AND id_usuario = ". $this->objPDO->quote($intIdUsuario) ."";
		$arrObjGrupoUsuario = $this->listar($strSql);
		if (!empty($arrObjGrupoUsuario) && is_array($arrObjGrupoUsuario)) {
			return $arrObjGrupoUsuario[0];
		}
		else {
			throw new GrupoUsuarioNaoCadastradoException($intIdGrupo, $intIdUsuario);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdGrupo, $intIdUsuario) {
		$intIdGrupo = (int) $intIdGrupo;
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM grupo_usuario
			WHERE id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
			AND id_usuario = ". $this->objPDO->quote($intIdUsuario) ."";
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
				id_usuario,
				flag_admin
			FROM grupo_usuario
			WHERE id_grupo IS NOT NULL
			AND id_usuario IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjGrupoUsuario = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrResult["flag_admin"] = ($arrResult["flag_admin"]) ? true : false;
					$arrObjGrupoUsuario[] = new GrupoUsuario($arrResult["id_grupo"], $arrResult["id_usuario"], $arrResult["flag_admin"]);
				}
			}
			return $arrObjGrupoUsuario;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}