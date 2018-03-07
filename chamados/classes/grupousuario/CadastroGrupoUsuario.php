<?php
/**
 * Cadastro de objetos GrupoUsuario
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 02:53:30
 */
class CadastroGrupoUsuario {
	/**
	 * Repositório de classes GrupoUsuario
	 *
	 * @access private
	 * @var IRepositorioGrupoUsuario
	 */
	private $objRepositorioGrupoUsuario;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioGrupoUsuario $objRepositorioGrupoUsuario
	 */
	public function __construct(IRepositorioGrupoUsuario $objRepositorioGrupoUsuario) {
		$this->objRepositorioGrupoUsuario = $objRepositorioGrupoUsuario;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param GrupoUsuario $objGrupoUsuario
	 * @throws GrupoUsuarioJaCadastradoException
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(GrupoUsuario $objGrupoUsuario) {
		if ($this->existe($objGrupoUsuario->getIdGrupo(), $objGrupoUsuario->getIdUsuario()))
			throw new GrupoUsuarioJaCadastradoException($objGrupoUsuario->getIdGrupo(), $objGrupoUsuario->getIdUsuario());
		return $this->objRepositorioGrupoUsuario->inserir($objGrupoUsuario);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param GrupoUsuario $objGrupoUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(GrupoUsuario $objGrupoUsuario) {
		$this->objRepositorioGrupoUsuario->atualizar($objGrupoUsuario);
	}
	
	/**
	 * Método que remove um objeto do RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdGrupo, $intIdUsuario) {
		$this->objRepositorioGrupoUsuario->remover($intIdGrupo, $intIdUsuario);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @return GrupoUsuario
	 */
	public function procurar($intIdGrupo, $intIdUsuario) {
		return $this->objRepositorioGrupoUsuario->procurar($intIdGrupo, $intIdUsuario);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdGrupo, $intIdUsuario) {
		return $this->objRepositorioGrupoUsuario->existe($intIdGrupo, $intIdUsuario);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioGrupoUsuario
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioGrupoUsuario->listar();
	}
	
	/**
	 * Método que remove todas os Usuários do Grupo especificado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return void
	 */
	public function removerPorIdGrupo($intIdGrupo) {
		$this->objRepositorioGrupoUsuario->removerPorIdGrupo($intIdGrupo);
	}
}