<?php
/**
 * Classe básica de Usuários
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 17/06/2011 16:58:13
 */
class Usuario {
	/**
	 * Identificador do Usuário
	 *
	 * @access private
	 * @var int
	 */
	private $intIdUsuario;
	
	/**
	 * Identificador do Setor do  Usuário
	 *
	 * @access private
	 * @var int
	 */
	private $intIdSetor;
	
	/**
	 * Login de Rede do Usuário
	 *
	 * @access private
	 * @var string
	 */
	private $strLogin;
	
	/**
	 * Nome do Usuário
	 *
	 * @access private
	 * @var string
	 */
	private $strNomeUsuario;
	
	/**
	 * Email do Usuário
	 *
	 * @access private
	 * @var string
	 */
	private $strEmailUsuario;
	
	/**
	 * Ramal do Usuário
	 *
	 * @access private
	 * @var string
	 */
	private $strRamal;
	
	/**
	 * Data de Cadastramento no Sistema
	 *
	 * @access private
	 * @var string
	 */
	private $strDataCadastro;
	
	/**
	 * Data da Última Alteração no Sistema
	 *
	 * @access private
	 * @var string
	 */
	private $strDataAlteracao;
	
	/**
	 * Data do Último Login Realizado no Sistema
	 *
	 * @access private
	 * @var string
	 */
	private $strDataUltimoLogin;
	
	/**
	 * Flag Indicativa do Status do Usuário
	 *
	 * @access private
	 * @var boolean
	 */
	private $bolStatusUsuario;
	
	/**
	 * Flag Indicativa de Super Administrador
	 *
	 * @access private
	 * @var boolean
	 */
	private $bolFlagSuperAdmin;
	
	/**
	 * Objeto do Setor do Usuário
	 *
	 * @access private
	 * @var Setor
	 */
	private $objSetor;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @param int $intIdSetor
	 * @param string $strLogin
	 * @param string $strNomeUsuario
	 * @param string $strEmailUsuario
	 * @param string $strRamal
	 * @param string $strDataCadastro
	 * @param string $strDataAlteracao
	 * @param string $strDataUltimoLogin
	 * @param boolean $bolStatusUsuario
	 * @param boolean $bolFlagSuperAdmin
	 * @param Setor $objSetor = null
	 */
	public function __construct($intIdUsuario, $intIdSetor, $strLogin, $strNomeUsuario, $strEmailUsuario, $strRamal, $strDataCadastro, $strDataAlteracao, $strDataUltimoLogin, $bolStatusUsuario, $bolFlagSuperAdmin, Setor $objSetor = null) {
		$this->setIdUsuario($intIdUsuario);
		$this->setIdSetor($intIdSetor);
		$this->setLogin($strLogin);
		$this->setNomeUsuario($strNomeUsuario);
		$this->setEmailUsuario($strEmailUsuario);
		$this->setRamal($strRamal);
		$this->setDataCadastro($strDataCadastro);
		$this->setDataAlteracao($strDataAlteracao);
		$this->setDataUltimoLogin($strDataUltimoLogin);
		$this->setStatusUsuario($bolStatusUsuario);
		$this->setFlagSuperAdmin($bolFlagSuperAdmin);
		$this->setSetor($objSetor);
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
	 * Retorna o valor de <var>$this->strLogin</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getLogin() {
		return $this->strLogin;
	}
	
	/**
	 * Define o valor de <var>$this->strLogin</var>
	 *
	 * @access public
	 * @param string $strLogin
	 * @return void
	 */
	public function setLogin($strLogin) {
		$this->strLogin = (string) $strLogin;
	}
	
	/**
	 * Retorna o valor de <var>$this->strNomeUsuario</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getNomeUsuario() {
		return $this->strNomeUsuario;
	}
	
	/**
	 * Define o valor de <var>$this->strNomeUsuario</var>
	 *
	 * @access public
	 * @param string $strNomeUsuario
	 * @return void
	 */
	public function setNomeUsuario($strNomeUsuario) {
		$this->strNomeUsuario = (string) $strNomeUsuario;
	}
	
	/**
	 * Retorna o valor de <var>$this->strEmailUsuario</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getEmailUsuario() {
		return $this->strEmailUsuario;
	}
	
	/**
	 * Define o valor de <var>$this->strEmailUsuario</var>
	 *
	 * @access public
	 * @param string $strEmailUsuario
	 * @return void
	 */
	public function setEmailUsuario($strEmailUsuario) {
		$this->strEmailUsuario = (string) $strEmailUsuario;
	}
	
	/**
	 * Retorna o valor de <var>$this->strRamal</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getRamal() {
		return $this->strRamal;
	}
	
	/**
	 * Define o valor de <var>$this->strRamal</var>
	 *
	 * @access public
	 * @param string $strRamal
	 * @return void
	 */
	public function setRamal($strRamal) {
		$this->strRamal = (string) $strRamal;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataCadastro</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataCadastro() {
		return $this->strDataCadastro;
	}
	
	/**
	 * Define o valor de <var>$this->strDataCadastro</var>
	 *
	 * @access public
	 * @param string $strDataCadastro
	 * @return void
	 */
	public function setDataCadastro($strDataCadastro) {
		$this->strDataCadastro = (string) $strDataCadastro;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataAlteracao</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataAlteracao() {
		return $this->strDataAlteracao;
	}
	
	/**
	 * Define o valor de <var>$this->strDataAlteracao</var>
	 *
	 * @access public
	 * @param string $strDataAlteracao
	 * @return void
	 */
	public function setDataAlteracao($strDataAlteracao) {
		$this->strDataAlteracao = (string) $strDataAlteracao;
	}
	
	/**
	 * Retorna o valor de <var>$this->strDataUltimoLogin</var>
	 *
	 * @access public
	 * @return string
	 */
	public function getDataUltimoLogin() {
		return $this->strDataUltimoLogin;
	}
	
	/**
	 * Define o valor de <var>$this->strDataUltimoLogin</var>
	 *
	 * @access public
	 * @param string $strDataUltimoLogin
	 * @return void
	 */
	public function setDataUltimoLogin($strDataUltimoLogin) {
		$this->strDataUltimoLogin = (string) $strDataUltimoLogin;
	}
	
	/**
	 * Retorna o valor de <var>$this->bolStatusUsuario</var>
	 *
	 * @access public
	 * @return boolean
	 */
	public function getStatusUsuario() {
		return $this->bolStatusUsuario;
	}
	
	/**
	 * Define o valor de <var>$this->bolStatusUsuario</var>
	 *
	 * @access public
	 * @param boolean $bolStatusUsuario
	 * @return void
	 */
	public function setStatusUsuario($bolStatusUsuario) {
		$this->bolStatusUsuario = (boolean) $bolStatusUsuario;
	}
	
	/**
	 * Retorna o valor de <var>$this->bolFlagSuperAdmin</var>
	 *
	 * @access public
	 * @return boolean
	 */
	public function getFlagSuperAdmin() {
		return $this->bolFlagSuperAdmin;
	}
	
	/**
	 * Define o valor de <var>$this->bolFlagSuperAdmin</var>
	 *
	 * @access public
	 * @param boolean $bolFlagSuperAdmin
	 * @return void
	 */
	public function setFlagSuperAdmin($bolFlagSuperAdmin) {
		$this->bolFlagSuperAdmin = (boolean) $bolFlagSuperAdmin;
	}
	
	/**
	 * Retorna o valor de <var>$this->objSetor</var>
	 *
	 * @access public
	 * @return Setor
	 */
	public function getSetor() {
		return $this->objSetor;
	}
	
	/**
	 * Define o valor de <var>$this->objSetor</var>
	 *
	 * @access public
	 * @param Setor $objSetor = null
	 * @return void
	 */
	public function setSetor(Setor $objSetor = null) {
		$this->objSetor = $objSetor;
	}
	
	/**
	 * Método que compara um objeto passado por parametro com o próprio objeto
	 *
	 * @access public
	 * @param Usuario $objUsuario
	 * @return boolean
	 */
	public function equals(Usuario $objUsuario) {
		if ($this->intIdUsuario == $objUsuario->getIdUsuario() &&
		$this->intIdSetor == $objUsuario->getIdSetor() &&
		$this->strLogin == $objUsuario->getLogin() &&
		$this->strNomeUsuario == $objUsuario->getNomeUsuario() &&
		$this->strEmailUsuario == $objUsuario->getEmailUsuario() &&
		$this->strRamal == $objUsuario->getRamal() &&
		$this->strDataCadastro == $objUsuario->getDataCadastro() &&
		$this->strDataAlteracao == $objUsuario->getDataAlteracao() &&
		$this->strDataUltimoLogin == $objUsuario->getDataUltimoLogin() &&
		$this->bolStatusUsuario == $objUsuario->getStatusUsuario() &&
		$this->bolFlagSuperAdmin == $objUsuario->getFlagSuperAdmin()) return true;
		return false;
	}
}