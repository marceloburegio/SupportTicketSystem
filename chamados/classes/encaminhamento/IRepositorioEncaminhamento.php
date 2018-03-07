<?php
/**
 * Interface do repositótio da classe Encaminhamento
 * Todos os repositórios da classe Encaminhamento deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 23:06:26
 */
interface IRepositorioEncaminhamento {
	/**
	 * Assinatura do método que insere um objeto do RepositorioEncaminhamento
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Encaminhamento $objEncaminhamento);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioEncaminhamento
	 *
	 * @access public
	 * @param Encaminhamento $objEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Encaminhamento $objEncaminhamento);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdEncaminhamento);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws EncaminhamentoNaoCadastradoException
	 * @return Encaminhamento
	 */
	public function procurar($intIdEncaminhamento);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioEncaminhamento
	 *
	 * @access public
	 * @param int $intIdEncaminhamento
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdEncaminhamento);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioEncaminhamento
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}