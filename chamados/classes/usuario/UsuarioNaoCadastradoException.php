<?php
/**
 * Exceção de Usuario não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Usuario que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 17/06/2011 10:48:32
 */
class UsuarioNaoCadastradoException extends Exception {
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
	 * @param int $intIdUsuario
	 */
	public function __construct($intIdUsuario) {
		parent::__construct("Usuario não cadastrado(a)");
		$this->intIdUsuario = $intIdUsuario;
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