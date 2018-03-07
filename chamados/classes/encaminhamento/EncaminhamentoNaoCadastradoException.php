<?php
/**
 * Exceção de Encaminhamento não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Encaminhamento que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 23:06:26
 */
class EncaminhamentoNaoCadastradoException extends Exception {
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
		parent::__construct("Encaminhamento não cadastrado(a)");
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