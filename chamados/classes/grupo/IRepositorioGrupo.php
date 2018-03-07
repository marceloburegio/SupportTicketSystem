<?php
/**
 * Interface do repositótio da classe Grupo
 * Todos os repositórios da classe Grupo deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 10/06/2011 07:25:57
 */
interface IRepositorioGrupo {
	/**
	 * Assinatura do método que insere um objeto do RepositorioGrupo
	 *
	 * @access public
	 * @param Grupo $objGrupo
	 * @throws GrupoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Grupo $objGrupo);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioGrupo
	 *
	 * @access public
	 * @param Grupo $objGrupo
	 * @throws GrupoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Grupo $objGrupo);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdGrupo);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws GrupoNaoCadastradoException
	 * @return Grupo
	 */
	public function procurar($intIdGrupo);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioGrupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdGrupo);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioGrupo
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}