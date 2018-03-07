<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioGrupoBDRCustomizado extends RepositorioGrupoBDR {
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
					descricao_grupo,
					email_grupo,
					status_grupo,
					flag_recebe_chamado
				)
				VALUES (
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
	 * Método que lista todos os objetos do Repositorio BDR
	 *
	 * @access public
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar($strComplemento="") {
		$strSql = "
			$strComplemento
			ORDER BY descricao_grupo ASC";
		return parent::listar($strSql);
	}
	
	/**
	 * Método que lista todos os Grupos Ativos do Repositorio BDR
	 *
	 * @access public
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivos($strComplemento="") {
		$strSql = "
			AND status_grupo = 1
			$strComplemento";
		return $this->listar($strSql);
	}
	
	/**
	 * Método que lista todos os Grupos Ativos que Rebecem Chamados do Repositorio BDR
	 *
	 * @access public
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosQueRecebemChamados($strComplemento=""){
		$strSql = "
			$strComplemento
			AND flag_recebe_chamado = 1";
		return $this->listarAtivos($strSql);
	}
	
	/**
	 * Método que lista todos os Grupos Ativos Pertencentes ao Usuário informado
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosNormalPorIdUsuario($intIdUsuario, $strComplemento="") {
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql = "
			AND EXISTS (
				SELECT *
				FROM grupo_usuario
				WHERE grupo_usuario.id_grupo = grupo.id_grupo
				AND grupo_usuario.id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
			)
			$strComplemento";
		return $this->listarAtivos($strSql);
	}
	
	/**
	 * Método que lista todos os Grupos Ativos Administrados pelo Usuário informado
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosAdminPorIdUsuario($intIdUsuario, $strComplemento="") {
		$intIdUsuario = (int) $intIdUsuario;
		
		$strSql = "
			AND EXISTS (
				SELECT *
				FROM grupo_usuario
				WHERE grupo_usuario.id_grupo = grupo.id_grupo
				AND grupo_usuario.id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
				AND grupo_usuario.flag_admin = 1
			)
			$strComplemento";
		return $this->listarAtivos($strSql);
	}
}