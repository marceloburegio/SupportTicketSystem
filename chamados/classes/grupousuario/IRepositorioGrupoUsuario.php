<?php
/**
 * Interface do repositótio da classe GrupoUsuario
 * Todos os repositórios da classe GrupoUsuario deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 02:53:30
 */
interface IRepositorioGrupoUsuario {
	/**
	 * Assinatura do método que insere um objeto do RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param GrupoUsuario $objGrupoUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(GrupoUsuario $objGrupoUsuario);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param GrupoUsuario $objGrupoUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(GrupoUsuario $objGrupoUsuario);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdGrupo, $intIdUsuario);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws GrupoUsuarioNaoCadastradoException
	 * @return GrupoUsuario
	 */
	public function procurar($intIdGrupo, $intIdUsuario);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioGrupoUsuario
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdGrupo, $intIdUsuario);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioGrupoUsuario
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}