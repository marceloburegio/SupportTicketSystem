<?php
/**
 * Exceção de GrupoUsuario não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto GrupoUsuario que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 02:53:30
 */
class GrupoUsuarioNaoCadastradoException extends Exception {
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
		parent::__construct("GrupoUsuario não cadastrado(a)");
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