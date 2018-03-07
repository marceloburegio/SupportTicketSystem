<?php
/**
 * Exceção genérica de Campos Inválido
 * Será levantada caso algum campo obrigatório enviado esteja vazio
 *
 * @author Marcelo Burégio
 * @subpackage util
 * @version 1.0
 * @since 20/09/2009 13:26
 */
class CampoInvalidoException extends Exception {
	/**
	 * Nome do Campo Obrigatorio
	 *
	 * @access private
	 * @var string
	 */
	private $strNomeCampo;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param string $strNomeCampo
	 */
	public function __construct($strNomeCampo) {
		parent::__construct("Campo {$strNomeCampo} está vazio ou com conteúdo inválido.");
		$this->strNomeCampo = $strNomeCampo;
	}
	
	/**
	 * Retorna o valor de <var>$this->strNomeCampo</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getNomeCampo() {
		return $this->strNomeCampo;
	}
	
}