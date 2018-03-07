<?php
/**
 * Repositório Customizado
 * Esta classe estende a classe original
 *
 * @author Marcelo Burégio
 * @version 1.0
 * @since 28/05/2011 01:35:41
 */
class RepositorioChamadoBDRCustomizado extends RepositorioChamadoBDR {
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
	 * @param Chamado $objChamado
	 * @throws ChamadoNaoCadastradoException
	 * @throws RepositorioException
	 * @return int
	 */
	public function inserir(Chamado $objChamado) {
		if ($objChamado != null) {
			$strSql = "
				INSERT INTO chamado (
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
				email_contato,
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
					$arrObjChamado[] = new Chamado($arrResult["id_chamado"], $arrResult["id_assunto"], $arrResult["id_usuario_origem"], $arrResult["id_usuario_destino"], $arrResult["id_grupo_destino"], $arrResult["id_usuario_fechador"], $arrResult["codigo_prioridade"], $arrResult["descricao_chamado"], $arrResult["justificativa_prioridade"], $arrResult["status_chamado"], $arrResult["data_abertura"], $arrResult["data_prazo"], $arrResult["data_fechamento"], $arrResult["status_email"], $arrResult["email_contato"], $arrResult["codigo_chamado_externo"]);
				}
			}
			return $arrObjChamado;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que lista todos os objetos do Repositorio BDR
	 *
	 * @access public
	 * @param int $intOffSet
	 * @param int $intRows
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarComPaginacao($intOffSet, $intRows, $strComplemento="") {
		$intOffSet = (int) $intOffSet;
		$intRows = (int) $intRows;
		
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
				email_contato,
				codigo_chamado_externo
			FROM chamado
			WHERE id_chamado IS NOT NULL
			$strComplemento
			ORDER BY data_prazo ASC, data_abertura ASC
			LIMIT ". $intRows ." OFFSET ". $intOffSet;
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResults = $objResult->fetchAll(PDO::FETCH_ASSOC);
			$arrObjChamado = array();
			if (!empty($arrResults) && is_array($arrResults)) {
				foreach ($arrResults as $arrResult) {
					$arrObjChamado[] = new Chamado($arrResult["id_chamado"], $arrResult["id_assunto"], $arrResult["id_usuario_origem"], $arrResult["id_usuario_destino"], $arrResult["id_grupo_destino"], $arrResult["id_usuario_fechador"], $arrResult["codigo_prioridade"], $arrResult["descricao_chamado"], $arrResult["justificativa_prioridade"], $arrResult["status_chamado"], $arrResult["data_abertura"], $arrResult["data_prazo"], $arrResult["data_fechamento"], $arrResult["status_email"], $arrResult["email_contato"], $arrResult["codigo_chamado_externo"]);
				}
			}
			return $arrObjChamado;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que lista todos os chamados por Parametros no Repositorio BDR
	 *
	 * @access public
	 * @param array $arrParametro
	 * @param int $intOffSet
	 * @param int $intRows
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarPorParametro($arrParametro, $intOffSet, $intRows, $strComplemento="") {
		$strDataInicial = (string) @$arrParametro["strDataInicial"];
		$strDataFinal = (string) @$arrParametro["strDataFinal"];
		$intStatus = (int) @$arrParametro["intStatus"];
		$intIdGrupo = (int) @$arrParametro["intIdGrupo"];
		$intIdChamado = (int) @$arrParametro["intIdChamado"];
		$strCodigoChamadoExterno = (string) @$arrParametro["strCodigoChamadoExterno"];
		$strNomeUsuarioOrigem = (string) @$arrParametro["strNomeUsuarioOrigem"];
		$strNomeUsuarioFechador = (string) @$arrParametro["strNomeUsuarioFechador"];
		$strDescricaoAssunto = (string) @$arrParametro["strDescricaoAssunto"];
		$strDescricaoChamado = (string) @$arrParametro["strDescricaoChamado"];
		$strDescricaoHistorico = (string) @$arrParametro["strDescricaoHistorico"];
		$intIdSetor = (int) @$arrParametro["intIdSetor"];
		$intOffSet = (int) $intOffSet;
		$intRows = (int) $intRows;
		
		$strSql = "
			AND data_abertura BETWEEN ". $this->objPDO->quote($strDataInicial . " 00:00:00") ." AND ". $this->objPDO->quote($strDataFinal ." 23:59:59");
		if ($intStatus > 0) {
			$strSql .= "
				AND status_chamado = ". $this->objPDO->quote($intStatus);
		}
		elseif ($intStatus == -1) {
			$strSql .= "
				AND status_chamado IN (1,3)";
		}
		if ($intIdGrupo > 0) {
			$strSql .= "
				AND id_grupo_destino = ". $this->objPDO->quote($intIdGrupo);
		}
		if ($intIdChamado > 0) {
			$strSql .= "
				AND id_chamado = ". $this->objPDO->quote($intIdChamado);
		}
		if (strlen($strCodigoChamadoExterno) > 0) {
			$strSql .= "
				AND codigo_chamado_externo = ". $this->objPDO->quote($strCodigoChamadoExterno);
		}
		if (strlen($strNomeUsuarioOrigem) > 0) {
			$strSql .= "
				AND id_usuario_origem IN (
					SELECT id_usuario
					FROM usuario
					WHERE nome_usuario LIKE ". $this->objPDO->quote("%". $strNomeUsuarioOrigem ."%") ."
				)";
		}
		if (strlen($strDescricaoAssunto) > 0) {
			$strSql .= "
 				AND id_assunto IN (
					SELECT id_assunto
					FROM assunto
					WHERE descricao_assunto LIKE ". $this->objPDO->quote("%". $strDescricaoAssunto ."%") ."
				)";
		}
		if (strlen($strDescricaoChamado) > 0) {
			$strSql .= "
				AND (descricao_chamado LIKE ". $this->objPDO->quote("%". $strDescricaoChamado ."%") ." OR justificativa_prioridade LIKE ". $this->objPDO->quote("%". $strDescricaoChamado ."%") .")";
		}
		if (strlen($strDescricaoHistorico) > 0) {
			$strSql .= "
				AND id_chamado IN (
					SELECT id_chamado
					FROM historico
					WHERE descricao_historico LIKE ". $this->objPDO->quote("%". $strDescricaoHistorico ."%") ."
				)";
		}
		if ($intIdSetor > 0) {
			$strSql .= "
				AND id_usuario_origem IN (
					SELECT id_usuario
					FROM usuario
					WHERE id_setor = ". $this->objPDO->quote($intIdSetor) ."
				)";
		}
		if (strlen($strNomeUsuarioFechador) > 0) {
			$strSql .= "
				AND id_usuario_fechador IN (
					SELECT id_usuario
					FROM usuario
					WHERE nome_usuario LIKE ". $this->objPDO->quote("%". $strNomeUsuarioFechador ."%") ."
				)";
		}
		$strSql .= "
			$strComplemento";
		return $this->listarComPaginacao($intOffSet, $intRows, $strSql);
	}
	
	/**
	 * Método que lista todos os chamados enviados pelo Usuário por Parametros no Repositorio BDR
	 *
	 * @access public
	 * @param array $arrParametro
	 * @param int $intOffSet
	 * @param int $intRows
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarEnviadosPorParametro($arrParametro, $intOffSet, $intRows, $strComplemento="") {
		$intIdUsuario = (int) @$arrParametro["intIdUsuario"];
		$intOffSet = (int) $intOffSet;
		$intRows = (int) $intRows;
		
		$strSql = "
			AND (
				id_usuario_origem = ". $this->objPDO->quote($intIdUsuario) ."
				OR id_usuario_origem IN (
					SELECT id_usuario
					FROM grupo_usuario
					WHERE id_grupo IN (
						SELECT id_grupo
						FROM grupo_usuario
						WHERE id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
						AND flag_admin = 1
					)
					AND flag_admin = 0
				)
			)
			$strComplemento";
		return $this->listarPorParametro($arrParametro, $intOffSet, $intRows, $strSql);
	}
	
	/**
	 * Método que lista todos os chamados recebidos por Parametros no Repositorio BDR
	 *
	 * @access public
	 * @param array $arrParametro
	 * @param int $intOffSet
	 * @param int $intRows
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function listarRecebidosPorParametro($arrParametro, $intOffSet, $intRows, $strComplemento="") {
		$intIdUsuario = (int) @$arrParametro["intIdUsuario"];
		$intOffSet = (int) $intOffSet;
		$intRows = (int) $intRows;
		
		// Chamados do Usuário
		$strSql = "
			AND (
				id_usuario_destino = ". $this->objPDO->quote($intIdUsuario);
		
		// Chamados do Grupo
		$strSql .= "
				OR (
					id_grupo_destino IN (
						SELECT id_grupo
						FROM grupo_usuario
						WHERE grupo_usuario.id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
					)
					AND id_usuario_destino = 0
				)
				OR (";
		
		// Chamados do Administrador
		$strSql .= "
					id_grupo_destino IN (
						SELECT id_grupo
						FROM grupo_usuario
						WHERE grupo_usuario.id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
						AND grupo_usuario.flag_admin = 1
					)
				)
			)";
		$strSql .= "
			$strComplemento";
		return $this->listarPorParametro($arrParametro, $intOffSet, $intRows, $strSql);
	}
	
	/**
	 * Método que calcula a quantidade de chamados por Parametros no Repositorio BDR
	 *
	 * @access public
	 * @param array $arrParametro
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function quantidadePorParametro($arrParametro, $strComplemento="") {
		$strDataInicial = (string) @$arrParametro["strDataInicial"];
		$strDataFinal = (string) @$arrParametro["strDataFinal"];
		$intStatus = (int) @$arrParametro["intStatus"];
		$intIdGrupo = (int) @$arrParametro["intIdGrupo"];
		$intIdChamado = (int) @$arrParametro["intIdChamado"];
		$strCodigoChamadoExterno = (string) @$arrParametro["strCodigoChamadoExterno"];
		$strNomeUsuarioOrigem = (string) @$arrParametro["strNomeUsuarioOrigem"];
		$strNomeUsuarioFechador = (string) @$arrParametro["strNomeUsuarioFechador"];
		$strDescricaoAssunto = (string) @$arrParametro["strDescricaoAssunto"];
		$strDescricaoChamado = (string) @$arrParametro["strDescricaoChamado"];
		$strDescricaoHistorico = (string) @$arrParametro["strDescricaoHistorico"];
		$intIdSetor = (int) @$arrParametro["intIdSetor"];
		
		$strSql = "
			SELECT COUNT(*) AS quantidade
			FROM chamado
			WHERE id_chamado IS NOT NULL";
		if (strlen($strDataInicial) > 0 && strlen($strDataFinal) > 0) {
			$strSql .= "
				AND data_abertura BETWEEN ". $this->objPDO->quote($strDataInicial ." 00:00:00") ." AND ". $this->objPDO->quote($strDataFinal ." 23:59:59");
		}
		if ($intStatus > 0) {
			$strSql .= "
				AND status_chamado = ". $this->objPDO->quote($intStatus);
		}
		elseif ($intStatus == -1) {
			$strSql .= "
				AND status_chamado IN (1,3)";
		}
		if ($intIdGrupo > 0) {
			$strSql .= "
				AND id_grupo_destino = ". $this->objPDO->quote($intIdGrupo);
		}
		if ($intIdChamado > 0) {
			$strSql .= "
				AND id_chamado = ". $this->objPDO->quote($intIdChamado);
		}
		if (strlen($strCodigoChamadoExterno) > 0) {
			$strSql .= "
				AND codigo_chamado_externo = ". $this->objPDO->quote($strCodigoChamadoExterno);
		}
		if (strlen($strNomeUsuarioOrigem) > 0) {
			$strSql .= "
				AND id_usuario_origem IN (
					SELECT id_usuario
					FROM usuario
					WHERE nome_usuario LIKE ". $this->objPDO->quote("%". $strNomeUsuarioOrigem ."%") ."
				)";
		}
		if (strlen($strDescricaoAssunto) > 0) {
			$strSql .= "
 				AND id_assunto IN (
					SELECT id_assunto
					FROM assunto
					WHERE descricao_assunto LIKE ". $this->objPDO->quote("%". $strDescricaoAssunto ."%") ."
				)";
		}
		if (strlen($strDescricaoChamado) > 0) {
			$strSql .= "
				AND (descricao_chamado LIKE ". $this->objPDO->quote("%". $strDescricaoChamado ."%") ." OR justificativa_prioridade LIKE ". $this->objPDO->quote("%". $strDescricaoChamado ."%") .")";
		}
		if (strlen($strDescricaoHistorico) > 0) {
			$strSql .= "
				AND id_chamado IN (
					SELECT id_chamado
					FROM historico
					WHERE descricao_historico LIKE ". $this->objPDO->quote("%". $strDescricaoHistorico ."%") ."
				)";
		}
		if ($intIdSetor > 0) {
			$strSql .= "
				AND id_usuario_origem IN (
					SELECT id_usuario
					FROM usuario
					WHERE id_setor = ". $this->objPDO->quote($intIdSetor) ."
				)";
		}
		if (strlen($strNomeUsuarioFechador) > 0) {
			$strSql .= "
				AND id_usuario_fechador IN (
					SELECT id_usuario
					FROM usuario
					WHERE nome_usuario LIKE ". $this->objPDO->quote("%". $strNomeUsuarioFechador ."%") ."
				)";
		}
		$strSql .= "
			$strComplemento";
		try {
			$objResult = $this->objPDO->query($strSql);
			$arrResult = $objResult->fetch(PDO::FETCH_ASSOC);
			$intQuantidade = 0;
			if (!empty($arrResult) && is_array($arrResult)) $intQuantidade = $arrResult["quantidade"];
			return $intQuantidade;
		}
		catch(PDOException $ex) {
			throw new RepositorioException($ex->getMessage());
		}
	}
	
	/**
	 * Método que calcula a quantidade de chamados enviados por Parametros no Repositorio BDR
	 *
	 * @access public
	 * @param array $arrParametro
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function quantidadeEnviadosPorParametro($arrParametro, $strComplemento="") {
		$intIdUsuario = (int) @$arrParametro["intIdUsuario"];
		
		$strSql = "
			AND (
				id_usuario_origem = ". $this->objPDO->quote($intIdUsuario) ."
				OR id_usuario_origem IN (
					SELECT id_usuario
					FROM grupo_usuario
					WHERE id_grupo IN (
						SELECT id_grupo
						FROM grupo_usuario
						WHERE id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
						AND flag_admin = 1
					)
					AND flag_admin = 0
				)
			)
			$strComplemento";
		return $this->quantidadePorParametro($arrParametro, $strSql);
	}
	
	/**
	 * Método que calcula a quantidade de chamados recebidos por Parametros no Repositorio BDR
	 *
	 * @access public
	 * @param array $arrParametro
	 * @param string $strComplemento=""
	 * @throws RepositorioException
	 * @return array
	 */
	public function quantidadeRecebidosPorParametro($arrParametro, $strComplemento="") {
		$intIdUsuario = (int) @$arrParametro["intIdUsuario"];
		
		$strSql = "
			AND (
				-- Chamados do Usuário
				id_usuario_destino = ". $this->objPDO->quote($intIdUsuario) ."
				OR (
					-- Chamados do Grupo
					id_grupo_destino IN (
						SELECT id_grupo
						FROM grupo_usuario
						WHERE grupo_usuario.id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
					)
					AND id_usuario_destino = 0
				)
				OR (
					-- Chamados do Administrador
					id_grupo_destino IN (
						SELECT id_grupo
						FROM grupo_usuario
						WHERE grupo_usuario.id_usuario = ". $this->objPDO->quote($intIdUsuario) ."
						AND grupo_usuario.flag_admin = 1
					)
				)
			)
			$strComplemento";
		return $this->quantidadePorParametro($arrParametro, $strSql);
	}
}