<?php
/**
 * Exceção de Chamado não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Chamado que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:26:07
 */
class ChamadoNaoCadastradoException extends Exception {
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
		parent::__construct("Chamado não cadastrado(a)");
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