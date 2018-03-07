<?php
/**
 * Classe básica de Movimentação Histórica
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:28:24
 */
class Historico {
	/**
	 * Identificador do Histórico
	 *
	 * @access private
	 * @var int
	 */
	private $intIdHistorico;
	
	/**
	 * Identificador do Chamado
	 *
	 * @access private
	 * @var int
	 */
	private $intIdChamado;
	
	/**
	 * Identificador do Usuário da Movimentação
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuario;
	
	/**
	 * Código do Tipo de Histórico
	 *
	 * @access private
	 * @var int
	 */
	private $intTipoHistorico;
	
	/**
	 * Descrição do Histórico
	 *
	 * @access private
	 * @var string
	 */
	private $strDescricaoHistorico;
	
	/**
	 * Data da Movimentação do Histórico
	 *
	 * @access private
	 * @var string
	 */
	private $strDataHistorico;
	
	/**
	 * Nome do Arquivo Anexo
	 *
	 * @access private
	 * @var string
	 */
	private $strNomeArquivoAnexo;
	
	/**
	 * Caminho do Arquivo Anexo
	 *
	 * @access private
	 * @var string
	 */
	private $strCaminhoArquivoAnexo;
	
	/**
	 * Objeto Usuario
	 *
	 * @access private
	 * @var Usuario
	 */
	private $objUsuario = null;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @param int $intIdChamado
	 * @param int $intIdUsuario
	 * @param int $intTipoHistorico
	 * @param string $strDescricaoHistorico
	 * @param string $strDataHistorico
	 * @param string $strNomeArquivoAnexo
	 * @param string $strCaminhoArquivoAnexo
	 */
	public function __construct($intIdHistorico, $intIdChamado, $intIdUsuario, $intTipoHistorico, $strDescricaoHistorico, $strDataHistorico, $strNomeArquivoAnexo, $strCaminhoArquivoAnexo) {
		$this->setIdHistorico($intIdHistorico);
		$this->setIdChamado($intIdChamado);
		$this->setIdUsuario($intIdUsuario);
		$this->setTipoHistorico($intTipoHistorico);
		$this->setDescricaoHistorico($strDescricaoHistorico);
		$this->setDataHistorico($strDataHistorico);
		$this->setNomeArquivoAnexo($strNomeArquivoAnexo);
		$this->setCaminhoArquivoAnexo($strCaminhoArquivoAnexo);
	}
	
	/**
	 * Retorna o valor de <var>$this->intIdHistorico</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdHistorico() {
		return $this->intIdHistorico;
	}
	
	/**
	 * Define o valor de <var>$this->intIdHistorico</var>
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @return void
	 */
	public function setIdHistorico($intIdHistorico) {
		$this->intIdHistorico = (int) $intIdHistorico;
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
	 * Retorna o valor de <var>$this->intIdUsuario</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getIdUsuario() {
		return $this->intIdUsuario;
	}
	
	/**
	 * Define o valor de <var>$this->intIdUsuario</var>
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @return void
	 */
	public function setIdUsuario($intIdUsuario) {
		$this->intIdUsuario = (int) $intIdUsuario;
	}
	
	/**
	 * Retorna o valor de <var>$this->intTipoHistorico</var>
	 *
	 * @access public
	 * @return int
	 */
	public function getTipoHistorico() {
		return $this->intTipoHistorico;
	}
	
	/**
	 * Define o valor de <var>$this->intTipoHistorico</var>
	 *
	 * @access public
	 * @param int $intTipoHistorico
	 * @return void
	 */
	public function setTipoHistorico($intTipoHistorico) {
		$this->intTipoHistorico = (int) $intTipoHistorico;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDescricaoHistorico</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDescricaoHistorico() {
		return $this->strDescricaoHistorico;
	}
	
	/**
	 * Define o valor de <var>$this->strDescricaoHistorico</var>
	 *
	 * @access public
	 * @param string $strDescricaoHistorico
	 * @return void
	 */
	public function setDescricaoHistorico($strDescricaoHistorico) {
		$this->strDescricaoHistorico = (string) $strDescricaoHistorico;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataHistorico</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataHistorico() {
		return $this->strDataHistorico;
	}
	
	/**
	 * Define o valor de <var>$this->strDataHistorico</var>
	 *
	 * @access public
	 * @param string $strDataHistorico
	 * @return void
	 */
	public function setDataHistorico($strDataHistorico) {
		$this->strDataHistorico = (string) $strDataHistorico;
	}
	
	/**
	 * Retorna o valor de <var>$this->strNomeArquivoAnexo</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getNomeArquivoAnexo() {
		return $this->strNomeArquivoAnexo;
	}
	
	/**
	 * Define o valor de <var>$this->strNomeArquivoAnexo</var>
	 *
	 * @access public
	 * @param string $strNomeArquivoAnexo
	 * @return void
	 */
	public function setNomeArquivoAnexo($strNomeArquivoAnexo) {
		$this->strNomeArquivoAnexo = (string) $strNomeArquivoAnexo;
	}
	
	/**
	 * Retorna o valor de <var>$this->strCaminhoArquivoAnexo</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getCaminhoArquivoAnexo() {
		return $this->strCaminhoArquivoAnexo;
	}
	
	/**
	 * Define o valor de <var>$this->strCaminhoArquivoAnexo</var>
	 *
	 * @access public
	 * @param string $strCaminhoArquivoAnexo
	 * @return void
	 */
	public function setCaminhoArquivoAnexo($strCaminhoArquivoAnexo) {
		$this->strCaminhoArquivoAnexo = (string) $strCaminhoArquivoAnexo;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Historico $objHistorico
	 * @return boolean
	 */
	public function equals(Historico $objHistorico) {
		if ($this->intIdHistorico == $objHistorico->getIdHistorico() &&
			$this->intIdChamado == $objHistorico->getIdChamado() &&
			$this->intIdUsuario == $objHistorico->getIdUsuario() &&
			$this->intTipoHistorico == $objHistorico->getTipoHistorico() &&
			$this->strDescricaoHistorico == $objHistorico->getDescricaoHistorico() &&
			$this->strDataHistorico == $objHistorico->getDataHistorico() &&
			$this->strNomeArquivoAnexo == $objHistorico->getNomeArquivoAnexo() &&
			$this->strCaminhoArquivoAnexo == $objHistorico->getCaminhoArquivoAnexo()) return true;
		return false;
	}
	
	/**
	 * Define o valor de <var>$this->objUsuario</var>
	 *
	 * @access public
	 * @param Usuario $objUsuario
	 * @return void
	 */
	public function setUsuario(Usuario $objUsuario) {
		$this->objUsuario = $objUsuario;
	}
	
	/**
	 * Retorna o valor de <var>$this->objUsuario</var>
	 *
	 * @access public
	 * @return Usuario
	 */
	public function getUsuario() {
		return $this->objUsuario;
	}
}