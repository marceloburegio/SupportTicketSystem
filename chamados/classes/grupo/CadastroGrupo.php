<?php
/**
 * Cadastro de objetos Grupo
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:25:57
 */
class CadastroGrupo {
	/**
	 * Repositório de classes Grupo
	 *
	 * @access private
	 * @var IRepositorioGrupo
	 */
	private $objRepositorioGrupo;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioGrupo $objRepositorioGrupo
	 */
	public function __construct(IRepositorioGrupo $objRepositorioGrupo) {
		$this->objRepositorioGrupo = $objRepositorioGrupo;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioGrupo
	 *
	 * @access public
	 * @param Grupo $objGrupo
	 * @throws GrupoJaCadastradoException
	 * @throws GrupoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Grupo $objGrupo) {
		if ($this->existe($objGrupo->getIdGrupo()))
			throw new GrupoJaCadastradoException($objGrupo->getIdGrupo());
		return $this->objRepositorioGrupo->inserir($objGrupo);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioGrupo
	 *
	 * @access public
	 * @param Grupo $objGrupo
	 * @throws GrupoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Grupo $objGrupo) {
		$this->objRepositorioGrupo->atualizar($objGrupo);
	}
	
	/**
	 * Método que remove um objeto do RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdGrupo) {
		$this->objRepositorioGrupo->remover($intIdGrupo);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws GrupoNaoCadastradoException
	 * @return Grupo
	 */
	public function procurar($intIdGrupo) {
		return $this->objRepositorioGrupo->procurar($intIdGrupo);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdGrupo) {
		return $this->objRepositorioGrupo->existe($intIdGrupo);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioGrupo
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioGrupo->listar();
	}
	
	/**
	 * Método que lista todos os Grupos Ativos do RepositorioGrupo
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivos() {
		return $this->objRepositorioGrupo->listarAtivos();
	}
	
	/**
	 * Método que lista todos os Grupos Ativos que Recebem Chamados do RepositorioGrupo
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosQueRecebemChamados(){
		return $this->objRepositorioGrupo->listarAtivosQueRecebemChamados();
	}
	
	/**
	 * Método que lista todos os Grupos Ativos Pertencentes ao Usuário informado
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosNormaisPorIdUsuario($intIdUsuario) {
		return $this->objRepositorioGrupo->listarAtivosNormalPorIdUsuario($intIdUsuario);
	}
	
	/**
	 * Método que lista todos os Grupos Ativos Administrados pelo Usuário informado
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosAdminPorIdUsuario($intIdUsuario) {
		return $this->objRepositorioGrupo->listarAtivosAdminPorIdUsuario($intIdUsuario);
	}
}