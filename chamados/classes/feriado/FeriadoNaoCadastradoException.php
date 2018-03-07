<?php
/**
 * Exceção de Feriado não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Feriado que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 26/10/2011 14:47:33
 */
class FeriadoNaoCadastradoException extends Exception {
	/**
	 * Identificador do feriado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdFeriado;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdFeriado
	 */
	public function __construct($intIdFeriado) {
		parent::__construct("Feriado não cadastrado(a)");
		$this->intIdFeriado = $intIdFeriado;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdFeriado</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdFeriado() {
		return $this->intIdFeriado;
	}
	
}