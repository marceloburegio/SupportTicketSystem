<?php
/**
 * Classe que modelará os objetos Feriados
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 26/10/2011 14:47:33
 */
class Feriado {
	/**
	 * Identificador do feriado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdFeriado;
	
	/**
	 * Identificador do grupo
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupo;
	
	/**
	 * Data do Feriado pertence
	 *
	 * @access private
	 * @var string
	 */
	private $strDataFeriado;
	
	/**
	 * Descrição do feriado
	 *
	 * @access private
	 * @var string
	 */
	private $strDescricaoFeriado;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @param int $intIdGrupo
	 * @param string $strDataFeriado
	 * @param string $strDescricaoFeriado
	 */
	public function __construct($intIdFeriado, $intIdGrupo, $strDataFeriado, $strDescricaoFeriado) {
		$this->setIdFeriado($intIdFeriado);
		$this->setIdGrupo($intIdGrupo);
		$this->setDataFeriado($strDataFeriado);
		$this->setDescricaoFeriado($strDescricaoFeriado);
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
	
	/**
	 * Define o valor de <var>$this->intIdFeriado</var>
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @return void
	 */
	public function setIdFeriado($intIdFeriado) {
		$this->intIdFeriado = (int) $intIdFeriado;
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
	 * Retorna o valor de <var>$this->strDataFeriado</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataFeriado() {
		return $this->strDataFeriado;
	}
	
	/**
	 * Define o valor de <var>$this->strDataFeriado</var>
	 *
	 * @access public
	 * @param string $strDataFeriado
	 * @return void
	 */
	public function setDataFeriado($strDataFeriado) {
		$this->strDataFeriado = (string) $strDataFeriado;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDescricaoFeriado</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDescricaoFeriado() {
		return $this->strDescricaoFeriado;
	}
	
	/**
	 * Define o valor de <var>$this->strDescricaoFeriado</var>
	 *
	 * @access public
	 * @param string $strDescricaoFeriado
	 * @return void
	 */
	public function setDescricaoFeriado($strDescricaoFeriado) {
		$this->strDescricaoFeriado = (string) $strDescricaoFeriado;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Feriado $objFeriado
	 * @return boolean
	 */
	public function equals(Feriado $objFeriado) {
		if ($this->intIdFeriado == $objFeriado->getIdFeriado() &&
			$this->intIdGrupo == $objFeriado->getIdGrupo() &&
			$this->strDataFeriado == $objFeriado->getDataFeriado() &&
			$this->strDescricaoFeriado == $objFeriado->getDescricaoFeriado()) return true;
		return false;
	}
	
}