<?php
/**
 * Interface do repositótio da classe Usuario
 * Todos os repositórios da classe Usuario deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 17/06/2011 10:48:32
 */
interface IRepositorioUsuario {
	/**
	 * Assinatura do método que insere um objeto do RepositorioUsuario
	 *
	 * @access public
	 * @param Usuario $objUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Usuario $objUsuario);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioUsuario
	 *
	 * @access public
	 * @param Usuario $objUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Usuario $objUsuario);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioUsuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdUsuario);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws UsuarioNaoCadastradoException
	 * @return Usuario
	 */
	public function procurar($intIdUsuario);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioUsuario
	 *
	 * @access public
	 * @param int $intIdUsuario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdUsuario);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioUsuario
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}