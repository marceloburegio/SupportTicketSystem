<?php
/**
 * Exceção de Grupo já cadastrado
 * Será levantada caso ocorra um cadastro de um objeto Grupo já cadastrado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:25:57
 */
class GrupoJaCadastradoException extends Exception {
	/**
	 * Identificador do Grupo
	 *
	 * @access private
	 * @var int
	 */
	private $intIdGrupo;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdGrupo
	 */
	public function __construct($intIdGrupo) {
		parent::__construct("Grupo já cadastrado(a)");
		$this->intIdGrupo = $intIdGrupo;
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
	
}