<?php
/**
 * Exceção de Horario não cadastrado
 * Será levantada caso ocorra algum acesso a um objeto Horario que não cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 03/06/2011 00:00:14
 */
class HorarioNaoCadastradoException extends Exception {
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
		parent::__construct("Horario não cadastrado(a)");
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