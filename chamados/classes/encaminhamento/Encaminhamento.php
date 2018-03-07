<?php
/**
 * Classe básica do Histórico de Encaminhamentos do Chamado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 23:06:26
 */
class Encaminhamento {
	/**
	 * Identificador do Emcaminhamento
	 *
	 * @access private
	 * @var int
	 */
	private $intIdEncaminhamento;
	
	/**
	 * Identificador do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdChamado;
	
	/**
	 * Identificador do Usuário que Encaminhou o Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuarioOrigem;
	
	/**
	 * Identificador do Grupo de Destino
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupoDestino;
	
	/**
	 * Identificador do Usuário de Destino
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuarioDestino;
	
	/**
	 * Data do Encaminhamento do Chamado
	 *
	 * @access private
	 * @var string
	 */
	private $strDataEncaminhamento;
	
	/**
	 * Objeto Usuario de Origem
	 *
	 * @access private
	 * @var Usuario
	 */
	private $objUsuarioOrigem = null;
	
	/**
	 * Objeto Usuario de Destino
	 *
	 * @access private
	 * @var Usuario
	 */
	private $objUsuarioDestino = null;
	
	/**
	 * Objeto Grupo de Destino
	 *
	 * @access private
	 * @var Grupo
	 */
	private $objGrupoDestino = null;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @param int $intIdChamado
	 * @param int $intIdUsuarioOrigem
	 * @param int $intIdGrupoDestino
	 * @param int $intIdUsuarioDestino
	 * @param string $strDataEncaminhamento
	 */
	public function __construct($intIdEncaminhamento, $intIdChamado, $intIdUsuarioOrigem, $intIdGrupoDestino, $intIdUsuarioDestino, $strDataEncaminhamento) {
		$this->setIdEncaminhamento($intIdEncaminhamento);
		$this->setIdChamado($intIdChamado);
		$this->setIdUsuarioOrigem($intIdUsuarioOrigem);
		$this->setIdGrupoDestino($intIdGrupoDestino);
		$this->setIdUsuarioDestino($intIdUsuarioDestino);
		$this->setDataEncaminhamento($strDataEncaminhamento);
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdEncaminhamento</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdEncaminhamento() {
		return $this->intIdEncaminhamento;
	}
	
	/**
	 * Define o valor de <var>$this->intIdEncaminhamento</var>
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @return void
	 */
	public function setIdEncaminhamento($intIdEncaminhamento) {
		$this->intIdEncaminhamento = (int) $intIdEncaminhamento;
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
	
	/**
	 * Define o valor de <var>$this->intIdChamado</var>
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @return void
	 */
	public function setIdChamado($intIdChamado) {
		$this->intIdChamado = (int) $intIdChamado;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdUsuarioOrigem</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuarioOrigem() {
		return $this->intIdUsuarioOrigem;
	}
	
	/**
	 * Define o valor de <var>$this->intIdUsuarioOrigem</var>
	 *
	 * @access public
	 * @param int $intIdUsuarioOrigem
	 * @return void
	 */
	public function setIdUsuarioOrigem($intIdUsuarioOrigem) {
		$this->intIdUsuarioOrigem = (int) $intIdUsuarioOrigem;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdGrupoDestino</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdGrupoDestino() {
		return $this->intIdGrupoDestino;
	}
	
	/**
	 * Define o valor de <var>$this->intIdGrupoDestino</var>
	 *
	 * @access public
	 * @param int $intIdGrupoDestino
	 * @return void
	 */
	public function setIdGrupoDestino($intIdGrupoDestino) {
		$this->intIdGrupoDestino = (int) $intIdGrupoDestino;
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdUsuarioDestino</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuarioDestino() {
		return $this->intIdUsuarioDestino;
	}
	
	/**
	 * Define o valor de <var>$this->intIdUsuarioDestino</var>
	 *
	 * @access public
	 * @param int $intIdUsuarioDestino
	 * @return void
	 */
	public function setIdUsuarioDestino($intIdUsuarioDestino) {
		$this->intIdUsuarioDestino = (int) $intIdUsuarioDestino;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataEncaminhamento</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataEncaminhamento() {
		return $this->strDataEncaminhamento;
	}
	
	/**
	 * Define o valor de <var>$this->strDataEncaminhamento</var>
	 *
	 * @access public
	 * @param string $strDataEncaminhamento
	 * @return void
	 */
	public function setDataEncaminhamento($strDataEncaminhamento) {
		$this->strDataEncaminhamento = (string) $strDataEncaminhamento;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @return boolean
	 */
	public function equals(Encaminhamento $objEncaminhamento) {
		if ($this->intIdEncaminhamento == $objEncaminhamento->getIdEncaminhamento() &&
			$this->intIdChamado == $objEncaminhamento->getIdChamado() &&
			$this->intIdUsuarioOrigem == $objEncaminhamento->getIdUsuarioOrigem() &&
			$this->intIdGrupoDestino == $objEncaminhamento->getIdGrupoDestino() &&
			$this->intIdUsuarioDestino == $objEncaminhamento->getIdUsuarioDestino() &&
			$this->strDataEncaminhamento == $objEncaminhamento->getDataEncaminhamento()) return true;
		return false;
	}
	
	/**
	 * Retorna o valor de <var>$this->objUsuarioOrigem</var>
	 *
	 * @access public
	 * @return Usuario
	 */
	public function getUsuarioOrigem() {
		return $this->objUsuarioOrigem;
	}
	
	/**
	 * Define o valor de <var>$this->objUsuarioOrigem</var>
	 *
	 * @access public
	 * @param Usuario $objUsuarioOrigem
	 * @return void
	 */
	public function setUsuarioOrigem(Usuario $objUsuarioOrigem) {
		$this->objUsuarioOrigem = $objUsuarioOrigem;
	}
	
	/**
	 * Retorna o valor de <var>$this->objUsuarioDestino</var>
	 *
	 * @access public
	 * @return Usuario
	 */
	public function getUsuarioDestino() {
		return $this->objUsuarioDestino;
	}
	
	/**
	 * Define o valor de <var>$this->objUsuarioDestino</var>
	 *
	 * @access public
	 * @param Usuario $objUsuarioDestino
	 * @return void
	 */
	public function setUsuarioDestino(Usuario $objUsuarioDestino) {
		$this->objUsuarioDestino = $objUsuarioDestino;
	}
	
	/**
	 * Retorna o valor de <var>$this->objGrupoDestino</var>
	 *
	 * @access public
	 * @return Grupo
	 */
	public function getGrupoDestino() {
		return $this->objGrupoDestino;
	}
	
	/**
	 * Define o valor de <var>$this->objGrupoDestino</var>
	 *
	 * @access public
	 * @param Grupo $objGrupoDestino
	 * @return void
	 */
	public function setGrupoDestino(Grupo $objGrupoDestino) {
		$this->objGrupoDestino = $objGrupoDestino;
	}
}