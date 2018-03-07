<?php
/**
 * Classe básica de Assunto dos Chamados
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:24:39
 */
class Assunto {
	/**
	 * Identificador do Assunto
	 *
	 * @access private
	 * @var int
	 */
	private $intIdAssunto;
	
	/**
	 * Identificador do Grupo
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupo;
	
	/**
	 * Descrição do Assunto
	 *
	 * @access private
	 * @var string
	 */
	private $strDescricaoAssunto;
	
	/**
	 * Flag Indicativa do Status do Assunto
	 *
	 * @access private
	 * @var boolean
	 */
	private $bolStatusAssunto;
	
	/**
	 * SLA do Assunto em Minutos
	 *
	 * @access private
	 * @var int
	 */
	private $intSla;
	
	/**
	 * Mensagem de Alerta ao Cadastrar um Chamado
	 *
	 * @access private
	 * @var string
	 */
	private $strAlertaChamado;
	
	/**
	 * Formato do Chamado
	 *
	 * @access private
	 * @var string
	 */
	private $strFormatoChamado;
	
	/**
	 * URL Chamado Externo
	 *
	 * @access private
	 * @var string
	 */
	private $strUrlChamadoExterno;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @param int $intIdGrupo
	 * @param string $strDescricaoAssunto
	 * @param boolean $bolStatusAssunto
	 * @param int $intSla
	 * @param string $strAlertaChamado
	 * @param string $strFormatoChamado
	 * @param string $strUrlChamadoExterno
	 */
	public function __construct($intIdAssunto, $intIdGrupo, $strDescricaoAssunto, $bolStatusAssunto, $intSla, $strAlertaChamado, $strFormatoChamado, $strUrlChamadoExterno) {
		$this->setIdAssunto($intIdAssunto);
		$this->setIdGrupo($intIdGrupo);
		$this->setDescricaoAssunto($strDescricaoAssunto);
		$this->setStatusAssunto($bolStatusAssunto);
		$this->setSla($intSla);
		$this->setAlertaChamado($strAlertaChamado);
		$this->setFormatoChamado($strFormatoChamado);
		$this->setUrlChamadoExterno($strUrlChamadoExterno);
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdAssunto</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdAssunto() {
		return $this->intIdAssunto;
	}
	
	/**
	 * Define o valor de <var>$this->intIdAssunto</var>
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @return void
	 */
	public function setIdAssunto($intIdAssunto) {
		$this->intIdAssunto = (int) $intIdAssunto;
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
	 * Retorna o valor de <var>$this->strDescricaoAssunto</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDescricaoAssunto() {
		return $this->strDescricaoAssunto;
	}
	
	/**
	 * Define o valor de <var>$this->strDescricaoAssunto</var>
	 *
	 * @access public
	 * @param string $strDescricaoAssunto
	 * @return void
	 */
	public function setDescricaoAssunto($strDescricaoAssunto) {
		$this->strDescricaoAssunto = (string) $strDescricaoAssunto;
	}
	
	/**
	 * Retorna o valor de <var>$this->bolStatusAssunto</var>
	 *
	 * @access public
	 * @return boolean
	 */
	public function getStatusAssunto() {
		return $this->bolStatusAssunto;
	}
	
	/**
	 * Define o valor de <var>$this->bolStatusAssunto</var>
	 *
	 * @access public
	 * @param boolean $bolStatusAssunto
	 * @return void
	 */
	public function setStatusAssunto($bolStatusAssunto) {
		$this->bolStatusAssunto = (boolean) $bolStatusAssunto;
	}
	
	/**
	 * Retorna o valor de <var>$this->intSla</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getSla() {
		return $this->intSla;
	}
	
	/**
	 * Define o valor de <var>$this->intSla</var>
	 *
	 * @access public
	 * @param int $intSla
	 * @return void
	 */
	public function setSla($intSla) {
		$this->intSla = (int) $intSla;
	}
	
	/**
	 * Retorna o valor de <var>$this->strAlertaChamado</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getAlertaChamado() {
		return $this->strAlertaChamado;
	}
	
	/**
	 * Define o valor de <var>$this->strAlertaChamado</var>
	 *
	 * @access public
	 * @param string $strAlertaChamado
	 * @return void
	 */
	public function setAlertaChamado($strAlertaChamado) {
		$this->strAlertaChamado = (string) $strAlertaChamado;
	}
	
	/**
	 * Retorna o valor de <var>$this->strFormatoChamado</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getFormatoChamado() {
		return $this->strFormatoChamado;
	}
	
	/**
	 * Define o valor de <var>$this->strFormatoChamado</var>
	 *
	 * @access public
	 * @param string $strFormatoChamado
	 * @return void
	 */
	public function setFormatoChamado($strFormatoChamado) {
		$this->strFormatoChamado = (string) $strFormatoChamado;
	}
	
	/**
	 * Retorna o valor de <var>$this->strUrlChamadoExterno</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getUrlChamadoExterno() {
		return $this->strUrlChamadoExterno;
	}
	
	/**
	 * Define o valor de <var>$this->strUrlChamadoExterno</var>
	 *
	 * @access public
	 * @param string $strUrlChamadoExterno
	 * @return void
	 */
	public function setUrlChamadoExterno($strUrlChamadoExterno) {
		$this->strUrlChamadoExterno = (string) $strUrlChamadoExterno;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @return boolean
	 */
	public function equals(Assunto $objAssunto) {
		if ($this->intIdAssunto == $objAssunto->getIdAssunto() &&
			$this->intIdGrupo == $objAssunto->getIdGrupo() &&
			$this->strDescricaoAssunto == $objAssunto->getDescricaoAssunto() &&
			$this->bolStatusAssunto == $objAssunto->getStatusAssunto() &&
			$this->intSla == $objAssunto->getSla() &&
			$this->strFormatoChamado == $objAssunto->getFormatoChamado() &&
			$this->strUrlChamadoExterno == $objAssunto->getUrlChamadoExterno()) return true;
		return false;
	}
	
}