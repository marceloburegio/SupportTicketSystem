<?php
/**
 * Exceção de Encaminhamento já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Encaminhamento já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 23:06:26
 */
class EncaminhamentoJaCadastradoException extends Exception {
	/**
	 * Identificador do Emcaminhamento
	 *
	 * @access private
	 * @var int
	 */
	private $intIdEncaminhamento;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 */
	public function __construct($intIdEncaminhamento) {
		parent::__construct("Encaminhamento já cadastrado(a)");
		$this->intIdEncaminhamento = $intIdEncaminhamento;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdEncaminhamento</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdEncaminhamento() {
		return $this->intIdEncaminhamento;
	}
	
}