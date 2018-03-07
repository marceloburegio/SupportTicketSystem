<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioUsuarioBDRCustomizado extends RepositorioUsuarioBDR {
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
	 * @param Usuario $objUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Usuario $objUsuario) {
		if ($objUsuario != null) {
			$intStatusUsuario = ($objUsuario->getStatusUsuario()) ? 1 : 0;
			$intFlagSuperAdmin = ($objUsuario->getFlagSuperAdmin()) ? 1 : 0;
			$strSql = "
				INSERT INTO usuario (
					id_setor,
					login,
					nome_usuario,
					email_usuario,
					ramal,
					data_cadastro,
					data_alteracao,
					data_ultimo_login,
					status_usuario,
					flag_super_admin
				)
				VALUES (
					". $this->objPDO->quote($objUsuario->getIdSetor()) .",
					". $this->objPDO->quote($objUsuario->getLogin()) .",
					". $this->objPDO->quote($objUsuario->getNomeUsuario()) .",
					". $this->objPDO->quote($objUsuario->getEmailUsuario()) .",
					". $this->objPDO->quote($objUsuario->getRamal()) .",
					". $this->objPDO->quote($objUsuario->getDataCadastro()) .",
					". $this->objPDO->quote($objUsuario->getDataAlteracao()) .",
					". $this->objPDO->quote($objUsuario->getDataUltimoLogin()) .",
					". $this->objPDO->quote($intStatusUsuario) .",
					". $this->objPDO->quote($intFlagSuperAdmin) ."
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
			throw new UsuarioNaoCadastradoException(null);
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
				id_usuario,
				id_setor,
				login,
				nome_usuario,
				email_usuario,
				ramal,
				data_cadastro,
				data_alteracao,
				data_ultimo_login,
				status_usuario,
				flag_super_admin
			FROM usuario
			WHERE id_usuario IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjUsuario = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrResult["status_usuario"] = ($arrResult["status_usuario"]) ? true : false;
					$arrResult["flag_super_admin"] = ($arrResult["flag_super_admin"]) ? true : false;
					$arrObjUsuario[] = new Usuario($arrResult["id_usuario"], $arrResult["id_setor"], $arrResult["login"], $arrResult["nome_usuario"], $arrResult["email_usuario"], $arrResult["ramal"], $arrResult["data_cadastro"], $arrResult["data_alteracao"], $arrResult["data_ultimo_login"], $arrResult["status_usuario"], $arrResult["flag_super_admin"]);
				}
			}
			return $arrObjUsuario;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que procura um usuário pelo login no Repositorio BDR
	 *
	 * @access public
	 * @param string $strLogin
	 * @throws UsuarioNaoCadastradoException
	 * @return Usuario
	 */
	public function procurarPorLogin($strLogin) {
		$strLogin = (string) $strLogin;
		
		$strSql ="
			AND login = ". $this->objPDO->quote($strLogin);
		$arrObjUsuario = $this->listar($strSql);
		if (!empty($arrObjUsuario) && is_array($arrObjUsuario)) {
			return $arrObjUsuario[0];
		}
		else {
			throw new UsuarioNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado usuário pelo login no Repositorio BDR
	 *
	 * @access public
	 * @param string $strLogin
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existePorLogin($strLogin) {
		$strLogin = (string) $strLogin;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM usuario
			WHERE login = ". $this->objPDO->quote($strLogin);
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
	 * Método que lista todos os usuários pertencente ao grupo informado
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdGrupo($intIdGrupo, $strComplemento="") {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql = "
			AND EXISTS (
				SELECT *
				FROM grupo_usuario
				WHERE usuario.id_usuario = grupo_usuario.id_usuario
				AND grupo_usuario.id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
			)
			$strComplemento
			ORDER BY nome_usuario ASC";
		return $this->listar($strSql);
	}
	
	/**
	 * Método que lista todos os Usuários Administradores do Usuário especificado
	 * 
	 * @access public
	 * @param int $intIdUsuario
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAdminPorIdUsuario($intIdUsuario, $strComplemento="") {
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql = "
			AND id_usuario IN (
				SELECT id_usuario
				FROM grupo_usuario
				WHERE id_grupo IN (
					SELECT id_grupo
					FROM grupo_usuario
					WHERE id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
				)
				AND flag_admin = 1
			)
			$strComplemento";
		return $this->listar($strSql);
	}
	
	/**
	 * Método que lista todos os Usuários Administradores do Grupo especificado
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAdminPorIdGrupo($intIdGrupo, $strComplemento="") {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql = "
			AND id_usuario IN (
				SELECT id_usuario
				FROM grupo_usuario
				WHERE id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
				AND flag_admin = 1
			)
			$strComplemento";
		return $this->listar($strSql);
	}
}