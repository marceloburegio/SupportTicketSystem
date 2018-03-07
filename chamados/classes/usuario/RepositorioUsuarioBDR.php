<?php
/**
 * Repositório de objetos Usuario
 * Esta classe implementa a interface IRepositorioUsuario
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:32:30
 */
class RepositorioUsuarioBDR implements IRepositorioUsuario {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoUsuario
	 */
	protected $objConexaoUsuario;
	
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
		$this->objConexaoUsuario = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoUsuario->getConexao();
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
				)
				VALUES (
					". $this->objPDO->quote($objUsuario->getIdUsuario()) .",
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
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Usuario $objUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Usuario $objUsuario) {
		if ($objUsuario != null) {
			$intStatusUsuario = ($objUsuario->getStatusUsuario()) ? 1 : 0;
			$intFlagSuperAdmin = ($objUsuario->getFlagSuperAdmin()) ? 1 : 0;
			$strSql = "
				UPDATE usuario SET
					id_setor          = ". $this->objPDO->quote($objUsuario->getIdSetor()) .",
					login             = ". $this->objPDO->quote($objUsuario->getLogin()) .",
					nome_usuario      = ". $this->objPDO->quote($objUsuario->getNomeUsuario()) .",
					email_usuario     = ". $this->objPDO->quote($objUsuario->getEmailUsuario()) .",
					ramal             = ". $this->objPDO->quote($objUsuario->getRamal()) .",
					data_cadastro     = ". $this->objPDO->quote($objUsuario->getDataCadastro()) .",
					data_alteracao    = ". $this->objPDO->quote($objUsuario->getDataAlteracao()) .",
					data_ultimo_login = ". $this->objPDO->quote($objUsuario->getDataUltimoLogin()) .",
					status_usuario    = ". $this->objPDO->quote($intStatusUsuario) .",
					flag_super_admin  = ". $this->objPDO->quote($intFlagSuperAdmin) ."
				WHERE id_usuario = ". $this->objPDO->quote($objUsuario->getIdUsuario()) ."";
			try {
				$this->objPDO->exec($strSql);
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
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdUsuario) {
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql = "
			DELETE FROM usuario
			WHERE id_usuario = ". $this->objPDO->quote($intIdUsuario) ."";
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
	 * @param int $intIdUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @return Usuario
	 */
	public function procurar($intIdUsuario) {
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql ="
			AND id_usuario = ". $this->objPDO->quote($intIdUsuario) ."";
		$arrObjUsuario = $this->listar($strSql);
		if (!empty($arrObjUsuario) && is_array($arrObjUsuario)) {
			return $arrObjUsuario[0];
		}
		else {
			throw new UsuarioNaoCadastradoException($intIdUsuario);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdUsuario) {
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM usuario
			WHERE id_usuario = ". $this->objPDO->quote($intIdUsuario) ."";
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
	
}