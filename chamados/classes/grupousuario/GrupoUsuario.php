<?php
/**
 * Classe de Relacionamento entre Grupos e Usuários
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 02:53:30
 */
class GrupoUsuario {
	/**
	 * Identificador do Grupo
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupo;
	
	/**
	 * Identificador do Usuário
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuario;
	
	/**
	 * Flag Indicativa de Usuário Administrador do Grupo
	 *
	 * @access private
	 * @var boolean
	 */
	private $bolFlagAdmin;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @param boolean $bolFlagAdmin
	 */
	public function __construct($intIdGrupo, $intIdUsuario, $bolFlagAdmin) {
		$this->setIdGrupo($intIdGrupo);
		$this->setIdUsuario($intIdUsuario);
		$this->setFlagAdmin($bolFlagAdmin);
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdGrupo</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdGrupo() {
		return $this->intIdGrupo;
	}
	
	/**
	 * Define o valor de <var>$this->intIdGrupo</var>
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @return void
	 */
	public function setIdGrupo($intIdGrupo) {
		$this->intIdGrupo = (int) $intIdGrupo;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdUsuario</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuario() {
		return $this->intIdUsuario;
	}
	
	/**
	 * Define o valor de <var>$this->intIdUsuario</var>
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @return void
	 */
	public function setIdUsuario($intIdUsuario) {
		$this->intIdUsuario = (int) $intIdUsuario;
	}
	
	/**
	 * Retorna o valor de <var>$this->bolFlagAdmin</var>
	 *
	 * @access public
	 * @return boolean
	 */
	public function getFlagAdmin() {
		return $this->bolFlagAdmin;
	}
	
	/**
	 * Define o valor de <var>$this->bolFlagAdmin</var>
	 *
	 * @access public
	 * @param boolean $bolFlagAdmin
	 * @return void
	 */
	public function setFlagAdmin($bolFlagAdmin) {
		$this->bolFlagAdmin = (boolean) $bolFlagAdmin;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param GrupoUsuario $objGrupoUsuario
	 * @return boolean
	 */
	public function equals(GrupoUsuario $objGrupoUsuario) {
		if ($this->intIdGrupo == $objGrupoUsuario->getIdGrupo() &&
			$this->intIdUsuario == $objGrupoUsuario->getIdUsuario() &&
			$this->bolFlagAdmin == $objGrupoUsuario->getFlagAdmin()) return true;
		return false;
	}
	
}