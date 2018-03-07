<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioHorarioBDRCustomizado extends RepositorioHorarioBDR {
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Método que lista todos os Horarios pertencentes ao Grupo e do dia da semana informados
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param int $intDiaSemana
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdGrupoPorDiaSemana($intIdGrupo, $intDiaSemana, $strComplemento="") {
		$intIdGrupo = (int) $intIdGrupo;
		$intDiaSemana = (int) $intDiaSemana;
		
		$strSql = "
			AND id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
			AND dia_semana = ". $this->objPDO->quote($intDiaSemana) ."
			$strComplemento";
		return $this->listar($strSql);
	}
}