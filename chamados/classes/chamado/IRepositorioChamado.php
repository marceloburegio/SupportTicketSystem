<?php
/**
 * Interface do repositótio da classe Chamado
 * Todos os repositórios da classe Chamado deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 09/06/2011 21:26:07
 */
interface IRepositorioChamado {
	/**
	 * Assinatura do método que insere um objeto do RepositorioChamado
	 *
	 * @access public
	 * @param Chamado $objChamado
	 * @throws ChamadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Chamado $objChamado);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioChamado
	 *
	 * @access public
	 * @param Chamado $objChamado
	 * @throws ChamadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Chamado $objChamado);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioChamado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdChamado);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioChamado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws ChamadoNaoCadastradoException
	 * @return Chamado
	 */
	public function procurar($intIdChamado);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioChamado
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdChamado);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioChamado
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}