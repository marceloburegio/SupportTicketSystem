<?php
/**
 * Interface do repositótio da classe Historico
 * Todos os repositórios da classe Historico deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:28:24
 */
interface IRepositorioHistorico {
	/**
	 * Assinatura do método que insere um objeto do RepositorioHistorico
	 *
	 * @access public
	 * @param Historico $objHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Historico $objHistorico);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioHistorico
	 *
	 * @access public
	 * @param Historico $objHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Historico $objHistorico);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioHistorico
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdHistorico);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioHistorico
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws HistoricoNaoCadastradoException
	 * @return Historico
	 */
	public function procurar($intIdHistorico);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioHistorico
	 *
	 * @access public
	 * @param int $intIdHistorico
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdHistorico);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioHistorico
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}