<?php
/**
 * Exceção de Chamado já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Chamado já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:26:07
 */
class ChamadoJaCadastradoException extends Exception {
	/**
	 * Identificador do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdChamado;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdChamado
	 */
	public function __construct($intIdChamado) {
		parent::__construct("Chamado já cadastrado(a)");
		$this->intIdChamado = $intIdChamado;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdChamado</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdChamado() {
		return $this->intIdChamado;
	}
	
}