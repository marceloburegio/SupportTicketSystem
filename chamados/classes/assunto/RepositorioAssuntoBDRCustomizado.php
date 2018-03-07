<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioAssuntoBDRCustomizado extends RepositorioAssuntoBDR {
	/**
	 * Método construtor da classe
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Assunto $objAssunto
	 * @throws AssuntoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Assunto $objAssunto) {
			if ($objAssunto != null) {
			$intStatusAssunto = ($objAssunto->getStatusAssunto()) ? 1 : 0;
			$strSql = "
				INSERT INTO assunto (
					id_grupo,
					descricao_assunto,
					status_assunto,
					sla,
					alerta_chamado,
					formato_chamado,
					url_chamado_externo
				)
				VALUES (
					". $this->objPDO->quote($objAssunto->getIdGrupo()) .",
					". $this->objPDO->quote($objAssunto->getDescricaoAssunto()) .",
					". $this->objPDO->quote($intStatusAssunto) .",
					". $this->objPDO->quote($objAssunto->getSla()) .",
					". $this->objPDO->quote($objAssunto->getAlertaChamado()) .",
					". $this->objPDO->quote($objAssunto->getFormatoChamado()) .",
					". $this->objPDO->quote($objAssunto->getUrlChamadoExterno()) ."
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
			throw new AssuntoNaoCadastradoException(null);
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
			$strComplemento
			ORDER BY descricao_assunto ASC";
		return parent::listar($strSql);
	}
	
	/**
	 * Método que lista todos os Assuntos Ativos do Repositorio BDR
	 *
	 * @access public
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivos($strComplemento="") {
		$strSql = "
			AND status_assunto = 1
			$strComplemento";
		return $this->listar($strSql);
	}
	
	/**
	 * Método que lista todos os Assuntos do Grupo informado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorIdGrupo($intIdGrupo, $strComplemento="") {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql = "
			AND id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
			$strComplemento";
		return $this->listar($strSql);
	}
	
	/**
	 * Método que lista todos os Assuntos Ativos do Grupo informado
	 *
	 * @access public
	 * @param int $intIdGrupo
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivosPorIdGrupo($intIdGrupo, $strComplemento="") {
		$intIdGrupo = (int) $intIdGrupo;
		
		$strSql = "
			AND id_grupo = ". $this->objPDO->quote($intIdGrupo) ."
			$strComplemento";
		return $this->listarAtivos($strSql);
	}
}