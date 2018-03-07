<?php
/**
 * Exceção de Assunto não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Assunto que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:24:40
 */
class AssuntoNaoCadastradoException extends Exception {
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
		parent::__construct("Assunto não cadastrado(a)");
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