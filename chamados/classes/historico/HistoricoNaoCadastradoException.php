<?php
/**
 * Exceção de Historico não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Historico que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:28:24
 */
class HistoricoNaoCadastradoException extends Exception {
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
		parent::__construct("Historico não cadastrado(a)");
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