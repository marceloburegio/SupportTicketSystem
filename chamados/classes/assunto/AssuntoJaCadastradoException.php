<?php
/**
 * Exceção de Assunto já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Assunto já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:24:40
 */
class AssuntoJaCadastradoException extends Exception {
	/**
	 * Identificador do Assunto
	 *
	 * @access private
	 * @var int
	 */
	private $intIdAssunto;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdAssunto
	 */
	public function __construct($intIdAssunto) {
		parent::__construct("Assunto já cadastrado(a)");
		$this->intIdAssunto = $intIdAssunto;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdAssunto</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdAssunto() {
		return $this->intIdAssunto;
	}
	
}