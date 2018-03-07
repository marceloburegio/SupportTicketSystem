<?php
/**
 * Repositório de objetos Chamado
 * Esta classe implementa a interface IRepositorioChamado
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 08/07/2011 13:28:16
 */
class RepositorioChamadoBDR implements IRepositorioChamado {
	/**
	 * Objeto da conexão
	 *
	 * @access protected
	 * @var ConexaoChamado
	 */
	protected $objConexaoChamado;
	
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
		$this->objConexaoChamado = ConexaoBDR::getInstancia("sistema");
		$this->objPDO     = $this->objConexaoChamado->getConexao();
	}
	
	/**
	 * Método que insere um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Chamado $objChamado
	 * @throws ChamadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Chamado $objChamado) {
		if ($objChamado != null) {
			$strSql = "
				INSERT INTO chamado (
					id_chamado,
					id_assunto,
					id_usuario_origem,
					id_usuario_destino,
					id_grupo_destino,
					id_usuario_fechador,
					codigo_prioridade,
					descricao_chamado,
					justificativa_prioridade,
					status_chamado,
					data_abertura,
					data_prazo,
					data_fechamento,
					status_email,
					email_contato,
					codigo_chamado_externo
				)
				VALUES (
					". $this->objPDO->quote($objChamado->getIdChamado()) .",
					". $this->objPDO->quote($objChamado->getIdAssunto()) .",
					". $this->objPDO->quote($objChamado->getIdUsuarioOrigem()) .",
					". $this->objPDO->quote($objChamado->getIdUsuarioDestino()) .",
					". $this->objPDO->quote($objChamado->getIdGrupoDestino()) .",
					". $this->objPDO->quote($objChamado->getIdUsuarioFechador()) .",
					". $this->objPDO->quote($objChamado->getCodigoPrioridade()) .",
					". $this->objPDO->quote($objChamado->getDescricaoChamado()) .",
					". $this->objPDO->quote($objChamado->getJustificativaPrioridade()) .",
					". $this->objPDO->quote($objChamado->getStatusChamado()) .",
					". $this->objPDO->quote($objChamado->getDataAbertura()) .",
					". $this->objPDO->quote($objChamado->getDataPrazo()) .",
					". $this->objPDO->quote($objChamado->getDataFechamento()) .",
					". $this->objPDO->quote($objChamado->getStatusEmail()) .",
					". $this->objPDO->quote($objChamado->getEmailCopia()) .",
					". $this->objPDO->quote($objChamado->getCodigoChamadoExterno()) ."
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
			throw new ChamadoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que atualiza um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param Chamado $objChamado
	 * @throws ChamadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return void
	 */
	public function atualizar(Chamado $objChamado) {
		if ($objChamado != null) {
			$strSql = "
				UPDATE chamado SET
					id_assunto               = ". $this->objPDO->quote($objChamado->getIdAssunto()) .",
					id_usuario_origem        = ". $this->objPDO->quote($objChamado->getIdUsuarioOrigem()) .",
					id_usuario_destino       = ". $this->objPDO->quote($objChamado->getIdUsuarioDestino()) .",
					id_grupo_destino         = ". $this->objPDO->quote($objChamado->getIdGrupoDestino()) .",
					id_usuario_fechador      = ". $this->objPDO->quote($objChamado->getIdUsuarioFechador()) .",
					codigo_prioridade        = ". $this->objPDO->quote($objChamado->getCodigoPrioridade()) .",
					descricao_chamado        = ". $this->objPDO->quote($objChamado->getDescricaoChamado()) .",
					justificativa_prioridade = ". $this->objPDO->quote($objChamado->getJustificativaPrioridade()) .",
					status_chamado           = ". $this->objPDO->quote($objChamado->getStatusChamado()) .",
					data_abertura            = ". $this->objPDO->quote($objChamado->getDataAbertura()) .",
					data_prazo               = ". $this->objPDO->quote($objChamado->getDataPrazo()) .",
					data_fechamento          = ". $this->objPDO->quote($objChamado->getDataFechamento()) .",
					status_email             = ". $this->objPDO->quote($objChamado->getStatusEmail()) .",
					codigo_chamado_externo   = ". $this->objPDO->quote($objChamado->getCodigoChamadoExterno()) ."
				WHERE id_chamado = ". $this->objPDO->quote($objChamado->getIdChamado()) ."";
			try {
				$this->objPDO->exec($strSql);
			}
			catch(PDOException $ex) {
				throw new RepositorioException($ex->getMessage());
			}
		}
		else {
			throw new ChamadoNaoCadastradoException(null);
		}
	}
	
	/**
	 * Método que remove um objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return void
	 */
	public function remover($intIdChamado) {
		$intIdChamado = (int) $intIdChamado;
		
		$strSql = "
			DELETE FROM chamado
			WHERE id_chamado = ". $this->objPDO->quote($intIdChamado) ."";
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
	 * @param int $intIdChamado
	 * @throws ChamadoNaoCadastradoException
	 * @return Chamado
	 */
	public function procurar($intIdChamado) {
		$intIdChamado = (int) $intIdChamado;
		
		$strSql ="
			AND id_chamado = ". $this->objPDO->quote($intIdChamado) ."";
		$arrObjChamado = $this->listar($strSql);
		if (!empty($arrObjChamado) && is_array($arrObjChamado)) {
			return $arrObjChamado[0];
		}
		else {
			throw new ChamadoNaoCadastradoException($intIdChamado);
		}
	}
	
	/**
	 * Método que verifica a existencia de um determinado objeto no Repositorio BDR
	 *
	 * @access public
	 * @param int $intIdChamado
	 * @throws RepositorioException
	 * @return boolean
	 */
	public function existe($intIdChamado) {
		$intIdChamado = (int) $intIdChamado;
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM chamado
			WHERE id_chamado = ". $this->objPDO->quote($intIdChamado) ."";
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
				id_chamado,
				id_assunto,
				id_usuario_origem,
				id_usuario_destino,
				id_grupo_destino,
				id_usuario_fechador,
				codigo_prioridade,
				descricao_chamado,
				justificativa_prioridade,
				status_chamado,
				data_abertura,
				data_prazo,
				data_fechamento,
				status_email,
				codigo_chamado_externo
			FROM chamado
			WHERE id_chamado IS NOT NULL
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjChamado = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrObjChamado[] = new Chamado($arrResult["id_chamado"], $arrResult["id_assunto"], $arrResult["id_usuario_origem"], $arrResult["id_usuario_destino"], $arrResult["id_grupo_destino"], $arrResult["id_usuario_fechador"], $arrResult["codigo_prioridade"], $arrResult["descricao_chamado"], $arrResult["justificativa_prioridade"], $arrResult["status_chamado"], $arrResult["data_abertura"], $arrResult["data_prazo"], $arrResult["data_fechamento"], $arrResult["status_email"], $arrResult["codigo_chamado_externo"]);
				}
			}
			return $arrObjChamado;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
}