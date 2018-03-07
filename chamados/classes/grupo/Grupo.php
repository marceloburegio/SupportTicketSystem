<?php
/**
 * Classe básica de Grupos
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:25:56
 */
class Grupo {
	/**
	 * Identificador do Grupo
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupo;
	
	/**
	 * Nome do Grupo
	 *
	 * @access private
	 * @var string
	 */
	private $strDescricaoGrupo;
	
	/**
	 * E-mail do Grupo
	 *
	 * @access private
	 * @var string
	 */
	private $strEmailGrupo;
	
	/**
	 * Status do Grupo
	 *
	 * @access private
	 * @var boolean
	 */
	private $bolStatusGrupo;
	
	/**
	 * Flag Indicativa de Grupo Recebedor de Chamados
	 *
	 * @access private
	 * @var boolean
	 */
	private $bolFlagRecebeChamado;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strDescricaoGrupo
	 * @param string $strEmailGrupo
	 * @param boolean $bolStatusGrupo
	 * @param boolean $bolFlagRecebeChamado
	 */
	public function __construct($intIdGrupo, $strDescricaoGrupo, $strEmailGrupo, $bolStatusGrupo, $bolFlagRecebeChamado) {
		$this->setIdGrupo($intIdGrupo);
		$this->setDescricaoGrupo($strDescricaoGrupo);
		$this->setEmailGrupo($strEmailGrupo);
		$this->setStatusGrupo($bolStatusGrupo);
		$this->setFlagRecebeChamado($bolFlagRecebeChamado);
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
	 * Retorna o valor de <var>$this->strDescricaoGrupo</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDescricaoGrupo() {
		return $this->strDescricaoGrupo;
	}
	
	/**
	 * Define o valor de <var>$this->strDescricaoGrupo</var>
	 *
	 * @access public
	 * @param string $strDescricaoGrupo
	 * @return void
	 */
	public function setDescricaoGrupo($strDescricaoGrupo) {
		$this->strDescricaoGrupo = (string) $strDescricaoGrupo;
	}
	
	/**
	 * Retorna o valor de <var>$this->strEmailGrupo</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getEmailGrupo() {
		return $this->strEmailGrupo;
	}
	
	/**
	 * Define o valor de <var>$this->strEmailGrupo</var>
	 *
	 * @access public
	 * @param string $strEmailGrupo
	 * @return void
	 */
	public function setEmailGrupo($strEmailGrupo) {
		$this->strEmailGrupo = (string) $strEmailGrupo;
	}
	
	/**
	 * Retorna o valor de <var>$this->bolStatusGrupo</var>
	 *
	 * @access public
	 * @return boolean
	 */
	public function getStatusGrupo() {
		return $this->bolStatusGrupo;
	}
	
	/**
	 * Define o valor de <var>$this->bolStatusGrupo</var>
	 *
	 * @access public
	 * @param boolean $bolStatusGrupo
	 * @return void
	 */
	public function setStatusGrupo($bolStatusGrupo) {
		$this->bolStatusGrupo = (boolean) $bolStatusGrupo;
	}
	
	/**
	 * Retorna o valor de <var>$this->bolFlagRecebeChamado</var>
	 *
	 * @access public
	 * @return boolean
	 */
	public function getFlagRecebeChamado() {
		return $this->bolFlagRecebeChamado;
	}
	
	/**
	 * Define o valor de <var>$this->bolFlagRecebeChamado</var>
	 *
	 * @access public
	 * @param boolean $bolFlagRecebeChamado
	 * @return void
	 */
	public function setFlagRecebeChamado($bolFlagRecebeChamado) {
		$this->bolFlagRecebeChamado = (boolean) $bolFlagRecebeChamado;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Grupo $objGrupo
	 * @return boolean
	 */
	public function equals(Grupo $objGrupo) {
		if ($this->intIdGrupo == $objGrupo->getIdGrupo() &&
			$this->strDescricaoGrupo == $objGrupo->getDescricaoGrupo() &&
			$this->strEmailGrupo == $objGrupo->getEmailGrupo() &&
			$this->bolStatusGrupo == $objGrupo->getStatusGrupo() &&
			$this->bolFlagRecebeChamado == $objGrupo->getFlagRecebeChamado()) return true;
		return false;
	}
	
}