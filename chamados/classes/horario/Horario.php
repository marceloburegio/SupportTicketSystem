<?php
/**
 * Classe básica de Horários dos Usuários
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 03/06/2011 00:00:13
 */
class Horario {
	/**
	 * Identificador do Horário
	 *
	 * @access private
	 * @var int
	 */
	private $intIdHorario;
	
	/**
	 * Identificador do Grupo
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupo;
	
	/**
	 * Código do Dia da Semana
	 *
	 * @access private
	 * @var int
	 */
	private $intDiaSemana;
	
	/**
	 * Horário de Início da Jornada
	 *
	 * @access private
	 * @var string
	 */
	private $strInicioHorario;
	
	/**
	 * Horário de Término da Jornada
	 *
	 * @access private
	 * @var string
	 */
	private $strTerminoHorario;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @param int $intIdGrupo
	 * @param int $intDiaSemana
	 * @param string $strInicioHorario
	 * @param string $strTerminoHorario
	 */
	public function __construct($intIdHorario, $intIdGrupo, $intDiaSemana, $strInicioHorario, $strTerminoHorario) {
		$this->setIdHorario($intIdHorario);
		$this->setIdGrupo($intIdGrupo);
		$this->setDiaSemana($intDiaSemana);
		$this->setInicioHorario($strInicioHorario);
		$this->setTerminoHorario($strTerminoHorario);
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
	
	/**
	 * Define o valor de <var>$this->intIdHorario</var>
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @return void
	 */
	public function setIdHorario($intIdHorario) {
		$this->intIdHorario = (int) $intIdHorario;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdGrupo</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdGrupo() {
		return $this->intIdGrupo;
	}
	
	/**
	 * Define o valor de <var>$this->intIdGrupo</var>
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @return void
	 */
	public function setIdGrupo($intIdGrupo) {
		$this->intIdGrupo = (int) $intIdGrupo;
	}
	
	/**
	 * Retorna o valor de <var>$this->intDiaSemana</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getDiaSemana() {
		return $this->intDiaSemana;
	}
	
	/**
	 * Define o valor de <var>$this->intDiaSemana</var>
	 *
	 * @access public
	 * @param int $intDiaSemana
	 * @return void
	 */
	public function setDiaSemana($intDiaSemana) {
		$this->intDiaSemana = (int) $intDiaSemana;
	}
	
	/**
	 * Retorna o valor de <var>$this->strInicioHorario</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getInicioHorario() {
		return $this->strInicioHorario;
	}
	
	/**
	 * Define o valor de <var>$this->strInicioHorario</var>
	 *
	 * @access public
	 * @param string $strInicioHorario
	 * @return void
	 */
	public function setInicioHorario($strInicioHorario) {
		$this->strInicioHorario = (string) $strInicioHorario;
	}
	
	/**
	 * Retorna o valor de <var>$this->strTerminoHorario</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getTerminoHorario() {
		return $this->strTerminoHorario;
	}
	
	/**
	 * Define o valor de <var>$this->strTerminoHorario</var>
	 *
	 * @access public
	 * @param string $strTerminoHorario
	 * @return void
	 */
	public function setTerminoHorario($strTerminoHorario) {
		$this->strTerminoHorario = (string) $strTerminoHorario;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Horario $objHorario
	 * @return boolean
	 */
	public function equals(Horario $objHorario) {
		if ($this->intIdHorario == $objHorario->getIdHorario() &&
			$this->intIdGrupo == $objHorario->getIdGrupo() &&
			$this->intDiaSemana == $objHorario->getDiaSemana() &&
			$this->strInicioHorario == $objHorario->getInicioHorario() &&
			$this->strTerminoHorario == $objHorario->getTerminoHorario()) return true;
		return false;
	}
	
}