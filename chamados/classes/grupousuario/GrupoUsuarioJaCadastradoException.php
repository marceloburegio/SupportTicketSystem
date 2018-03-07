<?php
/**
 * Exceção de GrupoUsuario já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto GrupoUsuario já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 02:53:30
 */
class GrupoUsuarioJaCadastradoException extends Exception {
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
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 */
	public function __construct($intIdGrupo, $intIdUsuario) {
		parent::__construct("GrupoUsuario já cadastrado(a)");
		$this->intIdGrupo = $intIdGrupo;
		$this->intIdUsuario = $intIdUsuario;
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
	 * Retorna o valor de <var>$this->intIdUsuario</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuario() {
		return $this->intIdUsuario;
	}
	
}