<?php
/**
 * Exceção de Historico já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Historico já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:28:24
 */
class HistoricoJaCadastradoException extends Exception {
	/**
	 * Identificador do Histórico
	 *
	 * @access private
	 * @var int
	 */
	private $intIdHistorico;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdHistorico
	 */
	public function __construct($intIdHistorico) {
		parent::__construct("Historico já cadastrado(a)");
		$this->intIdHistorico = $intIdHistorico;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdHistorico</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdHistorico() {
		return $this->intIdHistorico;
	}
	
}