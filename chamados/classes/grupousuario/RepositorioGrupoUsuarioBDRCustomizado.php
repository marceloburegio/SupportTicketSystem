<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioGrupoUsuarioBDRCustomizado extends RepositorioGrupoUsuarioBDR {
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Método que remove todas os Usuários do Grupo especificado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return void
	 */
	public function removerPorIdGrupo($intIdGrupo) {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql = "
			DELETE FROM grupo_usuario
			WHERE id_grupo = ". $this->objPDO->quote($intIdGrupo);
		try {
			$this->objPDO->exec($strSql);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
}