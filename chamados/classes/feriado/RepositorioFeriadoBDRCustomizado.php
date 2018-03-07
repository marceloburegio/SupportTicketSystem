<?php
/**
 * Repositório de objetos Feriado
 * Esta classe implementa a interface IRepositorioFeriado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 26/10/2011 14:47:33
 */
class RepositorioFeriadoBDRCustomizado extends RepositorioFeriadoBDR {
	/**
	 * Método que lista todos os objetos do RepositorioFeriado pelo Id do Grupo
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdGrupo($intIdGrupo) {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strComplemento = "AND id_grupo = ". $intIdGrupo;
		return parent::listar($strComplemento);
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strDataFeriado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existePorIdGrupoPorDataFeriado($intIdGrupo, $strDataFeriado){
		$intIdGrupo		= (int) $intIdGrupo;
		$strDataFeriado	= (string) $strDataFeriado;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM feriado
			WHERE data_feriado = ". $this->objPDO->quote($strDataFeriado) ."
			AND id_grupo = ". $this->objPDO->quote($intIdGrupo);
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
}