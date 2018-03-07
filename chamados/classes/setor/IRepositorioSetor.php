<?php
/**
 * Interface do repositótio da classe Setor
 * Todos os repositórios da classe Setor deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 19/06/2011 00:03:30
 */
interface IRepositorioSetor {
	/**
	 * Assinatura do método que insere um objeto do RepositorioSetor
	 *
	 * @access public
	 * @param Setor $objSetor
	 * @throws SetorNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Setor $objSetor);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioSetor
	 *
	 * @access public
	 * @param Setor $objSetor
	 * @throws SetorNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Setor $objSetor);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioSetor
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdSetor);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioSetor
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws SetorNaoCadastradoException
	 * @return Setor
	 */
	public function procurar($intIdSetor);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioSetor
	 *
	 * @access public
	 * @param int $intIdSetor
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdSetor);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioSetor
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}