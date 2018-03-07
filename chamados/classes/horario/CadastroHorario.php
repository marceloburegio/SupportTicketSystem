<?php
/**
 * Cadastro de objetos Horario
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 03/06/2011 00:00:14
 */
class CadastroHorario {
	/**
	 * Repositório de classes Horario
	 *
	 * @access private
	 * @var IRepositorioHorario
	 */
	private $objRepositorioHorario;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 * @param IRepositorioHorario $objRepositorioHorario
	 */
	public function __construct(IRepositorioHorario $objRepositorioHorario) {
		$this->objRepositorioHorario = $objRepositorioHorario;
	}
	
	/**
	 * Método que cadastra um objeto no RepositorioHorario
	 *
	 * @access public
	 * @param Horario $objHorario
	 * @throws HorarioJaCadastradoException
	 * @throws HorarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function cadastrar(Horario $objHorario) {
		if ($this->existe($objHorario->getIdHorario()))
			throw new HorarioJaCadastradoException($objHorario->getIdHorario());
		return $this->objRepositorioHorario->inserir($objHorario);
	}
	
	/**
	 * Método que atualiza um objeto no RepositorioHorario
	 *
	 * @access public
	 * @param Horario $objHorario
	 * @throws HorarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Horario $objHorario) {
		$this->objRepositorioHorario->atualizar($objHorario);
	}
	
	/**
	 * Método que remove um objeto do RepositorioHorario
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdHorario) {
		$this->objRepositorioHorario->remover($intIdHorario);
	}
	
	/**
	 * Método que procura um determinado objeto no RepositorioHorario
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws HorarioNaoCadastradoException
	 * @return Horario
	 */
	public function procurar($intIdHorario) {
		return $this->objRepositorioHorario->procurar($intIdHorario);
	}
	
	/**
	 * Método que verifica se existe um determinado objeto no RepositorioHorario
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdHorario) {
		return $this->objRepositorioHorario->existe($intIdHorario);
	}
	
	/**
	 * Método que lista todos os objetos do RepositorioHorario
	 *
	 * @access public
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar() {
		return $this->objRepositorioHorario->listar();
	}
	
	/**
	 * Método que lista todos os objetos pelo grupo e dia da semana no RepositorioHorario
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intDiaSemana
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdGrupoPorDiaSemana($intIdGrupo, $intDiaSemana) {
		return $this->objRepositorioHorario->listarPorIdGrupoPorDiaSemana($intIdGrupo, $intDiaSemana);
	}
}