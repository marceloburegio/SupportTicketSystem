<?php
/**
 * Exceção de Horario já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Horario já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 03/06/2011 00:00:14
 */
class HorarioJaCadastradoException extends Exception {
	/**
	 * Identificador do Horário
	 *
	 * @access private
	 * @var int
	 */
	private $intIdHorario;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdHorario
	 */
	public function __construct($intIdHorario) {
		parent::__construct("Horario já cadastrado(a)");
		$this->intIdHorario = $intIdHorario;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdHorario</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdHorario() {
		return $this->intIdHorario;
	}
	
}