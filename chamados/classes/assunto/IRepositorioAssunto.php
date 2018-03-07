<?php
/**
 * Interface do repositótio da classe Assunto
 * Todos os repositórios da classe Assunto deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:24:40
 */
interface IRepositorioAssunto {
	/**
	 * Assinatura do método que insere um objeto do RepositorioAssunto
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Assunto $objAssunto);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioAssunto
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Assunto $objAssunto);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdAssunto);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @return Assunto
	 */
	public function procurar($intIdAssunto);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioAssunto
	 *
	 * @access public
	 * @param int $intIdAssunto
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdAssunto);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioAssunto
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}