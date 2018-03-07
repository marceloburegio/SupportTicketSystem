<?php
/**
 * Interface do repositótio da classe Feriado
 * Todos os repositórios da classe Feriado deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 26/10/2011 14:47:33
 */
interface IRepositorioFeriado {
	/**
	 * Assinatura do método que insere um objeto do RepositorioFeriado
	 *
	 * @access public
	 * @param Feriado $objFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Feriado $objFeriado);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioFeriado
	 *
	 * @access public
	 * @param Feriado $objFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Feriado $objFeriado);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioFeriado
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdFeriado);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioFeriado
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws FeriadoNaoCadastradoException
	 * @return Feriado
	 */
	public function procurar($intIdFeriado);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioFeriado
	 *
	 * @access public
	 * @param int $intIdFeriado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdFeriado);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioFeriado
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}