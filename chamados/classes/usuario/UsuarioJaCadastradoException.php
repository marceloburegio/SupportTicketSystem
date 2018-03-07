<?php
/**
 * Exceção de Usuario já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Usuario já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 17/06/2011 10:48:32
 */
class UsuarioJaCadastradoException extends Exception {
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
		parent::__construct("Usuario já cadastrado(a)");
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