<?php
/**
 * Repositório de objetos Horario
 * Esta classe implementa a interface IRepositorioHorario
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:32:09
 */
class RepositorioHorarioBDR implements IRepositorioHorario {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoHorario
	 */
	protected $objConexaoHorario;
	
	/**
	 * Objeto PDO
	 *
	 * @access protected
	 * @var PDO
	 */
	protected $objPDO;
	
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct() {
		$this->objConexaoHorario = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoHorario->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Horario $objHorario
	 * @throws HorarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Horario $objHorario) {
		if ($objHorario != null) {
			$strSql = "
				INSERT INTO horario (
					id_horario,
					id_grupo,
					dia_semana,
					inicio_horario,
					termino_horario
				)
				VALUES (
					". $this->objPDO->quote($objHorario->getIdHorario()) .",
					". $this->objPDO->quote($objHorario->getIdGrupo()) .",
					". $this->objPDO->quote($objHorario->getDiaSemana()) .",
					". $this->objPDO->quote($objHorario->getInicioHorario()) .",
					". $this->objPDO->quote($objHorario->getTerminoHorario()) ."
				)";
			try {
				$this->objPDO->exec($strSql);
				return $this->objPDO->lastInsertId();
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new HorarioNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Horario $objHorario
	 * @throws HorarioNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Horario $objHorario) {
		if ($objHorario != null) {
			$strSql = "
				UPDATE horario SET
					id_grupo        = ". $this->objPDO->quote($objHorario->getIdGrupo()) .",
					dia_semana      = ". $this->objPDO->quote($objHorario->getDiaSemana()) .",
					inicio_horario  = ". $this->objPDO->quote($objHorario->getInicioHorario()) .",
					termino_horario = ". $this->objPDO->quote($objHorario->getTerminoHorario()) ."
				WHERE id_horario = ". $this->objPDO->quote($objHorario->getIdHorario()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new HorarioNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdHorario) {
		$intIdHorario = (int) $intIdHorario;
		
		$strSql = "
			DELETE FROM horario
			WHERE id_horario = ". $this->objPDO->quote($intIdHorario) ."";
		try {
			$this->objPDO->exec($strSql);
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que procura um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws HorarioNaoCadastradoException
	 * @return Horario
	 */
	public function procurar($intIdHorario) {
		$intIdHorario = (int) $intIdHorario;
		
		$strSql ="
			AND id_horario = ". $this->objPDO->quote($intIdHorario) ."";
		$arrObjHorario = $this->listar($strSql);
		if (!empty($arrObjHorario) && is_array($arrObjHorario)) {
			return $arrObjHorario[0];
		}
		else {
			throw new HorarioNaoCadastradoException($intIdHorario);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdHorario
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdHorario) {
		$intIdHorario = (int) $intIdHorario;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM horario
			WHERE id_horario = ". $this->objPDO->quote($intIdHorario) ."";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResult = $objResult->fetch(PDO::FETCH_ASSOC);
			if (!empty($arrResult) && is_array($arrResult) && $arrResult["quantidade"] > 0) {
				return true;
			}
			else {
				return false;
			}
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que lista todos os objetos do Repositorio BDR
	 *
	 * @access public
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listar($strComplemento="") {
		$strSql = "
			SELECT
				id_horario,
				id_grupo,
				dia_semana,
				inicio_horario,
				termino_horario
			FROM horario
			WHERE id_horario IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjHorario = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrObjHorario[] = new Horario($arrResult["id_horario"], $arrResult["id_grupo"], $arrResult["dia_semana"], $arrResult["inicio_horario"], $arrResult["termino_horario"]);
				}
			}
			return $arrObjHorario;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}