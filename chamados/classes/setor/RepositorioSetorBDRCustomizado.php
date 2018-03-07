<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioSetorBDRCustomizado extends RepositorioSetorBDR {
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
	 * @param Setor $objSetor
	 * @throws SetorNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Setor $objSetor) {
		if ($objSetor != null) {
			$intStatusSetor = ($objSetor->getStatusSetor()) ? 1 : 0;
			$strSql = "
				INSERT INTO setor (
					descricao_setor,
					codigo_centro_custo,
					status_setor
				)
				VALUES (
					". $this->objPDO->quote($objSetor->getDescricaoSetor()) .",
					". $this->objPDO->quote($objSetor->getCodigoCentroCusto()) .",
					". $this->objPDO->quote($intStatusSetor) ."
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
			throw new SetorNaoCadastradoException(null);
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
			ORDER BY descricao_setor ASC";
		return parent::listar($strSql);
	}
	
	/**
	 * Método que lista todos os Setores Ativos do Repositorio BDR
	 *
	 * @access public
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarAtivos($strComplemento="") {
		$strSql = "
			AND status_setor = 1
			$strComplemento";
		return $this->listar($strSql);
	}
}