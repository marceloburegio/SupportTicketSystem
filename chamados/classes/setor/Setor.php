<?php
/**
 * Classe básica do Setor do Usuário
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 19/06/2011 00:03:29
 */
class Setor {
	/**
	 * Identificador do Setor
	 *
	 * @access private
	 * @var int
	 */
	private $intIdSetor;
	
	/**
	 * Descrição do Setor
	 *
	 * @access private
	 * @var string
	 */
	private $strDescricaoSetor;
	
	/**
	 * Código do Centro de Custo
	 *
	 * @access private
	 * @var string
	 */
	private $strCodigoCentroCusto;
	
	/**
	 * Flag de Status do Setor
	 *
	 * @access private
	 * @var boolean
	 */
	private $bolStatusSetor;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @param string $strDescricaoSetor
	 * @param string $strCodigoCentroCusto
	 * @param boolean $bolStatusSetor
	 */
	public function __construct($intIdSetor, $strDescricaoSetor, $strCodigoCentroCusto, $bolStatusSetor) {
		$this->setIdSetor($intIdSetor);
		$this->setDescricaoSetor($strDescricaoSetor);
		$this->setCodigoCentroCusto($strCodigoCentroCusto);
		$this->setStatusSetor($bolStatusSetor);
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdSetor</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdSetor() {
		return $this->intIdSetor;
	}
	
	/**
	 * Define o valor de <var>$this->intIdSetor</var>
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @return void
	 */
	public function setIdSetor($intIdSetor) {
		$this->intIdSetor = (int) $intIdSetor;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDescricaoSetor</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDescricaoSetor() {
		return $this->strDescricaoSetor;
	}
	
	/**
	 * Define o valor de <var>$this->strDescricaoSetor</var>
	 *
	 * @access public
	 * @param string $strDescricaoSetor
	 * @return void
	 */
	public function setDescricaoSetor($strDescricaoSetor) {
		$this->strDescricaoSetor = (string) $strDescricaoSetor;
	}
	
	/**
	 * Retorna o valor de <var>$this->strCodigoCentroCusto</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getCodigoCentroCusto() {
		return $this->strCodigoCentroCusto;
	}
	
	/**
	 * Define o valor de <var>$this->strCodigoCentroCusto</var>
	 *
	 * @access public
	 * @param string $strCodigoCentroCusto
	 * @return void
	 */
	public function setCodigoCentroCusto($strCodigoCentroCusto) {
		$this->strCodigoCentroCusto = (string) $strCodigoCentroCusto;
	}
	
	/**
	 * Retorna o valor de <var>$this->bolStatusSetor</var>
	 *
	 * @access public
	 * @return boolean
	 */
	public function getStatusSetor() {
		return $this->bolStatusSetor;
	}
	
	/**
	 * Define o valor de <var>$this->bolStatusSetor</var>
	 *
	 * @access public
	 * @param boolean $bolStatusSetor
	 * @return void
	 */
	public function setStatusSetor($bolStatusSetor) {
		$this->bolStatusSetor = (boolean) $bolStatusSetor;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Setor $objSetor
	 * @return boolean
	 */
	public function equals(Setor $objSetor) {
		if ($this->intIdSetor == $objSetor->getIdSetor() &&
			$this->strDescricaoSetor == $objSetor->getDescricaoSetor() &&
			$this->strCodigoCentroCusto == $objSetor->getCodigoCentroCusto() &&
			$this->bolStatusSetor == $objSetor->getStatusSetor()) return true;
		return false;
	}
	
}