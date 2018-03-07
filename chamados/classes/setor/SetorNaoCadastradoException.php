<?php
/**
 * Exceção de Setor não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Setor que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 19/06/2011 00:03:30
 */
class SetorNaoCadastradoException extends Exception {
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
		parent::__construct("Setor não cadastrado(a)");
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