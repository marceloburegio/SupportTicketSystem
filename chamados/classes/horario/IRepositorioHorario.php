<?php
/**
 * Interface do repositótio da classe Horario
 * Todos os repositórios da classe Horario deverão implementar esta interface
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 03/06/2011 00:00:14
 */
interface IRepositorioHorario {
	/**
	 * Assinatura do método que insere um objeto do RepositorioHorario
	 *
	 * @access public
	 * @param Horario $objHorario
	 * @throws HorarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Horario $objHorario);
	
	/**
	 * Assinatura do método que atualiza um objeto do RepositorioHorario
	 *
	 * @access public
	 * @param Horario $objHorario
	 * @throws HorarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Horario $objHorario);
	
	/**
	 * Assinatura do método que remove um objeto do RepositorioHorario
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdHorario);
	
	/**
	 * Assinatura do método que procura um determinado objeto no RepositorioHorario
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws HorarioNaoCadastradoException
	 * @return Horario
	 */
	public function procurar($intIdHorario);
	
	/**
	 * Assinatura do método que verifica se existe um determinado objeto no RepositorioHorario
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdHorario);
	
	/**
	 * Assinatura do método que lista todos os objetos do RepositorioHorario
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar();
	
}