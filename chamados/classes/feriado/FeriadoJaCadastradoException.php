<?php
/**
 * Exceção de Feriado já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Feriado já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 26/10/2011 14:47:33
 */
class FeriadoJaCadastradoException extends Exception {
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
		parent::__construct("Feriado já cadastrado(a)");
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