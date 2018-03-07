<?php
/**
 * Cadastro de objetos Usuario
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 17/06/2011 10:48:32
 */
class CadastroUsuario {
	/**
	 * Repositório de classes Usuario
	 *
	 * @access private
	 * @var IRepositorioUsuario
	 */
	private $objRepositorioUsuario;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioUsuario $objRepositorioUsuario
	 */
	public function __construct(IRepositorioUsuario $objRepositorioUsuario) {
		$this->objRepositorioUsuario = $objRepositorioUsuario;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param Usuario $objUsuario
	 * @throws UsuarioJaCadastradoException
	 * @throws UsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Usuario $objUsuario) {
		if ($this->existe($objUsuario->getIdUsuario()))
			throw new UsuarioJaCadastradoException($objUsuario->getIdUsuario());
		return $this->objRepositorioUsuario->inserir($objUsuario);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param Usuario $objUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Usuario $objUsuario) {
		$this->objRepositorioUsuario->atualizar($objUsuario);
	}
	
	/**
	 * Método que remove um objeto do RepositorioUsuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdUsuario) {
		$this->objRepositorioUsuario->remover($intIdUsuario);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @return Usuario
	 */
	public function procurar($intIdUsuario) {
		return $this->objRepositorioUsuario->procurar($intIdUsuario);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdUsuario) {
		return $this->objRepositorioUsuario->existe($intIdUsuario);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioUsuario
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioUsuario->listar();
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param string $strLogin
	 * @throws UsuarioNaoCadastradoException
	 * @return Usuario
	 */
	public function procurarPorLogin($strLogin) {
		return $this->objRepositorioUsuario->procurarPorLogin($strLogin);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param string $strLogin
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existePorLogin($strLogin) {
		return $this->objRepositorioUsuario->existePorLogin($strLogin);
	}
	
	/**
	 * Método que lista todos os objetos pertencente ao Grupo informado
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarPorIdGrupo($intIdGrupo){
		return $this->objRepositorioUsuario->listarPorIdGrupo($intIdGrupo);
	}
	
	/**
	 * Método que lista todos Usuários Admins do Usuário especificado
	 * 
	 * @access public
	 * @param int $intIdUsuario
	 * @return array
	 */
	public function listarAdminPorIdUsuario($intIdUsuario){
		return $this->objRepositorioUsuario->listarAdminPorIdUsuario($intIdUsuario);
	}
	
	
	/**
	 * Método que lista todos Usuários Admins do Grupo especificado
	 * 
	 * @access public
	 * @param int $intIdGrupo
	 * @return array
	 */
	public function listarAdminPorIdGrupo($intIdGrupo){
		return $this->objRepositorioUsuario->listarAdminPorIdGrupo($intIdGrupo);
	}
}