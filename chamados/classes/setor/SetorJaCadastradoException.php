<?php
/**
 * Exceção de Setor já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Setor já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 19/06/2011 00:03:30
 */
class SetorJaCadastradoException extends Exception {
	/**
	 * Identificador do Setor
	 *
	 * @access private
	 * @var int
	 */
	private $intIdSetor;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdSetor
	 */
	public function __construct($intIdSetor) {
		parent::__construct("Setor já cadastrado(a)");
		$this->intIdSetor = $intIdSetor;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdSetor</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdSetor() {
		return $this->intIdSetor;
	}
	
}